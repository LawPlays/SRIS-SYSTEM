@extends('layouts.teacher')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-gray-900 relative overflow-hidden p-8">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.1),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(147,51,234,0.08),transparent_40%)]"></div>
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10 mix-blend-overlay"></div>

    <div class="relative z-10 flex items-center justify-between mb-8">
        <h2 class="text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Student Details</h2>
        <a href="{{ route('teacher.students.index') }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white">Back to list</a>
    </div>

    @php
        $enr = $student->enrollment;
        $submittedDocs = $student->documents->pluck('file_name')->toArray();
        $docCount = count($submittedDocs);
    @endphp

    <div class="relative z-10">
        <div class="bg-blue-900/40 border border-blue-800/50 rounded-2xl p-6 backdrop-blur-xl space-y-8">
            @php
                $status = $student->status;
                $statusLabel = $status === 'approved' ? 'Fully Enrolled' : ($status === 'pending' ? 'Pending Verification' : ($status === 'rejected' ? 'Rejected' : 'Unknown'));
                $statusColor = $status === 'approved' ? 'bg-green-700/60 text-green-200' : ($status === 'pending' ? 'bg-yellow-700/60 text-yellow-200' : ($status === 'rejected' ? 'bg-red-700/60 text-red-200' : 'bg-gray-700/60 text-gray-200'));
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xl font-bold text-blue-300 mb-4">Basic Profile</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-100">
                        <div>
                            <span class="text-blue-300">Name:</span>
                            <div>{{ $student->name }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Age:</span>
                            <div>{{ $enr->age ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Grade Level:</span>
                            <div>{{ $enr->grade_level ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Strand:</span>
                            <div>{{ $enr->strand ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">LRN:</span>
                            <div>{{ $enr->lrn ?? '—' }}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-blue-300 mb-4">Registration Status</h3>
                    <div class="flex items-center gap-3">
                        <span class="inline-block px-3 py-1 rounded {{ $statusColor }}">{{ $statusLabel }}</span>
                        <span class="text-blue-300">Documents:</span>
                        @if($docCount > 0)
                            <span class="inline-block px-3 py-1 rounded bg-green-700/60 text-green-200">{{ $docCount }} submitted</span>
                        @else
                            <span class="inline-block px-3 py-1 rounded bg-orange-700/60 text-orange-200">No documents</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xl font-bold text-blue-300 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-100">
                        <div>
                            <span class="text-blue-300">Last Name:</span>
                            <div>{{ $enr->last_name ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">First Name:</span>
                            <div>{{ $enr->first_name ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Middle Name:</span>
                            <div>{{ $enr->middle_name ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Birthdate:</span>
                            <div>{{ optional($enr->birthdate)->format('F d, Y') ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Place of Birth:</span>
                            <div>{{ $enr->place_of_birth ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Sex:</span>
                            <div>{{ $enr->sex ?? '—' }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <span class="text-blue-300">Current Address:</span>
                            <div>{{ $enr->current_address ?? '—' }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <span class="text-blue-300">Permanent Address:</span>
                            <div>{{ $enr->permanent_address ?? '—' }}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-blue-300 mb-4">Contact Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-100">
                        <div>
                            <span class="text-blue-300">Contact Number:</span>
                            <div>{{ $enr->contact_number ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Email:</span>
                            <div>{{ $enr->email ?? $student->email }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xl font-bold text-blue-300 mb-4">Parent / Guardian</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-100">
                        <div>
                            <span class="text-blue-300">Father:</span>
                            <div>{{ $enr->father_name ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Mother:</span>
                            <div>{{ $enr->mother_name ?? '—' }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <span class="text-blue-300">Guardian:</span>
                            <div>{{ $enr->guardian_name ?? '—' }}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-blue-300 mb-4">Registration Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-100">
                        <div>
                            <span class="text-blue-300">School Year:</span>
                            <div>{{ $enr->school_year ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Status:</span>
                            <div>{{ $student->status ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="text-blue-300">Submitted At:</span>
                            <div>{{ optional($enr->created_at)->format('F d, Y h:i A') ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-bold text-blue-300 mb-4">Submitted Requirements</h3>
                @php
                    $hasPSA = !empty($enr?->psa_birth_certificate);
                    $hasForm137 = !empty($enr?->form137);
                    $grade = $enr->grade_level ?? null;
                    $levelTag = $grade && in_array($grade, ['Grade 7','Grade 8','Grade 9','Grade 10'])
                        ? 'JHS'
                        : ($grade && in_array($grade, ['Grade 11','Grade 12']) ? 'SHS' : null);
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-900/30 border border-blue-800/50 rounded-xl p-4">
                        <h4 class="text-base font-semibold text-blue-200 mb-2">PSA Birth Certificate</h4>
                        @if($hasPSA)
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('files.public', ['path' => $enr->psa_birth_certificate]) }}" target="_blank" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-3 py-1 rounded">View</a>
                                <a href="{{ route('files.public', ['path' => $enr->psa_birth_certificate]) }}" target="_blank" download class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-3 py-1 rounded">Download</a>
                            </div>
                        @else
                            <p class="text-sm text-blue-200">No file uploaded.</p>
                        @endif
                    </div>

                    <div class="bg-blue-900/30 border border-blue-800/50 rounded-xl p-4">
                        <h4 class="text-base font-semibold text-blue-200 mb-2">Form 137 (Report Card{{ $levelTag ? ' - ' . $levelTag : '' }})</h4>
                        @if($hasForm137)
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('files.public', ['path' => $enr->form137]) }}" target="_blank" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-3 py-1 rounded">View</a>
                                <a href="{{ route('files.public', ['path' => $enr->form137]) }}" target="_blank" download class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-3 py-1 rounded">Download</a>
                            </div>
                        @else
                            <p class="text-sm text-blue-200">No file uploaded.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection