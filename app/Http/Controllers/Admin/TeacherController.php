<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
            'status' => 'approved',
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher account created successfully!');
    }

    public function show(User $teacher)
    {
        if ($teacher->role !== 'teacher') {
            abort(404);
        }

        $announcementCount = 0; // Temporarily set to 0 since announcements relationship is not available
        
        return view('admin.teachers.show', compact('teacher', 'announcementCount'));
    }

    public function edit(User $teacher)
    {
        if ($teacher->role !== 'teacher') {
            abort(404);
        }

        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, User $teacher)
    {
        if ($teacher->role !== 'teacher') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $teacher->id],
            'status' => ['required', 'in:approved,suspended'],
        ]);

        $teacher->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            
            $teacher->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher account updated successfully!');
    }

    public function destroy(User $teacher)
    {
        if ($teacher->role !== 'teacher') {
            abort(404);
        }

        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher account deleted successfully!');
    }
}