@extends('layouts.teacher')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-gray-900 relative overflow-hidden p-8">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.1),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(147,51,234,0.08),transparent_40%)]"></div>
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10 mix-blend-overlay"></div>

    <div class="relative z-10 flex items-center justify-between mb-8">
        <h2 class="text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Academic Record</h2>
        <a href="{{ route('teacher.students.index') }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white">Back to list</a>
    </div>

    <div class="relative z-10 bg-blue-900/40 border border-blue-800/50 rounded-2xl p-6 backdrop-blur-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-blue-100">
            <div>
                <span class="text-blue-300">Student:</span>
                <div>{{ $student->name }}</div>
            </div>
            <div>
                <span class="text-blue-300">Student ID:</span>
                <div>{{ $academicInfo['student_id'] ?? '—' }}</div>
            </div>
            <div>
                <span class="text-blue-300">Grade Level:</span>
                <div>{{ $academicInfo['grade_level'] ?? '—' }}</div>
            </div>
            <div>
                <span class="text-blue-300">Strand:</span>
                <div>{{ $academicInfo['strand'] ?? '—' }}</div>
            </div>
            <div>
                <span class="text-blue-300">Enrollment Date:</span>
                <div>{{ is_string($academicInfo['enrollment_date']) ? $academicInfo['enrollment_date'] : optional($academicInfo['enrollment_date'])->format('F d, Y') }}</div>
            </div>
            <div>
                <span class="text-blue-300">Status:</span>
                <div>{{ $academicInfo['status'] ?? '—' }}</div>
            </div>
        </div>
        <div class="mt-6 text-blue-200 text-sm">Note: Academic grades and subjects can be integrated here when available.</div>
    </div>
</div>
@endsection