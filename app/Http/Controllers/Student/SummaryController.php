<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;

class SummaryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $enrollment = Enrollment::where('user_id', $user->id)->first();
        
        return view('student.summary.index', compact('user', 'enrollment'));
    }
}
