<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EnhancedReportController extends Controller
{
    public function dashboard()
    {
        // Real-time enrollment statistics
        $totalStudents = User::where('role', 'student')->whereHas('enrollment')->count();
        $pendingEnrollments = User::where('role', 'student')->where('status', 'pending')->whereHas('enrollment')->count();
        $approvedEnrollments = User::where('role', 'student')->where('status', 'approved')->whereHas('enrollment')->count();
        $rejectedEnrollments = User::where('role', 'student')->where('status', 'rejected')->whereHas('enrollment')->count();

        // Monthly enrollment trends
        $monthlyEnrollments = Enrollment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

        // Grade level distribution
        $gradeLevelStats = Enrollment::select('grade_level', DB::raw('COUNT(*) as count'))
            ->groupBy('grade_level')
            ->get();

        // Strand distribution (for SHS)
        $strandStats = Enrollment::select('strand', DB::raw('COUNT(*) as count'))
            ->whereNotNull('strand')
            ->groupBy('strand')
            ->get();

        // Document submission rates
        $documentStats = [
            'total_students' => $totalStudents,
            'with_psa' => Enrollment::whereNotNull('psa_birth_certificate')->count(),
            'document_completion_rate' => $totalStudents > 0 ? 
                round((Enrollment::whereNotNull('psa_birth_certificate')->count() / $totalStudents) * 100, 2) : 0
        ];

        // Recent activity (last 7 days)
        $recentEnrollments = Enrollment::with('user')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.enhanced-dashboard', compact(
            'totalStudents',
            'pendingEnrollments', 
            'approvedEnrollments',
            'rejectedEnrollments',
            'monthlyEnrollments',
            'gradeLevelStats',
            'strandStats',
            'documentStats',
            'recentEnrollments'
        ));
    }

    public function enrollmentReport(Request $request)
    {
        $query = Enrollment::with('user');

        // Apply filters
        if ($request->filled('status')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->grade_level);
        }

        if ($request->filled('strand')) {
            $query->where('strand', $request->strand);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(20);

        // Summary statistics for filtered results
        $summary = [
            'total' => $query->count(),
            'approved' => $query->clone()->whereHas('user', function($q) {
                $q->where('status', 'approved');
            })->count(),
            'pending' => $query->clone()->whereHas('user', function($q) {
                $q->where('status', 'pending');
            })->count(),
            'rejected' => $query->clone()->whereHas('user', function($q) {
                $q->where('status', 'rejected');
            })->count(),
        ];

        return view('admin.reports.enrollment-report', compact('enrollments', 'summary'));
    }

    public function systemMonitoring()
    {
        // System performance metrics
        $metrics = [
            'total_users' => User::count(),
            'active_students' => User::where('role', 'student')->where('status', 'approved')->count(),
            'total_teachers' => User::where('role', 'teacher')->count(),
            'total_documents' => Document::count(),
            'storage_usage' => $this->getStorageUsage(),
            'recent_logins' => $this->getRecentLoginActivity(),
        ];

        // Database health check
        $dbHealth = $this->checkDatabaseHealth();

        // System alerts
        $alerts = $this->getSystemAlerts();

        return view('admin.reports.system-monitoring', compact('metrics', 'dbHealth', 'alerts'));
    }

    private function getStorageUsage()
    {
        // Calculate storage usage for uploaded files
        $totalSize = 0;
        $documents = Document::all();
        
        foreach ($documents as $document) {
            $filePath = storage_path('app/public/' . $document->file_path);
            if (file_exists($filePath)) {
                $totalSize += filesize($filePath);
            }
        }

        return [
            'total_bytes' => $totalSize,
            'total_mb' => round($totalSize / 1024 / 1024, 2),
            'document_count' => $documents->count(),
        ];
    }

    private function getRecentLoginActivity()
    {
        // This would require implementing login tracking
        // For now, return recent user activity based on updated_at
        return User::where('updated_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get(['id', 'name', 'email', 'role', 'updated_at']);
    }

    private function checkDatabaseHealth()
    {
        try {
            $userCount = User::count();
            $enrollmentCount = Enrollment::count();
            $documentCount = Document::count();

            return [
                'status' => 'healthy',
                'tables' => [
                    'users' => $userCount,
                    'enrollments' => $enrollmentCount,
                    'documents' => $documentCount,
                ],
                'last_checked' => now(),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'last_checked' => now(),
            ];
        }
    }

    private function getSystemAlerts()
    {
        $alerts = [];

        // Check for pending enrollments that need attention
        $oldPendingCount = User::where('role', 'student')
            ->where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subDays(7))
            ->count();

        if ($oldPendingCount > 0) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'Old Pending Enrollments',
                'message' => "{$oldPendingCount} enrollment(s) have been pending for more than 7 days.",
                'action_url' => route('admin.students.index', ['status' => 'pending']),
            ];
        }

        // Check for low document submission rates
        $totalStudents = User::where('role', 'student')->count();
        $studentsWithDocs = Document::distinct('user_id')->count();
        $docSubmissionRate = $totalStudents > 0 ? ($studentsWithDocs / $totalStudents) * 100 : 0;

        if ($docSubmissionRate < 50) {
            $alerts[] = [
                'type' => 'info',
                'title' => 'Low Document Submission Rate',
                'message' => "Only {$docSubmissionRate}% of students have submitted documents.",
                'action_url' => route('admin.reports.enrollment-report'),
            ];
        }

        return $alerts;
    }
}