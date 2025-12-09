<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $unreadCount = Auth::user()->unreadNotifications()->count();

        return view('student.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function unreadCount()
    {
        $count = Auth::user()->unreadNotifications()->count();
        return response()->json(['count' => $count]);
    }
}