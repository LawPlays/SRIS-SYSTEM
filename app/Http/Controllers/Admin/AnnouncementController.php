<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('user')
            ->byPriority()
            ->paginate(10);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
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
            'is_active' => $request->has('is_active')
        ]);

        // Send notifications to all students if announcement is active
        if ($announcement->is_active) {
            NotificationService::notifyAllStudents($announcement->title, $announcement->content);
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully and notifications sent!');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|integer|in:1,2,3',
            'is_active' => 'boolean'
        ]);

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

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }

    public function toggle(Announcement $announcement)
    {
        $wasInactive = !$announcement->is_active;
        $announcement->update(['is_active' => !$announcement->is_active]);

        // Send notifications if announcement was just activated
        if ($wasInactive && $announcement->is_active) {
            NotificationService::notifyAllStudents($announcement->title, $announcement->content);
        }

        $status = $announcement->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "Announcement {$status} successfully!");
    }
}
