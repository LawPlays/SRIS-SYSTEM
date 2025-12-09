@extends('layouts.teacher')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('teacher.announcements.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg mr-4 transition duration-200">
            <i class="material-icons inline-block mr-2">arrow_back</i>
            Back
        </a>
        <h1 class="text-3xl font-bold text-white">Create Announcement</h1>
    </div>

    <div class="bg-white/10 backdrop-blur-md rounded-xl shadow-lg p-8">
        <form method="POST" action="{{ route('teacher.announcements.store') }}">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-white text-sm font-bold mb-2">
                    Title <span class="text-red-400">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white/30 transition duration-200"
                       placeholder="Enter announcement title"
                       required>
                @error('title')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="content" class="block text-white text-sm font-bold mb-2">
                    Content <span class="text-red-400">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="6"
                          class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white/30 transition duration-200"
                          placeholder="Enter announcement content"
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="priority" class="block text-white text-sm font-bold mb-2">
                    Priority <span class="text-red-400">*</span>
                </label>
                <select id="priority" 
                        name="priority"
                        class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white focus:outline-none focus:border-blue-400 focus:bg-white/30 transition duration-200"
                        required>
                    <option value="1" {{ old('priority') == '1' ? 'selected' : '' }}>Low</option>
                    <option value="2" {{ old('priority') == '2' ? 'selected' : '' }}>Medium</option>
                    <option value="3" {{ old('priority') == '3' ? 'selected' : '' }}>High</option>
                </select>
                @error('priority')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center text-white">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="mr-2 rounded bg-white/20 border-white/30 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm font-bold">Active (visible to students)</span>
                </label>
                @error('is_active')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('teacher.announcements.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                    <i class="material-icons inline-block mr-2">save</i>
                    Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection