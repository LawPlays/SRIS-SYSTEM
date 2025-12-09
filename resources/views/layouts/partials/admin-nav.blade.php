{{-- 🔹 Navbar Section --}}
<nav class="relative z-30 sticky top-0 backdrop-blur-xl bg-gradient-to-r from-gray-900/90 via-blue-900/90 to-indigo-900/90 border-b border-white/10 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Left Section (Logo + Nav Links) --}}
            <div class="flex items-center space-x-8">
                {{-- Logo beside text (optional small logo) --}}
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center text-white font-semibold text-lg">
                    <img src="{{ $srisMark ?? asset('images/logo.png') }}" alt="Small Logo" class="h-8 w-auto mr-2">
                    <span class="bg-gradient-to-r from-blue-400 to-indigo-400 text-transparent bg-clip-text">Admin Panel</span>
                </a>

                {{-- Navigation Links --}}
                <div class="hidden sm:flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.dashboard') 
                                  ? 'bg-blue-600/30 text-blue-300 shadow-inner' 
                                  : 'text-gray-300 hover:bg-blue-600/20 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                   d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.students.index') }}" 
                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.students.*') 
                                  ? 'bg-blue-600/30 text-blue-300 shadow-inner' 
                                  : 'text-gray-300 hover:bg-blue-600/20 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                   d="M17 20h5v-2a4 4 0 00-3-3.87V13a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87V13a4 4 0 013-3.87m0-4A4 4 0 0116 5v1a4 4 0 01-8 0V5z" />
                        </svg>
                        Students
                    </a>

                    <a href="{{ route('admin.teachers.index') }}" 
                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.teachers.*') 
                                  ? 'bg-blue-600/30 text-blue-300 shadow-inner' 
                                  : 'text-gray-300 hover:bg-blue-600/20 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                   d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                        Teachers
                    </a>

                    <a href="{{ route('admin.teachers.create') }}" 
                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.teachers.create') 
                                  ? 'bg-green-600/30 text-green-300 shadow-inner' 
                                  : 'text-gray-300 hover:bg-green-600/20 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                   d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create Teacher
                    </a>

                    <a href="{{ route('admin.announcements.index') }}" 
                       class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.announcements.*') 
                                  ? 'bg-blue-600/30 text-blue-300 shadow-inner' 
                                  : 'text-gray-300 hover:bg-blue-600/20 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                   d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        Announcements
                    </a>

                    {{-- Reports Dropdown --}}
                    <div class="relative group">
                        <button type="button" id="reportsToggle"
                                class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 cursor-pointer
                                       {{ request()->routeIs('admin.reports.*')
                                           ? 'bg-blue-600/30 text-blue-300 shadow-inner'
                                           : 'text-gray-300 hover:bg-blue-600/20 hover:text-white' }}"
                                aria-haspopup="true" aria-expanded="false" aria-controls="reportsDropdown">
                            Reports
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.51a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="reportsDropdown" class="absolute left-0 top-full mt-2 w-56 z-40 bg-gray-900/95 border border-white/10 rounded-lg shadow-xl py-2 hidden group-hover:block">
                            <a href="{{ route('admin.reports.dashboard') }}" 
                               class="block px-4 py-2 text-sm whitespace-nowrap text-gray-200 hover:bg-blue-600/20 hover:text-white {{ request()->routeIs('admin.reports.dashboard') ? 'bg-blue-600/10 text-blue-300' : '' }}">
                                Reports Dashboard
                            </a>
                            <a href="{{ route('admin.reports.enhanced') }}" 
                               class="block px-4 py-2 text-sm whitespace-nowrap text-gray-200 hover:bg-blue-600/20 hover:text-white {{ request()->routeIs('admin.reports.enhanced') ? 'bg-blue-600/10 text-blue-300' : '' }}">
                                Enhanced Dashboard
                            </a>
                            <a href="{{ route('admin.reports.enrollment-report') }}" 
                               class="block px-4 py-2 text-sm whitespace-nowrap text-gray-200 hover:bg-blue-600/20 hover:text-white {{ request()->routeIs('admin.reports.enrollment-report') ? 'bg-blue-600/10 text-blue-300' : '' }}">
                                Enrollment Report
                            </a>
                            <a href="{{ route('admin.reports.system-monitoring') }}" 
                               class="block px-4 py-2 text-sm whitespace-nowrap text-gray-200 hover:bg-blue-600/20 hover:text-white {{ request()->routeIs('admin.reports.system-monitoring') ? 'bg-blue-600/10 text-blue-300' : '' }}">
                                System Monitoring
                            </a>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const toggle = document.getElementById('reportsToggle');
                            const menu = document.getElementById('reportsDropdown');
                            if (!toggle || !menu) return;
                            const hiddenClass = 'hidden';
                            const openClass = 'block';
                            const openMenu = () => {
                                menu.classList.remove(hiddenClass);
                                menu.classList.add(openClass);
                                toggle.setAttribute('aria-expanded', 'true');
                            };
                            const closeMenu = () => {
                                menu.classList.add(hiddenClass);
                                menu.classList.remove(openClass);
                                toggle.setAttribute('aria-expanded', 'false');
                            };
                            toggle.addEventListener('click', function (e) {
                                e.preventDefault();
                                if (menu.classList.contains(hiddenClass)) openMenu(); else closeMenu();
                            });
                            document.addEventListener('click', function (e) {
                                if (!menu.contains(e.target) && !toggle.contains(e.target)) closeMenu();
                            });
                            document.addEventListener('keydown', function (e) {
                                if (e.key === 'Escape') closeMenu();
                            });
                        });
                    </script>
                </div>
            </div>

            {{-- Right Section (Logout) --}}
            <div class="hidden sm:flex items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600/80 hover:bg-red-600 text-white 
                                   font-medium shadow hover:shadow-red-800/30 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                   d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-9V7" />
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>
