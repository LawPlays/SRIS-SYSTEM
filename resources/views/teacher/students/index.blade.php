@extends('layouts.teacher')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-gray-900 relative overflow-hidden p-8">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.1),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(147,51,234,0.08),transparent_40%)]"></div>
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10 mix-blend-overlay"></div>

    <h2 class="relative z-10 text-3xl md:text-4xl font-extrabold mb-8 bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent tracking-wide">
        👩‍🎓 Students
    </h2>

    {{-- Simple Filter Chips --}}
    <div class="relative z-10 bg-blue-900/40 border border-blue-800/50 rounded-2xl p-6 mb-8 backdrop-blur-xl">
        <div class="flex items-center gap-4">
            @php $params = request()->only(['grade_level','strand']); $active = request('status'); @endphp
            <a href="{{ route('teacher.students.index', $params) }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white">View Students</a>
            <div class="flex items-center gap-2">
                <a href="{{ route('teacher.students.index', array_merge($params, ['status' => 'pending'])) }}"
                   class="px-3 py-1 rounded {{ $active === 'pending' ? 'bg-black text-white' : 'bg-blue-950/50 text-blue-200 hover:bg-blue-900/60' }}">
                    Pending
                </a>
                <a href="{{ route('teacher.students.index', array_merge($params, ['status' => 'approved'])) }}"
                   class="px-3 py-1 rounded {{ $active === 'approved' ? 'bg-green-600 text-white' : 'bg-blue-950/50 text-blue-200 hover:bg-blue-900/60' }}">
                    Approved
                </a>
            </div>
        </div>
    </div>

    {{-- Students Table --}}
    <div class="relative z-10 bg-blue-900/40 border border-blue-800/50 rounded-2xl overflow-hidden backdrop-blur-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-blue-950/40 text-blue-200">
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Grade Level</th>
                        <th class="px-4 py-3 text-left">Strand</th>
                        <th class="px-4 py-3 text-left">LRN</th>
                        <th class="px-4 py-3 text-left">Registration Status</th>
                        <th class="px-4 py-3 text-left">Documents</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-800/40">
                @forelse($students as $student)
                    @php
                        $enr = $student->enrollment;
                        $requiredDocs = ['PSA Birth Certificate', 'Form 137 (Report Card)', 'Form 137 (Report Card) - SHS'];
                        $submitted = $student->documents->pluck('file_name')->toArray();
                        $hasPSA = in_array('PSA Birth Certificate', $submitted) || in_array('PSA Birth Certificate - SHS', $submitted ?? []);
                        $hasForm = in_array('Form 137 (Report Card)', $submitted) || in_array('Form 137 (Report Card) - SHS', $submitted ?? []);
                        $docsComplete = $hasPSA && $hasForm;

                        $status = $student->status;
                        $statusLabel = $status === 'approved' ? 'Fully Enrolled' : ($status === 'pending' ? 'Pending Verification' : ($status === 'rejected' ? 'Rejected' : 'Unknown'));
                        $statusColor = $status === 'approved' ? 'bg-green-700/60 text-green-200' : ($status === 'pending' ? 'bg-yellow-700/60 text-yellow-200' : ($status === 'rejected' ? 'bg-red-700/60 text-red-200' : 'bg-gray-700/60 text-gray-200'));
                    @endphp
                    <tr class="hover:bg-blue-950/30">
                        <td class="px-4 py-3">{{ $student->name }}</td>
                        <td class="px-4 py-3">{{ $enr->grade_level ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $enr->strand ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $enr->lrn ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 rounded {{ $statusColor }}">{{ $statusLabel }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($docsComplete)
                                <span class="inline-block px-2 py-1 rounded bg-green-700/60 text-green-200">Complete</span>
                            @else
                                <span class="inline-block px-2 py-1 rounded bg-orange-700/60 text-orange-200">Incomplete</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('teacher.students.show', $student->id) }}" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-500 text-white">View</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-blue-200">No students found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-4 py-4">
            {{ $students->withQueryString()->links() }}
        </div>
    </div>
    
</div>
@endsection