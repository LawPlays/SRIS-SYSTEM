@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-gray-900 relative overflow-hidden p-10">

    {{-- Floating Tech Grid Background --}}
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.15),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(147,51,234,0.1),transparent_40%)]"></div>
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10 mix-blend-overlay"></div>

    {{-- Neon Glow Orbs --}}
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-blue-700/30 rounded-full blur-[180px]"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-700/20 rounded-full blur-[180px]"></div>

    <div class="relative z-10 max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent tracking-wide drop-shadow-[0_0_25px_rgba(59,130,246,0.4)]">
                👨‍🏫 Create Teacher Account
            </h1>
            <a href="{{ route('admin.teachers.index') }}" 
               class="group relative overflow-hidden rounded-xl border border-blue-400/20 
                      bg-gradient-to-b from-blue-900/40 to-gray-900/20 backdrop-blur-xl 
                      hover:border-blue-500/60 shadow-[0_0_20px_-5px_rgba(59,130,246,0.4)] 
                      hover:shadow-[0_0_40px_-5px_rgba(59,130,246,0.6)] 
                      hover:-translate-y-1 transition-all duration-700 ease-out px-6 py-3">
                <span class="relative z-10 text-white font-semibold">← Return to Teachers</span>
            </a>
        </div>

        <div class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 p-8">
        <form method="POST" action="{{ route('admin.teachers.store') }}">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-gray-100 text-sm font-bold mb-2">
                    Full Name <span class="text-red-400">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 bg-white/90 border border-white/30 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-400/50 transition duration-200"
                       placeholder="Enter teacher's full name"
                       required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block text-gray-100 text-sm font-bold mb-2">
                    Email Address <span class="text-red-400">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       class="w-full px-4 py-3 bg-white/90 border border-white/30 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-400/50 transition duration-200"
                       placeholder="Enter teacher's email address"
                       required>
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-100 text-sm font-bold mb-2">
                    Password <span class="text-red-400">*</span>
                </label>
                <input type="password" 
                       id="password" 
                       name="password"
                       class="w-full px-4 py-3 bg-white/90 border border-white/30 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-400/50 transition duration-200"
                       placeholder="Enter password"
                       required>
                @error('password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-100 text-sm font-bold mb-2">
                    Confirm Password <span class="text-red-400">*</span>
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation"
                       class="w-full px-4 py-3 bg-white/90 border border-white/30 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-400/50 transition duration-200"
                       placeholder="Confirm password"
                       required>
                @error('password_confirmation')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-500/20 border border-blue-400/40 rounded-xl p-6 mb-8 backdrop-blur-sm">
                <div class="flex items-start">
                    <div class="bg-blue-500/30 p-2 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold mb-3 text-blue-200 text-lg">Teacher Account Information:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-100">
                            <li>The teacher will be able to log in immediately after creation</li>
                            <li>Teachers can manage student registrations and create announcements</li>
                            <li>Account status will be set to "Active" by default</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.teachers.index') }}" 
                   class="group relative overflow-hidden rounded-xl border border-gray-400/20 
                          bg-gradient-to-b from-gray-700/40 to-gray-900/20 backdrop-blur-xl 
                          hover:border-gray-400/60 shadow-[0_0_20px_-5px_rgba(107,114,128,0.4)] 
                          hover:shadow-[0_0_40px_-5px_rgba(107,114,128,0.6)] 
                          hover:-translate-y-1 transition-all duration-300 ease-out px-6 py-3">
                    <span class="relative z-10 text-white font-semibold">Cancel</span>
                </a>
                <button type="submit" 
                        class="group relative overflow-hidden rounded-xl border border-green-400/20 
                               bg-gradient-to-b from-green-600/40 to-green-900/20 backdrop-blur-xl 
                               hover:border-green-400/60 shadow-[0_0_20px_-5px_rgba(34,197,94,0.4)] 
                               hover:shadow-[0_0_40px_-5px_rgba(34,197,94,0.6)] 
                               hover:-translate-y-1 transition-all duration-300 ease-out px-6 py-3">
                    <span class="relative z-10 text-white font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Create Teacher Account
                    </span>
                </button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection