<div class="flex h-screen bg-gray-50">
    <nav class="bg-white w-64 flex flex-col justify-between border-r border-gray-200 shadow-lg">
        <div>
            <div class="flex items-center justify-center h-24 border-b border-gray-200">
                <a href="{{ route('student.dashboard') }}">
                    <x-application-logo class="h-14 w-auto text-gray-800" />
                </a>
            </div>

            <div class="mt-8 flex flex-col space-y-2 px-4">
                <x-nav-link class="flex items-center px-4 py-2 rounded hover:bg-blue-100 hover:text-blue-700 transition"
                    :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')">
                    <span class="material-icons mr-3">dashboard</span>
                    {{ __('Dashboard') }}
                </x-nav-link>

                <!-- Registration Forms Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center w-full px-4 py-2 rounded hover:bg-blue-100 hover:text-blue-700 transition text-left focus:outline-none"
                            :class="{ 'bg-blue-100 text-blue-700': open }">
                        <span class="material-icons mr-3">assignment</span>
                        <span class="flex-1">{{ __('Registration Forms') }}</span>
                        <span class="material-icons text-sm transform transition-transform duration-200" 
                              :class="{ 'rotate-180': open }">expand_more</span>
                    </button>
                    
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         @click.away="open = false"
                         class="absolute left-0 top-full w-full bg-white border border-gray-200 rounded-lg shadow-lg z-50 mt-1 overflow-hidden">
                        
                        <a href="{{ route('student.enrollment.shs.create') }}" 
                           class="flex items-center px-4 py-3 hover:bg-blue-50 hover:text-blue-700 transition text-sm border-b border-gray-100 {{ request()->routeIs('student.enrollment.shs.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                            <span class="text-blue-600 mr-3 text-lg">🎓</span>
                            <div>
                                <div class="font-medium">{{ __('Senior High School') }}</div>
                                <div class="text-xs text-gray-500">Grade 11 & 12 Registration</div>
                            </div>
                        </a>
                        
                        <a href="{{ route('student.enrollment.jhs.create') }}" 
                           class="flex items-center px-4 py-3 hover:bg-green-50 hover:text-green-700 transition text-sm {{ request()->routeIs('student.enrollment.jhs.*') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                            <span class="text-green-600 mr-3 text-lg">📚</span>
                            <div>
                                <div class="font-medium">{{ __('Junior High School') }}</div>
                                <div class="text-xs text-gray-500">Grade 7, 8, 9 & 10 Registration</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6 px-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-nav-link class="flex items-center px-4 py-2 rounded text-red-600 hover:bg-red-100 hover:text-red-800 transition"
                    :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <span class="material-icons mr-3">logout</span>
                    {{ __('Log Out') }}
                </x-nav-link>
            </form>
        </div>
    </nav>

    <div class="flex-1 p-8 overflow-auto">
        @yield('content')
    </div>
</div>
