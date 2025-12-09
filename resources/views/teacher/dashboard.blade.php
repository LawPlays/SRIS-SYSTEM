@extends('layouts.teacher')

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
        👨‍🏫 Teacher Dashboard
    </h2>

    {{-- Stat Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-10 relative z-10">

        {{-- Total Students --}}
        <a href="{{ route('teacher.students.index') }}"
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
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <p class="text-blue-200/80 text-sm tracking-wide">My Students</p>
                <p class="text-5xl font-extrabold text-blue-400 drop-shadow-lg mt-2">{{ $total ?? '0' }}</p>
            </div>
        </a>

        {{-- Pending Reviews --}}
        <a href="{{ route('teacher.students.index', ['status' => 'pending']) }}"
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
                <p class="text-yellow-200/80 text-sm tracking-wide">Pending Reviews</p>
                <p class="text-5xl font-extrabold text-yellow-400 drop-shadow-lg mt-2">{{ $pending ?? '0' }}</p>
            </div>
        </a>

        
        
    </div>

    {{-- Quick Actions Section --}}
    <div class="mt-16 grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-8 relative z-10">
        
        {{-- Announcements --}}
        <a href="{{ route('teacher.announcements.index') }}"
           class="group relative overflow-hidden rounded-2xl border border-cyan-400/20 
                  bg-gradient-to-b from-cyan-900/40 to-gray-900/20 backdrop-blur-xl 
                  hover:border-cyan-400/60 shadow-[0_0_20px_-5px_rgba(6,182,212,0.4)] 
                  hover:shadow-[0_0_40px_-5px_rgba(6,182,212,0.6)] 
                  hover:-translate-y-1 transition-all duration-700 ease-out p-6">

            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-tr from-cyan-500/30 via-blue-400/20 to-transparent blur-2xl transition-all duration-700"></div>

            <div class="relative flex items-center space-x-4">
                <div class="bg-gradient-to-br from-cyan-600 to-blue-500 p-4 rounded-xl ring-4 ring-cyan-400/30 shadow-lg
                            group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-cyan-300 group-hover:text-cyan-200 transition-colors">Announcements</h3>
                    <p class="text-cyan-200/70 text-sm">Manage school announcements</p>
                </div>
            </div>
        </a>

        

        

    </div>
</div>
@endsection
