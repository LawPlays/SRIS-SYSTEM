@extends('layouts.app')

@section('content')
<div class="space-y-8 bg-gradient-to-br from-blue-700 via-indigo-700 to-purple-700 p-6 rounded-2xl text-white">

    {{-- 🎉 Welcome Banner --}}
    <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-purple-600 p-8 rounded-2xl shadow-lg text-center text-white">
        <h1 class="text-4xl font-bold">
            🎓 Welcome Students!
        </h1>
        <p class="mt-2 text-lg opacity-90">
            A new journey begins — let's make this school year awesome together!
        </p>
        <div class="mt-3 flex justify-center gap-6 text-sm opacity-80">
            <span>📅 {{ now()->timezone(config('app.timezone'))->format('l, F j, Y') }}</span>
            <span>⏰ {{ now()->timezone(config('app.timezone'))->format('h:i A') }}</span>
        </div>
    </div>

    {{-- 📊 Quick Status (Dynamic) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-tr from-purple-600 to-purple-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold flex items-center">
                <span class="material-icons mr-2">campaign</span>
                Announcements
            </h3>
            <p class="mt-2 text-3xl font-bold">{{ $announcements->count() }}</p>
            <p class="text-sm opacity-90">Latest active announcements</p>
        </div>
        <div class="bg-gradient-to-tr from-blue-600 to-blue-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold flex items-center">
                <span class="material-icons mr-2">assignment_turned_in</span>
                Enrollment Status
            </h3>
            @if(isset($enrollment) && $enrollment)
                <p class="mt-2">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-white/20">
                        {{ ucfirst($enrollment->status ?? 'pending') }}
                    </span>
                </p>
                @if($enrollment->rejection_reason)
                    <p class="mt-2 text-sm opacity-90">Reason: {{ $enrollment->rejection_reason }}</p>
                @endif
            @else
                <p class="mt-2 text-sm opacity-90">No enrollment submitted yet.</p>
            @endif
        </div>
    </div>

    {{-- 📢 Recent Announcements --}}
    @if($announcements->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg p-6 text-gray-800">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="material-icons mr-2 text-purple-600">announcement</span>
                Recent Announcements
            </h2>
        </div>
        
        <div class="space-y-4">
            @foreach($announcements as $announcement)
                <div class="border-l-4 {{ $announcement->priority == 3 ? 'border-red-500 bg-red-50' : ($announcement->priority == 2 ? 'border-yellow-500 bg-yellow-50' : 'border-green-500 bg-green-50') }} p-4 rounded-r-lg">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 flex items-center">
                                {{ $announcement->title }}
                                @if($announcement->priority == 3)
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-red-500 text-white">High Priority</span>
                                @elseif($announcement->priority == 2)
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500 text-white">Medium Priority</span>
                                @endif
                            </h3>
                            <p class="text-gray-700 mt-2">{{ Str::limit($announcement->content, 200) }}</p>
                            <div class="flex items-center mt-3 text-sm text-gray-500">
                                <span class="material-icons text-sm mr-1">person</span>
                                {{ $announcement->user->name }}
                                <span class="mx-2">•</span>
                                <span class="material-icons text-sm mr-1">schedule</span>
                                {{ $announcement->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ⚡ Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 max-w-md mx-auto">
        {{-- Profile --}}
        <a href="{{ route('student.profile') }}" 
           class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition text-center group hover:bg-gradient-to-br hover:from-purple-50 hover:to-pink-50 border-2 border-transparent hover:border-purple-200 text-gray-800">
            <div class="text-4xl mb-3">👤</div>
            <h3 class="mt-2 font-bold text-gray-800 group-hover:text-purple-700">My Profile</h3>
            <p class="text-gray-500 text-sm group-hover:text-purple-600">View and edit your profile</p>
        </a>
    </div>

</div>
@endsection
