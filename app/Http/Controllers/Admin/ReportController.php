<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enrollment;

class ReportController extends Controller
{
    public function dashboard()
    {
        // Count only users who have submitted enrollment forms
        $totalStudents = User::where('role', 'student')
            ->whereHas('enrollment')
            ->count();
        
        $pending = User::where('role', 'student')
            ->where('status', 'pending')
            ->whereHas('enrollment')
            ->count();
            
        $approved = User::where('role', 'student')
            ->where('status', 'approved')
            ->whereHas('enrollment')
            ->count();
            
        $totalEnrollments = Enrollment::count();

        return view('admin.reports.dashboard', compact(
            'totalStudents','pending','approved','totalEnrollments'
        ));
    }
}
