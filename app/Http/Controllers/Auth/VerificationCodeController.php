<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\VerificationCode;
use App\Mail\EmailVerificationCode;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class VerificationCodeController extends Controller
{
    /**
     * Show the verification code input form.
     */
    public function showForm(): View|RedirectResponse
    {
        $user = Auth::user();
        
        // Check if user is already verified
        if ($user && $user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')
                ->with('info', 'Your email is already verified.');
        }

        return view('auth.verify-code');
    }

    /**
     * Verify the submitted code.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Please log in to verify your email.');
        }

        // Find the verification code
        $verificationCode = VerificationCode::where('user_id', $user->id)
            ->where('email', $user->email)
            ->where('code', $request->code)
            ->where('is_used', false)
            ->first();

        if (!$verificationCode) {
            return back()
                ->withErrors(['code' => 'Invalid verification code.'])
                ->withInput();
        }

        if ($verificationCode->isExpired()) {
            return back()
                ->withErrors(['code' => 'Verification code has expired. Please request a new one.'])
                ->withInput();
        }

        // Mark code as used and verify email
        $verificationCode->markAsUsed();
        $user->markEmailAsVerified();

        return redirect()->route('dashboard')
            ->with('success', 'Email verified successfully! You can now proceed with enrollment.');
    }

    /**
     * Resend verification code.
     */
    public function resend(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Please log in to resend verification code.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')
                ->with('info', 'Your email is already verified.');
        }

        // Generate new verification code
        $verificationCode = VerificationCode::createForUser($user);
        
        // Send verification code email
        Mail::to($user->email)->send(new EmailVerificationCode($user, $verificationCode));

        return back()
            ->with('success', 'A new verification code has been sent to your email.');
    }
}
