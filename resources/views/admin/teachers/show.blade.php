@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-gray-900 relative overflow-hidden p-10">

    {{-- Floating Tech Grid Background --}}
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.15),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(147,51,234,0.1),transparent_40%)]"></div>
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10 mix-blend-overlay"></div>

    {{-- Neon Glow Orbs --}}
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-blue-700/30 rounded-full blur-[180px]"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-700/20 rounded-full blur-[180px]"></div>

    {{-- Header --}}
    <div class="flex justify-between items-center mb-14 relative z-10">
        <div>
            <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent tracking-wide drop-shadow-[0_0_25px_rgba(59,130,246,0.4)]">
                👨‍🏫 Teacher Details
            </h1>
            <p class="text-gray-400 mt-2">View teacher account information and statistics</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.teachers.index') }}" 
               class="btn btn-gray btn-lg">
                Back to Teachers
            </a>
            <a href="{{ route('admin.teachers.edit', $teacher) }}" 
               class="btn btn-yellow btn-lg">
                Edit Teacher
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="relative z-10 mb-6 p-4 rounded-xl border border-green-400/20 bg-gradient-to-r from-green-900/40 to-emerald-900/20 backdrop-blur-xl text-green-300 shadow-[0_0_20px_-5px_rgba(34,197,94,0.4)]">
            {{ session('success') }}
        </div>
    @endif

    {{-- Teacher Information Card --}}
    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Main Info Card --}}
        <div class="lg:col-span-2 overflow-hidden rounded-2xl border border-blue-400/20 
                    bg-gradient-to-b from-blue-900/40 to-gray-900/20 backdrop-blur-xl 
                    shadow-[0_0_20px_-5px_rgba(59,130,246,0.4)]">
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center text-3xl text-white font-bold mr-6">
                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2">{{ $teacher->name }}</h2>
                        <p class="text-blue-300 text-lg">{{ $teacher->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-blue-200 mb-2">📧 Email Address</label>
                            <div class="p-3 rounded-lg bg-gray-800/50 border border-gray-600/30 text-white">
                                {{ $teacher->email }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-blue-200 mb-2">👤 Full Name</label>
                            <div class="p-3 rounded-lg bg-gray-800/50 border border-gray-600/30 text-white">
                                {{ $teacher->name }}
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-blue-200 mb-2">📊 Account Status</label>
                            <div class="p-3 rounded-lg bg-gray-800/50 border border-gray-600/30">
                                @if($teacher->status === 'approved')
                                    <span class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg">✅ Active</span>
                                @else
                                    <span class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg">❌ Suspended</span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-blue-200 mb-2">🎭 Role</label>
                            <div class="p-3 rounded-lg bg-gray-800/50 border border-gray-600/30 text-white">
                                <span class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-purple-500 to-indigo-500 text-white shadow-lg">👨‍🏫 Teacher</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-600/30">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-blue-200 mb-2">📅 Account Created</label>
                            <div class="p-3 rounded-lg bg-gray-800/50 border border-gray-600/30 text-white">
                                {{ $teacher->created_at->format('F d, Y \a\t g:i A') }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-blue-200 mb-2">🔄 Last Updated</label>
                            <div class="p-3 rounded-lg bg-gray-800/50 border border-gray-600/30 text-white">
                                {{ $teacher->updated_at->format('F d, Y \a\t g:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Card --}}
        <div class="space-y-6">
            <div class="overflow-hidden rounded-2xl border border-purple-400/20 
                        bg-gradient-to-b from-purple-900/40 to-gray-900/20 backdrop-blur-xl 
                        shadow-[0_0_20px_-5px_rgba(147,51,234,0.4)]">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Statistics</h3>
                    
                    <div class="space-y-4">
                        <div class="p-4 rounded-lg bg-gray-800/50 border border-gray-600/30">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300">📢 Announcements</span>
                                <span class="text-2xl font-bold text-purple-400">{{ $announcementCount }}</span>
                            </div>
                        </div>
                        
                        <div class="p-4 rounded-lg bg-gray-800/50 border border-gray-600/30">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300">📚 Classes</span>
                                <span class="text-2xl font-bold text-blue-400">0</span>
                            </div>
                        </div>
                        
                        <div class="p-4 rounded-lg bg-gray-800/50 border border-gray-600/30">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300">👥 Students</span>
                                <span class="text-2xl font-bold text-green-400">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions Card --}}
            <div class="overflow-hidden rounded-2xl border border-orange-400/20 
                        bg-gradient-to-b from-orange-900/40 to-gray-900/20 backdrop-blur-xl 
                        shadow-[0_0_20px_-5px_rgba(251,146,60,0.4)]">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Quick Actions</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" 
                           class="btn btn-yellow w-full">
                            Edit Account
                        </a>
                        
                        @if($teacher->status === 'approved')
                            <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="w-full">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="name" value="{{ $teacher->name }}">
                                <input type="hidden" name="email" value="{{ $teacher->email }}">
                                <input type="hidden" name="status" value="suspended">
                                <button type="submit" 
                                        class="btn btn-red w-full"
                                        onclick="return confirm('Are you sure you want to suspend this teacher?')">
                                    Suspend Account
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="w-full">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="name" value="{{ $teacher->name }}">
                                <input type="hidden" name="email" value="{{ $teacher->email }}">
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" 
                                        class="btn btn-green w-full"
                                        onclick="return confirm('Are you sure you want to activate this teacher?')">
                                    Activate Account
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection