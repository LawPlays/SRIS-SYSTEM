<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\User;
use App\Mail\RegistrationApproved;
use App\Mail\StudentEnrollmentRejected;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EnrollmentController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $enrollments = Enrollment::with('user')->paginate(10);
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function approve(Enrollment $enrollment)
    {
        $user = $enrollment->user;

        $capacity = \App\Models\StrandCapacity::where('school_year', $enrollment->school_year)
            ->where('grade_level', $enrollment->grade_level)
            ->where('strand', $enrollment->strand)
            ->first();

        $approvedCount = Enrollment::where('school_year', $enrollment->school_year)
            ->where('grade_level', $enrollment->grade_level)
            ->where('strand', $enrollment->strand)
            ->where('status', 'approved')
            ->count();

        if ($capacity && $approvedCount >= $capacity->capacity) {
            $enrollment->update([
                'status' => 'waitlisted',
                'waitlisted_at' => now(),
                'reviewed_by' => Auth::id(),
            ]);

            $user->status = 'pending';
            $user->save();

            $this->notificationService->createForUser(
                $user->id,
                'Enrollment Waitlisted',
                'Capacity reached for your strand/grade. You are waitlisted. We will notify you if a slot opens.',
                'warning'
            );

            return redirect()->route('admin.enrollments.index')
                ->with('success', 'Enrollment marked as waitlisted due to capacity limits.');
        }

        $enrollment->update([
            'status' => 'approved',
            'approved_at' => now(),
            'reviewed_by' => Auth::id(),
            'rejection_reason' => null,
            'rejected_at' => null
        ]);

        $user->status = 'approved';
        $user->email_verified_at = $user->email_verified_at ?: now();
        $user->save();

        $approver = Auth::user();
        Mail::to($user->email)->send(new RegistrationApproved($user, $approver));

        $this->notificationService->createForUser(
            $user->id,
            'Enrollment Approved',
            'Your enrollment has been approved! Welcome to our school.',
            'success'
        );

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment approved successfully and notifications sent.');
    }

    public function reject(Enrollment $enrollment, Request $request)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $enrollment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);
        
        // Also update the user status
        $user = $enrollment->user;
        $user->status = 'rejected';
        $user->save();
        
        // Send rejection email
        Mail::to($user->email)->send(new StudentEnrollmentRejected($user, $enrollment));
        
        // Create notification for the student
        $this->notificationService->createForUser(
            $user->id,
            'Enrollment Rejected',
            'Your enrollment has been rejected. Reason: ' . $request->rejection_reason,
            'error'
        );
        
        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment rejected successfully and notifications sent.');
    }
}
