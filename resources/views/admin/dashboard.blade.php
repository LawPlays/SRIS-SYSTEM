@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-gray-900 relative overflow-hidden p-10">

    {{-- Floating Tech Grid Background --}}
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.15),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(147,51,234,0.1),transparent_40%)]"></div>
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10 mix-blend-overlay"></div>

    {{-- Neon Glow Orbs --}}
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-blue-700/30 rounded-full blur-[180px]"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-700/20 rounded-full blur-[180px]"></div>

    {{-- Title --}}
    <h2 class="text-4xl font-extrabold text-center mb-14 bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent tracking-wide drop-shadow-[0_0_25px_rgba(59,130,246,0.4)]">
        🎓 School Management Dashboard
    </h2>

    {{-- Stat Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 relative z-10">

        {{-- Total Students --}}
        <a href="{{ route('admin.students.index') }}"
           class="group relative overflow-hidden rounded-2xl border border-blue-400/20 
                  bg-gradient-to-b from-blue-900/40 to-gray-900/20 backdrop-blur-xl 
                  hover:border-blue-500/60 shadow-[0_0_20px_-5px_rgba(59,130,246,0.4)] 
                  hover:shadow-[0_0_40px_-5px_rgba(59,130,246,0.6)] 
                  hover:-translate-y-1 transition-all duration-700 ease-out">

            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-tr from-blue-500/30 via-cyan-400/20 to-transparent blur-2xl transition-all duration-700"></div>

            <div class="relative p-8 flex flex-col items-center">
                <div class="bg-gradient-to-br from-blue-600 to-cyan-500 p-5 rounded-xl ring-4 ring-blue-400/30 shadow-lg mb-6
                            group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 2L2 7l10 5 10-5-10-5zm0 13l-10-5v6a2 2 0 002 2h16a2 2 0 002-2v-6l-10 5z"/>
                    </svg>
                </div>
                <p class="text-blue-200/80 text-sm tracking-wide">Total Students</p>
                <p class="text-5xl font-extrabold text-blue-400 drop-shadow-lg mt-2">{{ $total }}</p>
            </div>
        </a>

        {{-- Pending --}}
        <a href="{{ route('admin.students.index', ['status' => 'pending']) }}"
           class="group relative overflow-hidden rounded-2xl border border-yellow-400/20 
                  bg-gradient-to-b from-yellow-900/40 to-gray-900/20 backdrop-blur-xl 
                  hover:border-yellow-400/60 shadow-[0_0_20px_-5px_rgba(234,179,8,0.4)] 
                  hover:shadow-[0_0_40px_-5px_rgba(234,179,8,0.6)] 
                  hover:-translate-y-1 transition-all duration-700 ease-out">

            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-tr from-yellow-500/30 via-amber-400/20 to-transparent blur-2xl transition-all duration-700"></div>

            <div class="relative p-8 flex flex-col items-center">
                <div class="bg-gradient-to-br from-yellow-500 to-amber-400 p-5 rounded-xl ring-4 ring-yellow-400/20 shadow-lg mb-6
                            group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-yellow-200/80 text-sm tracking-wide">Pending Applications</p>
                <p class="text-5xl font-extrabold text-yellow-400 drop-shadow-lg mt-2">{{ $pending }}</p>
            </div>
        </a>

        {{-- Approved --}}
        <a href="{{ route('admin.students.index', ['status' => 'approved']) }}"
           class="group relative overflow-hidden rounded-2xl border border-green-400/20 
                  bg-gradient-to-b from-green-900/40 to-gray-900/20 backdrop-blur-xl 
                  hover:border-green-400/60 shadow-[0_0_20px_-5px_rgba(34,197,94,0.4)] 
                  hover:shadow-[0_0_40px_-5px_rgba(34,197,94,0.6)] 
                  hover:-translate-y-1 transition-all duration-700 ease-out">

            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-tr from-green-500/30 via-emerald-400/20 to-transparent blur-2xl transition-all duration-700"></div>

            <div class="relative p-8 flex flex-col items-center">
                <div class="bg-gradient-to-br from-green-600 to-emerald-500 p-5 rounded-xl ring-4 ring-green-400/20 shadow-lg mb-6
                            group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-green-200/80 text-sm tracking-wide">Approved Students</p>
                <p class="text-5xl font-extrabold text-green-400 drop-shadow-lg mt-2">{{ $approved }}</p>
            </div>
        </a>

        {{-- Rejected --}}
        <a href="{{ route('admin.students.index', ['status' => 'rejected']) }}"
           class="group relative overflow-hidden rounded-2xl border border-red-400/20 
                  bg-gradient-to-b from-red-900/40 to-gray-900/20 backdrop-blur-xl 
                  hover:border-red-500/60 shadow-[0_0_20px_-5px_rgba(239,68,68,0.4)] 
                  hover:shadow-[0_0_40px_-5px_rgba(239,68,68,0.6)] 
                  hover:-translate-y-1 transition-all duration-700 ease-out">

            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-tr from-red-600/30 via-rose-500/20 to-transparent blur-2xl transition-all duration-700"></div>

            <div class="relative p-8 flex flex-col items-center">
                <div class="bg-gradient-to-br from-red-600 to-rose-600 p-5 rounded-xl ring-4 ring-red-400/20 shadow-lg mb-6
                            group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <p class="text-red-200/80 text-sm tracking-wide">Rejected Applications</p>
                <p class="text-5xl font-extrabold text-red-400 drop-shadow-lg mt-2">{{ $rejected }}</p>
            </div>
        </a>

    </div>
</div>
@endsection
