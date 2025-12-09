<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $grade = optional($user->enrollment)->grade_level;
        $strand = optional($user->enrollment)->strand;

        $announcements = Announcement::active()
            ->forAudience($grade, $strand, 'student')
            ->byPriority()
            ->with('user')
            ->paginate(10);

        return view('student.announcements.index', compact('announcements'));
    }
}

