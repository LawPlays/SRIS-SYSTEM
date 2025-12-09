<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, please verify your email address by entering the 6-digit verification code we sent to your email.') }}
    </div>

    @if (session('success'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.code.verify') }}">
        @csrf

        <!-- Verification Code -->
        <div>
            <x-input-label for="code" :value="__('Verification Code')" />
            <x-text-input id="code" 
                         class="block mt-1 w-full text-center text-2xl tracking-widest" 
                         type="text" 
                         name="code" 
                         :value="old('code')" 
                         required 
                         autofocus 
                         autocomplete="off"
                         maxlength="6"
                         placeholder="000000" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
            
            <div class="mt-2 text-xs text-gray-500">
                {{ __('Enter the 6-digit code sent to your email address.') }}
            </div>
        </div>

        <div class="flex items-center justify-between mt-4">
            <x-primary-button>
                {{ __('Verify Email') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 mb-2">
            {{ __("Didn't receive the code?") }}
        </p>
        
        <form method="POST" action="{{ route('verification.code.resend') }}" class="inline">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Resend verification code') }}
            </button>
        </form>
    </div>

    <div class="mt-4 text-center">
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>

    <script>
        // Auto-format the verification code input
        document.getElementById('code').addEventListener('input', function(e) {
            // Remove any non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 6 digits
            if (this.value.length > 6) {
                this.value = this.value.slice(0, 6);
            }
        });

        // Auto-submit when 6 digits are entered
        document.getElementById('code').addEventListener('input', function(e) {
            if (this.value.length === 6) {
                // Optional: Auto-submit the form
                // this.form.submit();
            }
        });
    </script>
</x-guest-layout>