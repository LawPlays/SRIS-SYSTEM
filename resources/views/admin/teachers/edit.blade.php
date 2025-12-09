@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white">Edit Teacher Account</h1>
        <a href="{{ route('admin.teachers.index') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            Return to Teachers
        </a>
    </div>

    <div class="bg-white/10 backdrop-blur-md rounded-xl shadow-lg p-8">
        <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-white text-sm font-bold mb-2">
                    Full Name <span class="text-red-400">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $teacher->name) }}"
                       class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white/30 transition duration-200"
                       placeholder="Enter teacher's full name"
                       required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block text-white text-sm font-bold mb-2">
                    Email Address <span class="text-red-400">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $teacher->email) }}"
                       class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white/30 transition duration-200"
                       placeholder="Enter teacher's email address"
                       required>
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="status" class="block text-white text-sm font-bold mb-2">
                    Account Status <span class="text-red-400">*</span>
                </label>
                <select id="status" 
                        name="status"
                        class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white focus:outline-none focus:border-blue-400 focus:bg-white/30 transition duration-200"
                        required>
                    <option value="approved" {{ old('status', $teacher->status) == 'approved' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ old('status', $teacher->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
                @error('status')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-white text-sm font-bold mb-2">
                    New Password <span class="text-gray-400">(Leave blank to keep current password)</span>
                </label>
                <input type="password" 
                       id="password" 
                       name="password"
                       class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white/30 transition duration-200"
                       placeholder="Enter new password (optional)">
                @error('password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-white text-sm font-bold mb-2">
                    Confirm New Password
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation"
                       class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white/30 transition duration-200"
                       placeholder="Confirm new password">
                @error('password_confirmation')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.teachers.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                    <i class="material-icons inline-block mr-2">save</i>
                    Update Teacher Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection