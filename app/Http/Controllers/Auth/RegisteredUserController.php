<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationCode;
use App\Mail\EmailVerificationCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:student,teacher'],
            'verification_code' => ['required', 'string'],
            'privacy_consent' => ['accepted'],
            'consent_version' => ['nullable', 'string', 'max:50'],
        ]);

        // Verify the verification code using VerificationCode model
        $verificationCode = VerificationCode::where('email', $request->email)
            ->where('code', $request->verification_code)
            ->where('expires_at', '>', now())
            ->where('is_used', false)
            ->first();

        if (!$verificationCode) {
            return back()->withErrors(['verification_code' => 'Invalid or expired verification code.']);
        }

        // Mark the verification code as used
        $verificationCode->markAsUsed();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'consented_at' => now(),
            'consent_version' => $request->consent_version ?: 'v1.0',
        ]);

        event(new Registered($user));

        return redirect()->route('login', ['role' => 'student'])->with('status', 'Account created successfully! You can now log in with your credentials.');
    }

    public function sendCode(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

            // Create a verification code for the email
            $verificationCode = VerificationCode::createForEmail($request->email);

            // Create a temporary user object for the email
            $tempUser = (object)[
                'name' => 'User', // Temporary name since we don't have it yet
                'email' => $request->email
            ];

            // Send verification code email
            Mail::to($request->email)->send(new EmailVerificationCode($tempUser, $verificationCode));

            return response()->json([
                'success' => true,
                'message' => 'Verification code sent to your email.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification code. Please try again.'
            ], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'verification_code' => ['required', 'string', 'size:6'],
        ]);

        $verificationCode = VerificationCode::where('email', $request->email)
            ->where('code', $request->verification_code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verificationCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired verification code.'
            ]);
        }

        // Mark code as verified in session
        Session::put('code_verified', true);
        Session::put('verified_email', $request->email);

        return response()->json([
            'success' => true,
            'message' => 'Code verified successfully.'
        ]);
    }
}
