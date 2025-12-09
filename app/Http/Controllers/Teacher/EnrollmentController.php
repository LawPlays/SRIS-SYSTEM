<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Mail\RegistrationApproved;
use App\Mail\StudentEnrollmentApproved;
use App\Mail\StudentEnrollmentRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with('user')->paginate(10);
        return view('teacher.enrollments.index', compact('enrollments'));
    }

    public function approve(Enrollment $enrollment)
    {
        // Teachers can only approve when the student's current status is pending
        if (($enrollment->user->status ?? 'pending') !== 'pending') {
            return redirect()->route('teacher.enrollments.index')
                ->with('error', 'Only pending enrollments can be approved by teachers.');
        }

        $capacity = \App\Models\StrandCapacity::where('school_year', $enrollment->school_year)
            ->where('grade_level', $enrollment->grade_level)
            ->where('strand', $enrollment->strand)
            ->first();

        $approvedCount = Enrollment::where('school_year', $enrollment->school_year)
            ->where('grade_level', $enrollment->grade_level)
            ->where('strand', $enrollment->strand)
            ->where('status', 'approved')
            ->count();

        $user = $enrollment->user;

        if ($capacity && $approvedCount >= $capacity->capacity) {
            $enrollment->update([
                'status' => 'waitlisted',
                'waitlisted_at' => now(),
                'reviewed_by' => Auth::id(),
            ]);

            $user->status = 'pending';
            $user->save();

            return redirect()->route('teacher.enrollments.index')
                ->with('success', 'Marked as waitlisted due to capacity limits.');
        }

        $enrollment->update([
            'status' => 'approved',
            'approved_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        $user->status = 'approved';
        $user->email_verified_at = $user->email_verified_at ?: now();
        $user->save();

        $approver = Auth::user();
        Mail::to($user->email)->send(new RegistrationApproved($user, $approver));

        return redirect()->route('teacher.enrollments.index')
            ->with('success', 'Registration approved successfully and email notification sent.');
    }

    public function reject(Enrollment $enrollment, Request $request)
    {
        // Teachers can only reject when student's status is pending and not approved already
        if ($enrollment->status === 'approved' || ($enrollment->user->status ?? 'pending') !== 'pending') {
            return redirect()->route('teacher.enrollments.index')
                ->with('error', 'You cannot reject an already approved enrollment.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $enrollment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        $user = $enrollment->user;
        $user->status = 'rejected';
        $user->save();

        Mail::to($user->email)->send(new StudentEnrollmentRejected($user, $enrollment));

        return redirect()->route('teacher.enrollments.index')
            ->with('success', 'Registration rejected successfully with reason and email notification sent.');
    }
}
