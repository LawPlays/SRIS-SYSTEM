<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

class EnrollmentController extends Controller
{
    public function create()
    {
        $userId = Auth::id();
        $hasActive = Enrollment::where('user_id', $userId)
            ->whereIn('status', ['pending','approved','waitlisted'])
            ->exists();
        if ($hasActive) {
            return redirect()->route('student.documents.index')
                ->with('error', 'You already submitted an enrollment. You can resubmit only if the previous was rejected.');
        }
        return view('student.enrollment.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'school_year'        => 'required|string|max:255',
            'strand'             => 'required|string|max:255',
            'grade_level'        => 'required|string|max:255',
            'last_name'          => 'required|string|max:255',
            'first_name'         => 'required|string|max:255',
            'middle_name'        => 'nullable|string|max:255',
            'lrn'                => 'required|string|max:255',
            'birthdate'          => 'required|date',
            'place_of_birth'     => 'required|string|max:255',
            'sex'                => 'required|string|max:50',
            'age'                => 'required|integer|min:1|max:100',
            'current_address'    => 'required|string|max:500',
            'permanent_address'  => 'required|string|max:500',
            'father_name'        => 'required|string|max:255',
            'mother_name'        => 'required|string|max:255',
            'guardian_name'      => 'nullable|string|max:255',
            'contact_number'     => 'required|string|max:15',
            'form_137'           => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'psa_birth_certificate' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Handle file uploads
        $form137Path = null;
        $psaPath = null;

        if ($request->hasFile('form_137')) {
            $file = $request->file('form_137');
            $filename = time() . '_form137_' . $file->getClientOriginalName();
            $form137Path = $file->storeAs('uploads/form137', $filename, 'public');
        }

        if ($request->hasFile('psa_birth_certificate')) {
            $file = $request->file('psa_birth_certificate');
            $filename = time() . '_psa_' . $file->getClientOriginalName();
            $psaPath = $file->storeAs('uploads/psa', $filename, 'public');
        }

        $userId = Auth::id();
        $hasActive = Enrollment::where('user_id', $userId)
            ->whereIn('status', ['pending','approved','waitlisted'])
            ->exists();
        if ($hasActive) {
            return redirect()->route('student.documents.index')
                ->with('error', 'You already have an active enrollment. Resubmission is allowed only after rejection.');
        }

        $rejected = Enrollment::where('user_id', $userId)
            ->where('status', 'rejected')
            ->latest()
            ->first();

        if ($rejected) {
            $rejected->update([
                'school_year'           => $validatedData['school_year'],
                'strand'                => $validatedData['strand'],
                'grade_level'           => $validatedData['grade_level'],
                'last_name'             => $validatedData['last_name'],
                'first_name'            => $validatedData['first_name'],
                'middle_name'           => $validatedData['middle_name'] ?? null,
                'lrn'                   => $validatedData['lrn'],
                'birthdate'             => $validatedData['birthdate'],
                'place_of_birth'        => $validatedData['place_of_birth'],
                'sex'                   => $validatedData['sex'],
                'age'                   => $validatedData['age'],
                'current_address'       => $validatedData['current_address'],
                'permanent_address'     => $validatedData['permanent_address'],
                'father_name'           => $validatedData['father_name'],
                'mother_name'           => $validatedData['mother_name'],
                'guardian_name'         => $validatedData['guardian_name'] ?? null,
                'contact_number'        => $validatedData['contact_number'],
                'form137'               => $form137Path,
                'psa_birth_certificate' => $psaPath,
                'status'                => 'pending',
                'rejection_reason'      => null,
                'rejected_at'           => null,
            ]);
        } else {
            Enrollment::create([
                'user_id'               => $userId,
                'school_year'           => $validatedData['school_year'],
                'strand'                => $validatedData['strand'],
                'grade_level'           => $validatedData['grade_level'],
                'last_name'             => $validatedData['last_name'],
                'first_name'            => $validatedData['first_name'],
                'middle_name'           => $validatedData['middle_name'] ?? null,
                'lrn'                   => $validatedData['lrn'],
                'birthdate'             => $validatedData['birthdate'],
                'place_of_birth'        => $validatedData['place_of_birth'],
                'sex'                   => $validatedData['sex'],
                'age'                   => $validatedData['age'],
                'current_address'       => $validatedData['current_address'],
                'permanent_address'     => $validatedData['permanent_address'],
                'father_name'           => $validatedData['father_name'],
                'mother_name'           => $validatedData['mother_name'],
                'guardian_name'         => $validatedData['guardian_name'] ?? null,
                'contact_number'        => $validatedData['contact_number'],
                'form137'               => $form137Path,
                'psa_birth_certificate' => $psaPath,
                'status'                => 'pending',
            ]);
        }

        // Create document records for uploaded files
        $userId = Auth::id();
        
        if ($form137Path) {
            Document::create([
                'user_id' => $userId,
                'file_name' => 'Form 137 (Report Card)',
                'file_path' => $form137Path,
                'file_type' => pathinfo($form137Path, PATHINFO_EXTENSION),
            ]);
        }
        
        if ($psaPath) {
            Document::create([
                'user_id' => $userId,
                'file_name' => 'PSA Birth Certificate',
                'file_path' => $psaPath,
                'file_type' => pathinfo($psaPath, PATHINFO_EXTENSION),
            ]);
        }

        // Mark user as enrolled
        $user = Auth::user();
        $user->is_enrolled = true;
        $user->save();

        return redirect()
            ->route('student.dashboard')
            ->with('success', '🎉 Enrollment submitted successfully! Please wait for admin approval.');
    }

    public function createSHS()
    {
        $userId = Auth::id();
        $hasActive = Enrollment::where('user_id', $userId)
            ->whereIn('status', ['pending','approved','waitlisted'])
            ->exists();
        if ($hasActive) {
            return redirect()->route('student.documents.index')
                ->with('error', 'You already submitted an enrollment. You can resubmit only if the previous was rejected.');
        }
        return view('student.enrollment.shs-create');
    }

    public function storeSHS(Request $request)
    {
        $validatedData = $request->validate([
            'school_year'        => 'required|string|max:255',
            'strand'             => 'required|string|max:255',
            'grade_level'        => 'required|string|in:Grade 11,Grade 12',
            'last_name'          => 'required|string|max:255',
            'first_name'         => 'required|string|max:255',
            'middle_name'        => 'nullable|string|max:255',
            'lrn'                => 'required|string|max:255',
            'birthdate'          => 'required|date',
            'place_of_birth'     => 'required|string|max:255',
            'sex'                => 'required|string|max:50',
            'age'                => 'required|integer|min:1|max:100',
            'current_address'    => 'required|string|max:500',
            'permanent_address'  => 'required|string|max:500',
            'father_name'        => 'nullable|string|max:255',
            'mother_name'        => 'nullable|string|max:255',
            'guardian_name'      => 'nullable|string|max:255',
            'contact_number'     => 'required|string|max:15',
            'form_137'           => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'psa_birth_certificate' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Handle file uploads
        $form137Path = null;
        $psaPath = null;

        if ($request->hasFile('form_137')) {
            $file = $request->file('form_137');
            $filename = time() . '_shs_form137_' . $file->getClientOriginalName();
            $form137Path = $file->storeAs('uploads/form137', $filename, 'public');
        }

        if ($request->hasFile('psa_birth_certificate')) {
            $file = $request->file('psa_birth_certificate');
            $filename = time() . '_shs_psa_' . $file->getClientOriginalName();
            $psaPath = $file->storeAs('uploads/psa', $filename, 'public');
        }

        $userId = Auth::id();
        $hasActive = Enrollment::where('user_id', $userId)
            ->whereIn('status', ['pending','approved','waitlisted'])
            ->exists();
        if ($hasActive) {
            return redirect()->route('student.documents.index')
                ->with('error', 'You already have an active enrollment. Resubmission is allowed only after rejection.');
        }

        $rejected = Enrollment::where('user_id', $userId)
            ->where('status', 'rejected')
            ->latest()
            ->first();

        if ($rejected) {
            $rejected->update([
                'school_year'           => $validatedData['school_year'],
                'strand'                => $validatedData['strand'],
                'grade_level'           => $validatedData['grade_level'],
                'last_name'             => $validatedData['last_name'],
                'first_name'            => $validatedData['first_name'],
                'middle_name'           => $validatedData['middle_name'] ?? null,
                'lrn'                   => $validatedData['lrn'],
                'birthdate'             => $validatedData['birthdate'],
                'place_of_birth'        => $validatedData['place_of_birth'],
                'sex'                   => $validatedData['sex'],
                'age'                   => $validatedData['age'],
                'current_address'       => $validatedData['current_address'],
                'permanent_address'     => $validatedData['permanent_address'],
                'father_name'           => $validatedData['father_name'] ?? null,
                'mother_name'           => $validatedData['mother_name'] ?? null,
                'guardian_name'         => $validatedData['guardian_name'] ?? null,
                'contact_number'        => $validatedData['contact_number'],
                'form137'               => $form137Path,
                'psa_birth_certificate' => $psaPath,
                'status'                => 'pending',
                'rejection_reason'      => null,
                'rejected_at'           => null,
            ]);
        } else {
            Enrollment::create([
                'user_id'               => $userId,
                'school_year'           => $validatedData['school_year'],
                'strand'                => $validatedData['strand'],
                'grade_level'           => $validatedData['grade_level'],
                'last_name'             => $validatedData['last_name'],
                'first_name'            => $validatedData['first_name'],
                'middle_name'           => $validatedData['middle_name'] ?? null,
                'lrn'                   => $validatedData['lrn'],
                'birthdate'             => $validatedData['birthdate'],
                'place_of_birth'        => $validatedData['place_of_birth'],
                'sex'                   => $validatedData['sex'],
                'age'                   => $validatedData['age'],
                'current_address'       => $validatedData['current_address'],
                'permanent_address'     => $validatedData['permanent_address'],
                'father_name'           => $validatedData['father_name'] ?? null,
                'mother_name'           => $validatedData['mother_name'] ?? null,
                'guardian_name'         => $validatedData['guardian_name'] ?? null,
                'contact_number'        => $validatedData['contact_number'],
                'form137'               => $form137Path,
                'psa_birth_certificate' => $psaPath,
                'status'                => 'pending',
            ]);
        }

        // Create document records for uploaded files
        $userId = Auth::id();
        
        if ($form137Path) {
            Document::create([
                'user_id' => $userId,
                'file_name' => 'Form 137 (Report Card) - SHS',
                'file_path' => $form137Path,
                'file_type' => pathinfo($form137Path, PATHINFO_EXTENSION),
            ]);
        }
        
        if ($psaPath) {
            Document::create([
                'user_id' => $userId,
                'file_name' => 'PSA Birth Certificate - SHS',
                'file_path' => $psaPath,
                'file_type' => pathinfo($psaPath, PATHINFO_EXTENSION),
            ]);
        }

        // Mark user as enrolled
        $user = Auth::user();
        $user->is_enrolled = true;
        $user->save();

        return redirect()
            ->route('student.dashboard')
            ->with('success', '🎉 SHS Enrollment submitted successfully! Please wait for admin approval.');
    }

    public function createJHS()
    {
        $userId = Auth::id();
        $hasActive = Enrollment::where('user_id', $userId)
            ->whereIn('status', ['pending','approved','waitlisted'])
            ->exists();
        if ($hasActive) {
            return redirect()->route('student.documents.index')
                ->with('error', 'You already submitted an enrollment. You can resubmit only if the previous was rejected.');
        }
        return view('student.enrollment.jhs-create');
    }

    public function storeJHS(Request $request)
    {
        $validatedData = $request->validate([
            'school_year'        => 'required|string|max:255',
            'strand'             => 'required|string|max:255',
            'grade_level'        => 'required|string|in:Grade 7,Grade 8,Grade 9,Grade 10',
            'last_name'          => 'required|string|max:255',
            'first_name'         => 'required|string|max:255',
            'middle_name'        => 'nullable|string|max:255',
            'lrn'                => 'required|string|max:255',
            'birthdate'          => 'required|date',
            'place_of_birth'     => 'required|string|max:255',
            'sex'                => 'required|string|max:50',
            'age'                => 'required|integer|min:1|max:100',
            'current_address'    => 'required|string|max:500',
            'permanent_address'  => 'required|string|max:500',
            'father_name'        => 'nullable|string|max:255',
            'mother_name'        => 'nullable|string|max:255',
            'guardian_name'      => 'nullable|string|max:255',
            'contact_number'     => 'required|string|max:15',
            'spa_major'          => 'nullable|string|max:255',
            'form_137'           => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'psa_birth_certificate' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Handle file uploads
        $form137Path = null;
        $psaPath = null;

        if ($request->hasFile('form_137')) {
            $file = $request->file('form_137');
            $filename = time() . '_jhs_form137_' . $file->getClientOriginalName();
            $form137Path = $file->storeAs('uploads/form137', $filename, 'public');
        }

        if ($request->hasFile('psa_birth_certificate')) {
            $file = $request->file('psa_birth_certificate');
            $filename = time() . '_jhs_psa_' . $file->getClientOriginalName();
            $psaPath = $file->storeAs('uploads/psa', $filename, 'public');
        }

        $userId = Auth::id();
        $hasActive = Enrollment::where('user_id', $userId)
            ->whereIn('status', ['pending','approved','waitlisted'])
            ->exists();
        if ($hasActive) {
            return redirect()->route('student.documents.index')
                ->with('error', 'You already have an active enrollment. Resubmission is allowed only after rejection.');
        }

        $rejected = Enrollment::where('user_id', $userId)
            ->where('status', 'rejected')
            ->latest()
            ->first();

        if ($rejected) {
            $rejected->update([
                'school_year'           => $validatedData['school_year'],
                'strand'                => $validatedData['strand'],
                'grade_level'           => $validatedData['grade_level'],
                'last_name'             => $validatedData['last_name'],
                'first_name'            => $validatedData['first_name'],
                'middle_name'           => $validatedData['middle_name'] ?? null,
                'lrn'                   => $validatedData['lrn'],
                'birthdate'             => $validatedData['birthdate'],
                'place_of_birth'        => $validatedData['place_of_birth'],
                'sex'                   => $validatedData['sex'],
                'age'                   => $validatedData['age'],
                'current_address'       => $validatedData['current_address'],
                'permanent_address'     => $validatedData['permanent_address'],
                'father_name'           => $validatedData['father_name'] ?? null,
                'mother_name'           => $validatedData['mother_name'] ?? null,
                'guardian_name'         => $validatedData['guardian_name'] ?? null,
                'contact_number'        => $validatedData['contact_number'],
                'spa_major'             => $validatedData['spa_major'] ?? null,
                'form137'               => $form137Path,
                'psa_birth_certificate' => $psaPath,
                'status'                => 'pending',
                'rejection_reason'      => null,
                'rejected_at'           => null,
            ]);
        } else {
            Enrollment::create([
                'user_id'               => $userId,
                'school_year'           => $validatedData['school_year'],
                'strand'                => $validatedData['strand'],
                'grade_level'           => $validatedData['grade_level'],
                'last_name'             => $validatedData['last_name'],
                'first_name'            => $validatedData['first_name'],
                'middle_name'           => $validatedData['middle_name'] ?? null,
                'lrn'                   => $validatedData['lrn'],
                'birthdate'             => $validatedData['birthdate'],
                'place_of_birth'        => $validatedData['place_of_birth'],
                'sex'                   => $validatedData['sex'],
                'age'                   => $validatedData['age'],
                'current_address'       => $validatedData['current_address'],
                'permanent_address'     => $validatedData['permanent_address'],
                'father_name'           => $validatedData['father_name'] ?? null,
                'mother_name'           => $validatedData['mother_name'] ?? null,
                'guardian_name'         => $validatedData['guardian_name'] ?? null,
                'contact_number'        => $validatedData['contact_number'],
                'spa_major'             => $validatedData['spa_major'] ?? null,
                'form137'               => $form137Path,
                'psa_birth_certificate' => $psaPath,
                'status'                => 'pending',
            ]);
        }

        // Create document records for uploaded files
        $userId = Auth::id();
        
        if ($form137Path) {
            Document::create([
                'user_id' => $userId,
                'file_name' => 'Form 137 (Report Card) - JHS',
                'file_path' => $form137Path,
                'file_type' => pathinfo($form137Path, PATHINFO_EXTENSION),
            ]);
        }
        
        if ($psaPath) {
            Document::create([
                'user_id' => $userId,
                'file_name' => 'PSA Birth Certificate - JHS',
                'file_path' => $psaPath,
                'file_type' => pathinfo($psaPath, PATHINFO_EXTENSION),
            ]);
        }

        // Mark user as enrolled
        $user = Auth::user();
        $user->is_enrolled = true;
        $user->save();

        return redirect()
            ->route('student.dashboard')
            ->with('success', '🎉 JHS Enrollment submitted successfully! Please wait for admin approval.');
    }
}
