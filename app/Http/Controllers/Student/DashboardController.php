<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $grade = optional($user->enrollment)->grade_level;
        $strand = optional($user->enrollment)->strand;

        $announcements = Announcement::active()
            ->forAudience($grade, $strand, 'student')
            ->byPriority()
            ->with('user')
            ->take(5)
            ->get();

        // Provide latest enrollment info for dynamic status on dashboard
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->latest()
            ->first();
        return view('student.dashboard', compact('announcements', 'enrollment'));
    }
}
