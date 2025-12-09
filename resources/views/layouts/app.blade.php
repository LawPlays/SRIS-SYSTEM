<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Student Dashboard') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: #e2e8f0;
        }

        aside {
            background: linear-gradient(180deg, #1e3a8a 0%, #0f172a 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        }

        nav a {
            transition: all 0.2s ease-in-out;
        }

        nav a:hover {
            transform: translateX(5px);
            background: rgba(59, 130, 246, 0.25);
        }

        nav a.active {
            background: rgba(37, 99, 235, 0.4);
            color: #93c5fd;
            font-weight: 600;
        }

        main {
            background: transparent;
        }

        .content-card {
            background: rgba(30, 58, 138, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }

        button:hover {
            transform: scale(1.05);
            transition: 0.2s;
        }
    </style>
</head>
<body class="font-sans min-h-screen flex text-gray-100">

@auth
    @if(auth()->user()->role === 'teacher')
        @include('layouts.partials.teacher-nav')
    @endif
@endauth

<div x-data="{ sidebarOpen: true }" class="flex h-screen w-full overflow-hidden">
    
    <!-- Collapsed-state arrow at center-left of viewport -->
    
    
    
    <!-- Sidebar (hidden for Teacher) -->
@if(!auth()->check() || auth()->user()->role !== 'teacher')
<aside x-show="sidebarOpen"
       x-transition:enter="transform transition ease-out duration-200"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transform transition ease-in duration-150"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="relative w-64 flex flex-col bg-gradient-to-b from-blue-900 via-blue-800 to-blue-900 text-gray-100 shadow-xl">
    
    <!-- Logo -->
    <div class="h-12"></div>
    <div class="flex items-center justify-center h-24">
        @php
            $srisMark = null;
            $dir = public_path('images');
            if (is_dir($dir)) {
                $patterns = ['/*.png','/*.jpg','/*.jpeg','/*.svg','/*.webp'];
                $files = [];
                foreach ($patterns as $p) { $files = array_merge($files, glob($dir.$p)); }
                foreach ($files as $f) {
                    if (strtolower(basename($f)) !== 'logo.png') { $srisMark = asset('images/'.basename($f)); break; }
                }
            }
        @endphp
        @auth
            @if($srisMark)
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ $srisMark }}" alt="School Logo" class="h-20 w-auto">
                    </a>
                @elseif(auth()->user()->role === 'teacher')
                    <a href="{{ route('teacher.dashboard') }}">
                        <img src="{{ $srisMark }}" alt="School Logo" class="h-20 w-auto">
                    </a>
                @else
                    <a href="{{ route('student.dashboard') }}">
                        <img src="{{ $srisMark }}" alt="School Logo" class="h-20 w-auto">
                    </a>
                @endif
            @endif
        @else
            @if($srisMark)
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}">
                        <img src="{{ $srisMark }}" alt="School Logo" class="h-20 w-auto">
                    </a>
                </div>
            @endif
        @endauth
    </div>

    <!-- Profile Card -->
    <div class="mx-4 my-4 p-4 bg-blue-700/40 rounded-2xl shadow-lg backdrop-blur-md flex items-center space-x-3 transition hover:bg-blue-700/60">
        <span class="material-icons text-blue-200 text-4xl">account_circle</span>
        <div class="flex flex-col">
            @auth
                <div class="font-semibold text-white">{{ Auth::user()->name }}</div>
            @else
                <div class="font-semibold text-white">Guest</div>
                <div class="text-sm text-blue-200">Not logged in</div>
            @endauth
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 mt-2 px-4 space-y-2 overflow-y-auto">
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-red-400 hover:bg-red-900/30 hover:text-red-300 transition">
                   <span class="material-icons mr-3">admin_panel_settings</span>
                   Admin Dashboard
                </a>

                <a href="{{ route('admin.announcements.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition 
                          {{ request()->routeIs('admin.announcements.*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-700/50 hover:text-white text-gray-200' }}">
                   <span class="material-icons mr-3">announcement</span>
                   Announcements
                </a>

                <a href="{{ route('admin.teachers.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition 
                          {{ request()->routeIs('admin.teachers.*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-700/50 hover:text-white text-gray-200' }}">
                   <span class="material-icons mr-3">school</span>
                   Teacher Management
                </a>

                <a href="{{ route('admin.teachers.create') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition 
                          {{ request()->routeIs('admin.teachers.create') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-green-700/50 hover:text-white text-gray-200' }}">
                   <span class="material-icons mr-3">person_add</span>
                   Create Teacher Account
                </a>
            @else
                <a href="{{ route('student.dashboard') }}" 
                          class="flex items-center px-4 py-3 rounded-xl transition 
                          {{ request()->routeIs('student.dashboard') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-700/50 hover:text-white text-gray-200' }}">
                   <span class="material-icons mr-3">dashboard</span>
                   Dashboard
                </a>

                <a href="{{ route('student.announcements.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition 
                          {{ request()->routeIs('student.announcements.*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-700/50 hover:text-white text-gray-200' }}">
                   <span class="material-icons mr-3">announcement</span>
                   Announcements
                </a>


                <!-- Registration Forms Dropdown -->
                <div x-data="{ open: {{ request()->routeIs('student.enrollment.*') ? 'true' : 'false' }} }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                    <button class="flex items-center w-full px-4 py-3 rounded-xl transition 
                                   {{ request()->routeIs('student.enrollment.*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-700/50 hover:text-white text-gray-200' }}">
                        <span class="material-icons mr-3">assignment</span>
                        Registration Forms
                        <span class="material-icons ml-auto transition-transform" :class="{ 'rotate-180': open }">expand_more</span>
                    </button>
                    
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="ml-4 mt-2 space-y-1">
                        
                        <a href="{{ route('student.enrollment.shs.create') }}" 
                           class="flex items-center px-4 py-2 rounded-lg transition text-sm
                                  {{ request()->routeIs('student.enrollment.shs.*') ? 'bg-blue-500 text-white' : 'hover:bg-blue-700/30 text-gray-300' }}">
                           <span class="material-icons mr-2 text-sm">school</span>
                           Senior High School
                        </a>
                        
                        <a href="{{ route('student.enrollment.jhs.create') }}" 
                           class="flex items-center px-4 py-2 rounded-lg transition text-sm
                                  {{ request()->routeIs('student.enrollment.jhs.*') ? 'bg-blue-500 text-white' : 'hover:bg-blue-700/30 text-gray-300' }}">
                           <span class="material-icons mr-2 text-sm">school</span>
                           Junior High School
                        </a>
                    </div>
                </div>

                <a href="{{ route('student.documents.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition 
                          {{ request()->routeIs('student.documents.*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-700/50 hover:text-white text-gray-200' }}">
                   <span class="material-icons mr-3">folder</span>
                   My Documents
                </a>

                <a href="{{ route('student.profile') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition 
                          {{ request()->routeIs('student.profile') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-700/50 hover:text-white text-gray-200' }}">
                   <span class="material-icons mr-3">account_circle</span>
                   My Profile
                </a>

                <a href="{{ route('student.notifications.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition relative
                          {{ request()->routeIs('student.notifications.*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-blue-700/50 hover:text-white text-gray-200' }}">
                   <span class="material-icons mr-3">notifications</span>
                   Notifications
                   @if(auth()->user()->unreadNotifications->count() > 0)
                       <span class="absolute top-2 right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                           {{ auth()->user()->unreadNotifications->count() }}
                       </span>
                   @endif
                </a>
            @endif
        @endauth
    </nav>

    <!-- Logout -->
    <div class="mx-4 my-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-3 rounded-xl text-red-400 hover:bg-red-900/30 hover:text-red-300 transition">
                <span class="material-icons mr-3">logout</span>
                Log Out
            </button>
        </form>
    </div>
</aside>
@endif

    


    <!-- Open-state arrow at seam center of viewport -->
    <button x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed top-1/2 -translate-y-1/2 left-[16.25rem] z-50 text-white hover:opacity-90 transition">
        <span class="material-icons text-3xl drop-shadow">chevron_left</span>
    </button>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden relative">
        <main class="flex-1 overflow-y-auto p-8 relative z-10">
            
            <button x-show="!sidebarOpen" @click="sidebarOpen = true" class="fixed left-0 top-1/2 -translate-y-1/2 text-white z-50 hover:opacity-90 transition">
                <span class="material-icons text-3xl drop-shadow">chevron_right</span>
            </button>
            @php($isTeacher = auth()->check() && auth()->user()->role === 'teacher')

            @isset($header)
                <div class="max-w-5xl mx-auto mb-6" @if($isTeacher) style="max-width: none;" @endif>
                    <div class="bg-blue-900/60 border border-blue-800 text-white rounded-xl px-6 py-4 shadow">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            @if($isTeacher)
                <div class="px-4 sm:px-6 lg:px-8">
                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </div>
            @else
                <div class="max-w-5xl mx-auto content-card">
                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </div>
            @endif
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            background: '#1e3a8a',
            color: '#e0f2fe',
            confirmButtonColor: '#3b82f6'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            background: '#1e3a8a',
            color: '#e0f2fe',
            confirmButtonColor: '#ef4444'
        });
    </script>
@endif
</body>
</html>
