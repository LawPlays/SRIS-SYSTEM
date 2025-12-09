<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    public function create(Request $request)
    {
        $role = $request->query('role');
        return view('auth.login', compact('role'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => trans('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        // Block suspended teacher accounts from logging in
        if (Auth::user()->role === 'teacher' && Auth::user()->status === 'suspended') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Your account has been suspended. Please contact your administrator or principal.',
            ]);
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }

        return redirect()->route('student.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
