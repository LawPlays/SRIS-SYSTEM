@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white">My Profile</h1>
        <p class="text-sm text-blue-200">Update your account information</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow p-6 text-gray-800">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 text-green-700 border border-green-200 px-4 py-3" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('student.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus
                       class="mt-1 block w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 focus:ring-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email"
                       class="mt-1 block w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 focus:ring-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input id="password" type="password" name="password" autocomplete="new-password"
                           class="mt-1 block w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 focus:ring-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Leave blank to keep your current password.</p>
                </div>
                
                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" autocomplete="new-password"
                           class="mt-1 block w-full rounded-md border border-gray-300 bg-white text-gray-900 px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
@endsection