<x-guest-layout>
  <div class="fixed inset-0 flex flex-col lg:flex-row justify-between bg-gradient-to-br from-gray-900 via-blue-900 to-gray-800 overflow-hidden">

    <!-- LEFT HERO (logo + intro) -->
    <div class="w-full lg:w-2/5 flex flex-col items-center lg:items-start justify-center px-8 lg:px-20 py-12 z-10">
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
      @if($srisMark)
        <img src="{{ $srisMark }}" alt="School Seal" class="h-28 w-auto drop-shadow-lg mb-4">
      @endif
      <h1 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-3">
        Welcome to <span class="text-blue-300">SRIS</span>
      </h1>
      <p class="text-gray-300 max-w-md">
        Log in or select your portal below to continue.
      </p>
    </div>

    <!-- RIGHT CARD -->
    <div class="w-full lg:w-2/5 flex items-center justify-end px-6 lg:pl-6 lg:pr-28 py-12 z-10">
      <div class="w-full max-w-md bg-white/5 backdrop-blur-xl rounded-2xl shadow-xl p-8 border border-white/15">

        @if (!request()->has('role'))
          <!-- Role selection -->
          <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white tracking-wide">Login as</h2>
            <p class="text-sm text-gray-300 mt-1">Choose your portal</p>
          </div>

          <div class="space-y-5">
            <a href="{{ route('login', ['role' => 'admin']) }}"
              class="group relative block w-full py-4 text-center font-bold rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-blue-700/40 transition duration-300">
              Admin
              <span class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-10 bg-white transition"></span>
            </a>

            <a href="{{ route('login', ['role' => 'teacher']) }}"
              class="group relative block w-full py-4 text-center font-bold rounded-xl text-white bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 shadow-lg hover:shadow-purple-700/40 transition duration-300">
              Teacher
              <span class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-10 bg-white transition"></span>
            </a>

            <a href="{{ route('login', ['role' => 'student']) }}"
              class="group relative block w-full py-4 text-center font-bold rounded-xl text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 shadow-lg hover:shadow-emerald-700/40 transition duration-300">
              Student
              <span class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-10 bg-white transition"></span>
            </a>
          </div>
        @else
          <!-- Login form -->
          <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">
              Sign in as {{ ucfirst(request()->get('role')) }}
            </h2>
            <p class="text-gray-300 text-sm mt-2">Welcome back — let's get you in</p>
          </div>

          <!-- Status Messages -->
          @if (session('status'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-lg">
              <p class="text-green-300 text-sm text-center">{{ session('status') }}</p>
            </div>
          @endif

          <form class="space-y-6" method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="role" value="{{ request()->get('role') }}">

            <div class="space-y-4">
              <input id="email" name="email" type="email" required placeholder="Email address"
                class="w-full px-4 py-3 bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
              <x-input-error :messages="$errors->get('email')" class="text-red-400 text-sm mt-1" />

              <input id="password" name="password" type="password" required placeholder="Password"
                class="w-full px-4 py-3 bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
              <x-input-error :messages="$errors->get('password')" class="text-red-400 text-sm mt-1" />
            </div>

            <div class="flex items-center justify-between text-gray-300 text-sm">
              <label class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox"
                  class="h-4 w-4 text-blue-500 border-gray-600 bg-gray-800 rounded focus:ring-blue-400">
                <span class="ml-2">Remember me</span>
              </label>
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="hover:text-white transition">
                  Forgot password?
                </a>
              @endif
            </div>

            <button type="submit"
              class="w-full py-3 mt-2 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-blue-800/40 transition duration-300">
              Sign In
            </button>
          </form>

          <div class="text-center mt-6 text-sm text-gray-400">
            <a href="{{ route('login') }}" class="hover:text-white transition">← Back to role selection</a>
          </div>

          @if (request()->get('role') === 'student')
            <div class="text-center mt-3 text-sm text-gray-400">
              Don’t have an account?
              <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition">
                Register
              </a>
            </div>
          @endif
        @endif
      </div>
    </div>

    <!-- Decorative background orbs -->
    <div class="absolute top-16 left-12 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-16 right-12 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <!-- School Seal Watermark Background (center, fit to screen) -->
    <div class="pointer-events-none fixed inset-0 z-0"
         style="background-image: url('{{ asset('images/logo.png') }}'); background-repeat: no-repeat; background-position: center center; background-size: min(75vh, 760px); opacity: 0.16;">
    </div>

  </div>
</x-guest-layout>
