<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')
            ->with(['enrollment', 'documents']);

        // Apply search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('grade_level')) {
            $query->whereHas('enrollment', function($q) use ($request) {
                $q->where('grade_level', $request->grade_level);
            });
        }

        if ($request->filled('strand')) {
            $query->whereHas('enrollment', function($q) use ($request) {
                $q->where('strand', $request->strand);
            });
        }

        // Optional status filter: pending, approved, rejected
        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        } else {
            // Default: show only approved students
            $query->where('status', 'approved');
        }

        $students = $query->orderBy('name')->paginate(20);

        // Get available grade levels and strands for filters
        $gradeLevels = Enrollment::distinct()->pluck('grade_level')->filter()->sort();
        $strands = Enrollment::distinct()->pluck('strand')->filter()->sort();

        return view('teacher.students.index', compact('students', 'gradeLevels', 'strands'));
    }

    public function show($id)
    {
        $student = User::where('role', 'student')
            ->with(['enrollment', 'documents'])
            ->findOrFail($id);

        // Check if teacher has permission to view this student
        // (In a real system, you might implement class-based restrictions)
        
        return view('teacher.students.show', compact('student'));
    }

    public function academicRecord($id)
    {
        $student = User::where('role', 'student')
            ->with(['enrollment'])
            ->findOrFail($id);

        // In a real system, you would have grades/academic records
        // For now, we'll show enrollment and basic academic information
        
        $academicInfo = [
            'student_id' => $student->student_id,
            'grade_level' => $student->enrollment->grade_level ?? 'N/A',
            'strand' => $student->enrollment->strand ?? 'N/A',
            'enrollment_date' => $student->enrollment->created_at ?? 'N/A',
            'status' => $student->status,
        ];

        return view('teacher.students.academic-record', compact('student', 'academicInfo'));
    }

    public function documents($id)
    {
        $student = User::where('role', 'student')
            ->with(['documents'])
            ->findOrFail($id);

        $requiredDocuments = config('registration.required_documents');

        $submittedDocuments = $student->documents->pluck('file_name')->toArray();
        $missingDocuments = array_diff($requiredDocuments, $submittedDocuments);

        return view('teacher.students.documents', compact('student', 'requiredDocuments', 'submittedDocuments', 'missingDocuments'));
    }

    public function verifyAcademicStanding(Request $request, $id)
    {
        $request->validate([
            'verification_status' => 'required|in:verified,needs_review,incomplete',
            'notes' => 'nullable|string|max:1000',
        ]);

        $student = User::where('role', 'student')->findOrFail($id);

        // Update student's academic standing verification
        // In a real system, you might have a separate academic_verifications table
        $student->update([
            'academic_verification_status' => $request->verification_status,
            'academic_verification_notes' => $request->notes,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Academic standing verification updated successfully.');
    }

    public function exportStudentList(Request $request)
    {
        $query = User::where('role', 'student')
            ->with(['enrollment'])
            ->where('status', 'approved');

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('grade_level')) {
            $query->whereHas('enrollment', function($q) use ($request) {
                $q->where('grade_level', $request->grade_level);
            });
        }

        if ($request->filled('strand')) {
            $query->whereHas('enrollment', function($q) use ($request) {
                $q->where('strand', $request->strand);
            });
        }

        $students = $query->orderBy('name')->get();

        // Generate CSV
        $filename = 'student_list_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($students) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Student ID',
                'Name',
                'Email',
                'Grade Level',
                'Strand',
                'Status',
                'Enrollment Date'
            ]);

            // CSV data
            foreach ($students as $student) {
                fputcsv($file, [
                    $student->student_id,
                    $student->name,
                    $student->email,
                    $student->enrollment->grade_level ?? 'N/A',
                    $student->enrollment->strand ?? 'N/A',
                    $student->status,
                    $student->enrollment->created_at ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
