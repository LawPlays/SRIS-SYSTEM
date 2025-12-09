<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Count only users who have submitted enrollment forms
        $total = User::where('role', 'student')
            ->whereHas('enrollment')
            ->count();

        // Bilang ng mga approved, pending, rejected (only those with enrollment records)
        $approved = User::where('role', 'student')
            ->where('status', 'approved')
            ->whereHas('enrollment')
            ->count();
            
        $pending = User::where('role', 'student')
            ->where('status', 'pending')
            ->whereHas('enrollment')
            ->count();
            
        $rejected = User::where('role', 'student')
            ->where('status', 'rejected')
            ->whereHas('enrollment')
            ->count();

        return view('admin.dashboard', compact('total', 'approved', 'pending', 'rejected'));
    }
}
