<x-guest-layout>
  <div class="fixed inset-0 flex items-center justify-center bg-gradient-to-br from-gray-900 via-blue-900 to-gray-800 overflow-hidden">

    <!-- Background glow orbs -->
    <div class="absolute top-16 left-12 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-16 right-12 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-2xl p-10 rounded-2xl shadow-2xl border border-white/20 mx-6">

      <!-- Logo -->
      <div class="flex justify-center mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-auto drop-shadow-[0_0_25px_rgba(59,130,246,0.4)]">
      </div>

      <!-- Header -->
      <div class="text-center mb-6">
        <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">
          Reset Your Password
        </h2>
        <p class="mt-2 text-sm text-gray-300">
          Forgot your password? Enter your email below and we’ll send you a link to reset it.
        </p>
      </div>

      <x-auth-session-status class="mb-4 text-center text-green-400" :status="session('status')" />

      <!-- Form -->
      <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
          <input id="email" name="email" type="email" autocomplete="email" required autofocus
            class="w-full px-4 py-3 bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg 
                   focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
            placeholder="Email address" value="{{ old('email') }}">
          <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
        </div>

        <div>
          <button type="submit"
            class="w-full py-3 rounded-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-700 
                   hover:from-blue-700 hover:to-indigo-800 shadow-lg hover:shadow-blue-800/40 transition duration-300">
            Send Password Reset Link
          </button>
        </div>

        <p class="mt-4 text-center text-sm text-gray-400">
          Remembered your password?
          <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition">
            Login
          </a>
        </p>
      </form>
    </div>
  </div>
</x-guest-layout>
