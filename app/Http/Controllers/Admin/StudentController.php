<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Document;
use App\Mail\RegistrationApproved;
use App\Mail\StudentEnrollmentRejected;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Get filter (status), default: all
        $filter = $request->get('status', 'all');

        // Base query: all students with enrollment records
        $query = User::with('enrollment')
            ->where('role', 'student')
            ->whereHas('enrollment');

        // Apply status filter if not "all"
        if (in_array($filter, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $filter);
        }

        // Fetch students list
        $students = $query->latest()->get();

        // Counts for dashboard/statistics (only users with enrollment records)
        $total = User::where('role', 'student')->whereHas('enrollment')->count();
        $pending = User::where('role', 'student')->where('status', 'pending')->whereHas('enrollment')->count();
        $approved = User::where('role', 'student')->where('status', 'approved')->whereHas('enrollment')->count();
        $rejected = User::where('role', 'student')->where('status', 'rejected')->whereHas('enrollment')->count();

        return view('admin.students.index', compact('students', 'total', 'pending', 'approved', 'rejected', 'filter'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'status' => 'required|string',
        ]);

        $student = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'status' => $validated['status'],
            'role' => 'student',
            'is_enrolled' => 1,
            'password' => bcrypt('password123'),
        ]);

        Enrollment::create([
            'user_id' => $student->id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'lrn' => $request->lrn,
            'sex' => $request->sex,
            'birthdate' => $request->birthdate,
            'place_of_birth' => $request->place_of_birth,
            'grade_level' => $request->grade_level,
            'strand' => $request->strand,
            'ip_community' => $request->ip_community,
            'is_indigenous' => $request->is_indigenous ?? 0,
            'indigenous_specify' => $request->indigenous_specify,
            'is_4ps' => $request->is_4ps ?? 0,
            'is_pwd' => $request->is_pwd ?? 0,
            'disability' => $request->disability,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'guardian_name' => $request->guardian_name,
        ]);

        return redirect()->route('admin.students.index')->with('alert', [
            'type' => 'success',
            'title' => 'Created!',
            'message' => 'Student created successfully with enrollment data!',
        ]);
    }

    public function edit(User $student)
    {
        $student->load('enrollment');
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'status' => 'required|string',
        ]);

        $student->update($validated);

        $student->enrollment()->updateOrCreate(
            ['user_id' => $student->id],
            [
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'lrn' => $request->lrn,
                'sex' => $request->sex,
                'birthdate' => $request->birthdate,
                'place_of_birth' => $request->place_of_birth,
                'grade_level' => $request->grade_level,
                'strand' => $request->strand,
                'ip_community' => $request->ip_community,
                'is_indigenous' => $request->is_indigenous ?? 0,
                'indigenous_specify' => $request->indigenous_specify,
                'is_4ps' => $request->is_4ps ?? 0,
                'is_pwd' => $request->is_pwd ?? 0,
                'disability' => $request->disability,
                'current_address' => $request->current_address,
                'permanent_address' => $request->permanent_address,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'guardian_name' => $request->guardian_name,
            ]
        );

        return redirect()->route('admin.students.index')->with('alert', [
            'type' => 'info',
            'title' => 'Updated!',
            'message' => 'Student and enrollment updated successfully!',
        ]);
    }

    public function approve($id)
    {
        $student = User::findOrFail($id);
        $previousStatus = $student->status;
        $student->status = 'approved';
        $student->email_verified_at = now(); // Set email as verified when approved
        $student->save();

        // Ensure enrollment record reflects approved status
        $enrollment = $student->enrollment;
        if ($enrollment) {
            $enrollment->status = 'approved';
            $enrollment->rejection_reason = null;
            $enrollment->rejected_at = null;
            $enrollment->save();
        }

        // Send approval email notification
        $approver = Auth::user();
        Mail::to($student->email)->send(new RegistrationApproved($student, $approver));

        // Send in-app notification
        NotificationService::notifyEnrollmentStatusChange($student, $previousStatus, 'approved');

        return redirect()->route('admin.students.index', ['status' => 'pending'])->with('alert', [
            'type' => 'success',
            'title' => 'Approved!',
            'message' => 'Student approved successfully and notifications sent!',
        ]);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $student = User::findOrFail($id);
        $previousStatus = $student->status;
        $student->status = 'rejected';
        $student->save();

        // Update enrollment record with rejection reason and timestamp
        $enrollment = $student->enrollment;
        if ($enrollment) {
            $enrollment->status = 'rejected';
            $enrollment->rejection_reason = $request->rejection_reason;
            $enrollment->rejected_at = now();
            $enrollment->save();
        }

        // Send rejection email
        if ($enrollment) {
            Mail::to($student->email)->send(new StudentEnrollmentRejected($student, $enrollment));
        }

        // Send in-app notification with rejection reason
        NotificationService::createForUser(
            $student,
            '❌ Enrollment Rejected',
            'Your enrollment has been rejected. Reason: ' . $request->rejection_reason,
            'error',
            ['enrollment_status' => 'rejected', 'rejection_reason' => $request->rejection_reason]
        );

        return redirect()->route('admin.students.index', ['status' => 'pending'])->with('alert', [
            'type' => 'error',
            'title' => 'Rejected!',
            'message' => 'Student rejected successfully with reason and notification sent!',
        ]);
    }

    public function dashboard()
    {
        return view('student.dashboard');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('student.profile', compact('user'));
    }

    public function summary()
    {
        $user = Auth::user();
        $enrollment = Enrollment::where('user_id', $user->id)->first();
        return view('student.summary', compact('user', 'enrollment'));
    }

    public function show($id)
    {
        $student = User::with('enrollment')->findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    public function documents($id)
    {
        $student = User::where('role', 'student')
            ->with(['documents'])
            ->findOrFail($id);

        $requiredDocuments = config('registration.required_documents');

        $submittedDocuments = $student->documents->pluck('file_name')->toArray();
        $missingDocuments = array_diff($requiredDocuments, $submittedDocuments);

        return view('admin.students.documents', compact('student', 'requiredDocuments', 'submittedDocuments', 'missingDocuments'));
    }
}
