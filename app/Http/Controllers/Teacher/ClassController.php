<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of classes (grade level + strand) with status distribution.
     */
    public function index(Request $request)
    {
        // Fetch enrollments with related user and documents for status calculations
        $enrollments = Enrollment::with(['user.documents'])
            ->whereHas('user', function ($q) {
                $q->where('role', 'student');
            })
            ->get();

        $groups = [];

        // Define complete set of grade levels and strands to ensure all are shown
        $jhsStrands = ['Regular', 'SPA', 'STE'];
        $shsStrands = ['STEM', 'ABM', 'HUMSS', 'GAS', 'TVL-ICT', 'TVL-HE', 'TVL-IA', 'ARTS', 'SPORTS'];
        $gradeStrandsMap = [
            'Grade 7' => $jhsStrands,
            'Grade 8' => $jhsStrands,
            'Grade 9' => $jhsStrands,
            'Grade 10' => $jhsStrands,
            'Grade 11' => $shsStrands,
            'Grade 12' => $shsStrands,
        ];

        foreach ($enrollments as $enrollment) {
            $gradeLevel = $enrollment->grade_level ?? 'Unknown';
            $strand = $enrollment->strand ?? 'Unknown';
            $key = $gradeLevel.'|'.$strand;

            if (!isset($groups[$key])) {
                $groups[$key] = [
                    'grade_level' => $gradeLevel,
                    'strand' => $strand,
                    'total' => 0,
                    'pending' => 0,
                    'complete' => 0,
                    'incomplete' => 0,
                ];
            }

            $user = $enrollment->user;
            $groups[$key]['total']++;

            // Determine document completeness for this user
            $docNames = $user->documents ? $user->documents->pluck('file_name')->map(function ($n) {
                return strtolower(trim($n));
            })->toArray() : [];

            // Align with actual naming seen in views (PSA Birth Certificate, Form 137 (Report Card))
            $requiredDocs = [
                'psa birth certificate',
                'form 137 (report card)',
            ];

            $hasRequired = function (array $haystack, array $needles) {
                foreach ($needles as $needle) {
                    $found = false;
                    foreach ($haystack as $item) {
                        if (str_contains($item, $needle)) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        return false;
                    }
                }
                return true;
            };

            $docsComplete = $hasRequired($docNames, $requiredDocs);

            // Map to one of: pending, complete, incomplete (exclusive buckets)
            if ($user->status === 'approved') {
                if ($docsComplete) {
                    $groups[$key]['complete']++;
                } else {
                    $groups[$key]['incomplete']++;
                }
            } elseif ($user->status === 'pending') {
                $groups[$key]['pending']++;
            } else {
                // Other statuses (e.g., rejected) are not part of the requested buckets
            }
        }

        // Ensure all grade/strand combinations exist with zero counts
        foreach ($gradeStrandsMap as $grade => $strands) {
            foreach ($strands as $strand) {
                $key = $grade.'|'.$strand;
                if (!isset($groups[$key])) {
                    $groups[$key] = [
                        'grade_level' => $grade,
                        'strand' => $strand,
                        'total' => 0,
                        'pending' => 0,
                        'complete' => 0,
                        'incomplete' => 0,
                    ];
                }
            }
        }

        // Students who have not started enrollment (pre-registered)
        $preregisteredTotal = User::where('role', 'student')
            ->where('is_enrolled', false)
            ->count();

        // Build grouped structure by grade for the view
        $classGroupsByGrade = [];
        foreach ($gradeStrandsMap as $grade => $strands) {
            $classGroupsByGrade[$grade] = [];
            foreach ($strands as $strand) {
                $key = $grade.'|'.$strand;
                $classGroupsByGrade[$grade][] = $groups[$key];
            }
        }

        // Flat list for summary counters
        $classGroupsFlat = array_values($groups);

        return view('teacher.classes.index', [
            'classGroupsByGrade' => $classGroupsByGrade,
            'classGroupsFlat' => $classGroupsFlat,
            'preregisteredTotal' => $preregisteredTotal,
        ]);
    }
}