{{-- 🔹 Teacher Navbar (matches Admin style) --}}
<nav class="relative z-30 sticky top-0 backdrop-blur-xl bg-gradient-to-r from-gray-900/90 via-blue-900/90 to-indigo-900/90 border-b border-white/10 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Left: Logo + Links --}}
            <div class="flex items-center space-x-8">
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
                <a href="{{ route('teacher.dashboard') }}" class="flex items-center text-white font-semibold text-lg">
                    <img src="{{ $srisMark ?? asset('images/logo.png') }}" alt="Small Logo" class="h-8 w-auto mr-2">
                    <span class="bg-gradient-to-r from-blue-400 to-indigo-400 text-transparent bg-clip-text">Teacher Panel</span>
                </a>

                <div class="hidden sm:flex space-x-6">
                    <a href="{{ route('teacher.dashboard') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('teacher.dashboard') 
                                  ? 'bg-blue-600/30 text-blue-300 shadow-inner' 
                                  : 'text-gray-300 hover:bg-blue-600/20 hover:text-white' }}">
                        <span class="material-icons mr-2">dashboard</span>
                        Dashboard
                    </a>

                    <a href="{{ route('teacher.students.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('teacher.students.*') 
                                  ? 'bg-blue-600/30 text-blue-300 shadow-inner' 
                                  : 'text-gray-300 hover:bg-blue-600/20 hover:text-white' }}">
                        <span class="material-icons mr-2">groups</span>
                        Students
                    </a>

                    <a href="{{ route('teacher.enrollments.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('teacher.enrollments.*') 
                                  ? 'bg-blue-600/30 text-blue-300 shadow-inner' 
                                  : 'text-gray-300 hover:bg-blue-600/20 hover:text-white' }}">
                        <span class="material-icons mr-2">assignment</span>
                        Registrations
                    </a>

                    <a href="{{ route('teacher.classes.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('teacher.classes.*') 
                                  ? 'bg-blue-600/30 text-blue-300 shadow-inner' 
                                  : 'text-gray-300 hover:bg-blue-600/20 hover:text-white' }}">
                        <span class="material-icons mr-2">class</span>
                        Classes
                    </a>


                    <a href="{{ route('teacher.announcements.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('teacher.announcements.*') 
                                  ? 'bg-blue-600/30 text-blue-300 shadow-inner' 
                                  : 'text-gray-300 hover:bg-blue-600/20 hover:text-white' }}">
                        <span class="material-icons mr-2">announcement</span>
                        Announcements
                    </a>
                </div>
            </div>

            {{-- Right: Logout --}}
            <div class="hidden sm:flex items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600/80 hover:bg-red-600 text-white 
                                   font-medium shadow hover:shadow-red-800/30 transition-all duration-200">
                        <span class="material-icons h-5 w-5">logout</span>
                        Log Out
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>
