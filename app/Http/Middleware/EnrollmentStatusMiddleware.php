<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnrollmentStatusMiddleware
{
    /**
     * Handle an incoming request.
     * Ensures student has approved enrollment before accessing certain features
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Only apply to students
        if ($user->role === 'student') {
            $enrollment = $user->enrollment;
            
            if (!$enrollment || $enrollment->status !== 'approved') {
                return redirect()->route('student.dashboard')
                    ->with('error', 'Your enrollment must be approved to access this feature.');
            }
        }

        return $next($request);
    }
}