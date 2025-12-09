<x-guest-layout>
  <div class="fixed inset-0 flex flex-col lg:flex-row bg-gradient-to-br from-gray-900 via-blue-900 to-gray-800 overflow-hidden">

    <!-- LEFT HERO: logo + message -->
    <div class="w-full lg:w-1/2 flex flex-col items-center lg:items-start justify-center px-8 lg:px-20 py-12 z-10">
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
      <div class="flex items-center gap-4 mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="School Logo" class="h-28 w-auto drop-shadow-[0_0_25px_rgba(59,130,246,0.5)]">
        @if($srisMark)
          <img src="{{ $srisMark }}" alt="SRIS Logo" class="h-28 w-auto drop-shadow-[0_0_25px_rgba(59,130,246,0.5)]">
        @endif
      </div>
      <h1 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-3">
        Welcome to <span class="text-blue-400">SRIS</span>
      </h1>
      <p class="text-gray-300 max-w-md">Create an account to access student features. Clean, responsive, and built for desktop-first view.</p>
    </div>

    <!-- RIGHT FORM -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 lg:px-20 py-12 z-10">
      <div class="w-full max-w-md bg-white/10 backdrop-blur-2xl rounded-2xl shadow-2xl p-8 border border-white/20">
        <div class="text-center mb-6">
          <h2 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">
            Create your account
          </h2>
          <p class="text-sm text-gray-300 mt-1">Fill in the details below to register as a student</p>
        </div>

        <x-auth-session-status class="mb-4 text-center text-green-400" :status="session('status')" />

        <form class="space-y-4" method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

          <div>
            <input id="name" name="name" type="text" required autofocus autocomplete="name"
              class="w-full px-4 py-3 bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg 
                     focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              placeholder="Full Name" value="{{ old('name') }}">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-sm" />
          </div>

          <div>
            <input id="email" name="email" type="email" autocomplete="username" required
              class="w-full px-4 py-3 bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg 
                     focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              placeholder="Email Address" value="{{ old('email') }}">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
          </div>

          <div>
            <input id="password" name="password" type="password" autocomplete="new-password" required
              class="w-full px-4 py-3 bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg 
                     focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              placeholder="Password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />
          </div>

          <div>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
              class="w-full px-4 py-3 bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg 
                     focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              placeholder="Confirm Password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-sm" />
          </div>

          <!-- Email Verification Code Section -->
          <div>
            <div class="flex gap-2">
              <input id="verification_code" name="verification_code" type="text" 
                class="flex-1 px-4 py-3 bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg 
                       focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                placeholder="Enter verification code" maxlength="6">
              <button type="button" id="send-code-btn"
                class="px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 
                       text-white font-semibold rounded-lg shadow-lg hover:shadow-green-800/40 transition duration-300 whitespace-nowrap">
                Send Code
              </button>
            </div>
            <x-input-error :messages="$errors->get('verification_code')" class="mt-2 text-red-400 text-sm" />
          </div>

          <input type="hidden" name="role" value="student">

          <div class="flex items-center justify-between mt-3 text-sm">
            <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 transition">
              Already have an account? Login
            </a>

            <button type="submit" id="register-btn"
              class="py-3 px-6 rounded-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-700 
                     hover:from-blue-700 hover:to-indigo-800 shadow-lg hover:shadow-blue-800/40 transition duration-300">
              Register
            </button>
          </div>
          <div class="mt-4">
            <label class="inline-flex items-center">
              <input id="privacy-consent" name="privacy_consent" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
              <span class="ml-2 text-sm text-gray-300">I agree to the <a href="#" class="underline">Privacy Notice</a> (DPA 2012)</span>
            </label>
            <input type="hidden" name="consent_version" value="v1.0">
            @error('privacy_consent')
              <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </form>
      </div>
    </div>

    <!-- Decorative orbs -->
    <div class="absolute top-16 left-12 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-16 right-12 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
  </div>

  <!-- ✅ SweetAlert2 Script -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Form elements
      const registerForm = document.querySelector('form');
      const nameInput = document.getElementById('name');
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      const passwordConfirmationInput = document.getElementById('password_confirmation');
      const verificationCodeInput = document.getElementById('verification_code');
      const sendCodeBtn = document.getElementById('send-code-btn');

      let countdownTimer;
      let countdownSeconds = 60;

      // Function to refresh CSRF token
      async function refreshCSRFToken() {
        try {
          const response = await fetch('{{ route("register") }}', {
            method: 'GET',
            headers: {
              'Accept': 'text/html'
            }
          });
          const html = await response.text();
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const newToken = doc.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
          
          if (newToken) {
            // Update the meta tag
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
              metaTag.setAttribute('content', newToken);
            }
            return newToken;
          }
        } catch (error) {
          console.error('Failed to refresh CSRF token:', error);
        }
        return null;
      }

      // Send verification code
      sendCodeBtn.addEventListener('click', function() {
        const email = emailInput.value.trim();
        
        if (!email) {
          Swal.fire({
            title: 'Email Required',
            text: 'Please enter your email address first.',
            icon: 'warning',
            confirmButtonColor: '#2563eb'
          });
          emailInput.focus();
          return;
        }

        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
          Swal.fire({
            title: 'Invalid Email',
            text: 'Please enter a valid email address.',
            icon: 'error',
            confirmButtonColor: '#2563eb'
          });
          emailInput.focus();
          return;
        }

        // Disable button and start countdown
        sendCodeBtn.disabled = true;
        sendCodeBtn.textContent = `Sending...`;

        // Send AJAX request
        fetch('{{ route("verification.send-code") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
          },
          body: JSON.stringify({ email: email })
        })
        .then(async response => {
          // Check if response is ok
          if (!response.ok) {
            // Handle different HTTP status codes
            if (response.status === 419) {
              // Try to refresh CSRF token and retry once
              const newToken = await refreshCSRFToken();
              if (newToken) {
                // Retry the request with new token
                return fetch('{{ route("verification.send-code") }}', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': newToken
                  },
                  body: JSON.stringify({ email: email })
                }).then(retryResponse => {
                  if (!retryResponse.ok) {
                    throw new Error('Session expired. Please refresh the page and try again.');
                  }
                  return retryResponse.json();
                });
              } else {
                throw new Error('Session expired. Please refresh the page and try again.');
              }
            } else if (response.status === 422) {
              // Validation error - try to parse JSON
              return response.json().then(data => {
                let errorMessage = data.message || 'Validation failed';
                if (data.errors && data.errors.email) {
                  errorMessage = data.errors.email[0];
                }
                throw new Error(errorMessage);
              });
            } else {
              throw new Error('Server error. Please try again.');
            }
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            Swal.fire({
              title: 'Code Sent!',
              text: 'Verification code has been sent to your email.',
              icon: 'success',
              confirmButtonColor: '#2563eb',
              timer: 2000
            });
            
            // Start countdown
            startCountdown();
          } else {
            throw new Error(data.message || 'Failed to send verification code');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire({
            title: 'Error',
            text: error.message || 'Failed to send verification code. Please try again.',
            icon: 'error',
            confirmButtonColor: '#2563eb'
          });
          
          // Re-enable button
          sendCodeBtn.disabled = false;
          sendCodeBtn.textContent = 'Send Code';
        });
      });

      // Countdown function
      function startCountdown() {
        countdownSeconds = 60;
        sendCodeBtn.textContent = `Resend (${countdownSeconds}s)`;
        
        countdownTimer = setInterval(function() {
          countdownSeconds--;
          sendCodeBtn.textContent = `Resend (${countdownSeconds}s)`;
          
          if (countdownSeconds <= 0) {
            clearInterval(countdownTimer);
            sendCodeBtn.disabled = false;
            sendCodeBtn.textContent = 'Send Code';
          }
        }, 1000);
      }
      
      // Form submission validation
      registerForm.addEventListener('submit', function(e) {
        // Basic validation
        if (!nameInput.value || !emailInput.value || !passwordInput.value || !passwordConfirmationInput.value) {
          e.preventDefault();
          
          Swal.fire({
            title: 'Missing Information',
            text: 'Please fill in all fields.',
            icon: 'warning',
            confirmButtonColor: '#2563eb'
          });
          return false;
        }

        if (passwordInput.value !== passwordConfirmationInput.value) {
          e.preventDefault();
          
          Swal.fire({
            title: 'Password Mismatch',
            text: 'Passwords do not match.',
            icon: 'error',
            confirmButtonColor: '#2563eb'
          });
          return false;
        }

        // Verification code validation
        if (!verificationCodeInput.value || verificationCodeInput.value.length !== 6) {
          e.preventDefault();
          
          Swal.fire({
            title: 'Verification Required',
            text: 'Please enter the 6-digit verification code sent to your email.',
            icon: 'warning',
            confirmButtonColor: '#2563eb'
          });
          verificationCodeInput.focus();
          return false;
        }
      });

      // Require privacy consent checkbox
      const consentCheckbox = document.getElementById('privacy-consent');
      if (consentCheckbox) {
        registerForm.addEventListener('submit', function(e) {
          if (!consentCheckbox.checked) {
            e.preventDefault();
            Swal.fire({
              title: 'Consent Required',
              text: 'You must agree to the Privacy Notice to continue.',
              icon: 'warning',
              confirmButtonColor: '#2563eb'
            });
          }
        });
      }
    });
  </script>

  @if (session('status'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          title: 'Account Created!',
          text: '{{ session('status') }}',
          icon: 'success',
          confirmButtonColor: '#2563eb',
          confirmButtonText: 'Go to Login',
          timer: 3000,
          timerProgressBar: true
        }).then(() => {
          window.location.href = "{{ route('login') }}";
        });
      });
    </script>
  @endif
</x-guest-layout>
