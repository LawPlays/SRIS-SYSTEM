<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('user')
            ->where('user_id', Auth::id())
            ->byPriority()
            ->paginate(10);

        return view('teacher.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('teacher.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|integer|in:1,2,3',
            'is_active' => 'boolean',
            'publish_at' => 'nullable|date',
            'expire_at' => 'nullable|date|after_or_equal:publish_at',
            'audience_grade_level' => 'nullable|string|max:50',
            'audience_strand' => 'nullable|string|max:50',
            'audience_role' => 'nullable|in:student,teacher,all',
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'priority' => $request->priority,
            'is_active' => $request->has('is_active'),
            'publish_at' => $request->publish_at,
            'expire_at' => $request->expire_at,
            'audience_grade_level' => $request->audience_grade_level,
            'audience_strand' => $request->audience_strand,
            'audience_role' => $request->audience_role,
        ]);

        if ($announcement->is_active) {
            \App\Services\NotificationService::notifyAllStudents($announcement->title, $announcement->content);
        }

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement created successfully!');
    }

    public function edit(Announcement $announcement)
    {
        // Ensure teacher can only edit their own announcements
        if ($announcement->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('teacher.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        // Ensure teacher can only update their own announcements
        if ($announcement->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|integer|in:1,2,3',
            'is_active' => 'boolean',
            'publish_at' => 'nullable|date',
            'expire_at' => 'nullable|date|after_or_equal:publish_at',
            'audience_grade_level' => 'nullable|string|max:50',
            'audience_strand' => 'nullable|string|max:50',
            'audience_role' => 'nullable|in:student,teacher,all',
        ]);

        $wasInactive = !$announcement->is_active;
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'priority' => $request->priority,
            'is_active' => $request->has('is_active'),
            'publish_at' => $request->publish_at,
            'expire_at' => $request->expire_at,
            'audience_grade_level' => $request->audience_grade_level,
            'audience_strand' => $request->audience_strand,
            'audience_role' => $request->audience_role,
        ]);

        if ($wasInactive && $announcement->is_active) {
            \App\Services\NotificationService::notifyAllStudents($announcement->title, $announcement->content);
        }

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        // Ensure teacher can only delete their own announcements
        if ($announcement->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $announcement->delete();

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }
}
