@extends('layouts.teacher')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-gray-900 relative overflow-hidden p-8">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.1),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(147,51,234,0.08),transparent_40%)]"></div>
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10 mix-blend-overlay"></div>

    <h2 class="relative z-10 text-3xl md:text-4xl font-extrabold mb-8 bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent tracking-wide">
        🧑‍🏫 My Classes
    </h2>

    {{-- Status overview --}}
    <div class="relative z-10 grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-blue-900/40 border border-blue-800/50 rounded-2xl p-5 backdrop-blur-xl">
            <div class="text-blue-200 text-sm">Pre-registered</div>
            <div class="text-2xl font-bold text-blue-100">{{ $preregisteredTotal }}</div>
            <div class="text-xs text-blue-300 mt-1">Students yet to start enrollment</div>
        </div>
        <div class="bg-yellow-900/40 border border-yellow-800/50 rounded-2xl p-5 backdrop-blur-xl">
            <div class="text-yellow-200 text-sm">Pending</div>
            <div class="text-2xl font-bold text-yellow-100">{{ collect($classGroupsFlat)->sum('pending') }}</div>
            <div class="text-xs text-yellow-300 mt-1">Awaiting verification</div>
        </div>
        <div class="bg-green-900/40 border border-green-800/50 rounded-2xl p-5 backdrop-blur-xl">
            <div class="text-green-200 text-sm">Complete</div>
            <div class="text-2xl font-bold text-green-100">{{ collect($classGroupsFlat)->sum('complete') }}</div>
            <div class="text-xs text-green-300 mt-1">Approved with required documents</div>
        </div>
        <div class="bg-orange-900/40 border border-orange-800/50 rounded-2xl p-5 backdrop-blur-xl">
            <div class="text-orange-200 text-sm">Incomplete</div>
            <div class="text-2xl font-bold text-orange-100">{{ collect($classGroupsFlat)->sum('incomplete') }}</div>
            <div class="text-xs text-orange-300 mt-1">Missing required documents</div>
        </div>
    </div>

    <div class="relative z-10 space-y-6">
        @foreach($classGroupsByGrade as $grade => $groups)
            <details class="group bg-blue-900/30 border border-blue-800/30 rounded-2xl">
                <summary class="cursor-pointer list-none px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-semibold text-blue-100">{{ $grade }}</h3>
                        <span class="text-xs px-2 py-1 rounded bg-blue-700/60 text-blue-200 border border-blue-600/40">{{ collect($groups)->sum('total') }} students</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] px-2 py-1 rounded bg-yellow-800/40 text-yellow-200 border border-yellow-700/40">Pending {{ collect($groups)->sum('pending') }}</span>
                        <span class="text-[11px] px-2 py-1 rounded bg-green-800/40 text-green-200 border border-green-700/40">Complete {{ collect($groups)->sum('complete') }}</span>
                        <span class="text-[11px] px-2 py-1 rounded bg-orange-800/40 text-orange-200 border border-orange-700/40">Incomplete {{ collect($groups)->sum('incomplete') }}</span>
                    </div>
                </summary>
                <div class="px-4 pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($groups as $group)
                            <div class="rounded-xl p-4 border border-blue-800/40 bg-blue-900/40 hover:bg-blue-900/60 transition">
                                <div class="flex items-center justify-between">
                                    <p class="text-blue-300 text-sm">{{ $group['strand'] }}</p>
                                    <span class="text-xs px-2 py-1 rounded bg-blue-700/60 text-blue-200">{{ $group['total'] }} students</span>
                                </div>
                                <div class="mt-3 flex items-center gap-2">
                                    <span class="text-[11px] px-2 py-1 rounded bg-yellow-800/40 text-yellow-200 border border-yellow-700/40">Pending {{ $group['pending'] }}</span>
                                    <span class="text-[11px] px-2 py-1 rounded bg-green-800/40 text-green-200 border border-green-700/40">Complete {{ $group['complete'] }}</span>
                                    <span class="text-[11px] px-2 py-1 rounded bg-orange-800/40 text-orange-200 border border-orange-700/40">Incomplete {{ $group['incomplete'] }}</span>
                                    <a href="{{ route('teacher.students.index', ['grade_level' => $group['grade_level'], 'strand' => $group['strand']]) }}" class="ml-auto px-2 py-1 rounded bg-blue-600 hover:bg-blue-500 text-white text-xs">View Students</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </details>
        @endforeach
    </div>
</div>
@endsection
