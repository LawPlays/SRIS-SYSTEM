@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-xl border border-gray-700/50 p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-white mb-2">Edit Student</h1>
            <p class="text-gray-300">Update student information</p>
        </div>

        <form method="POST" action="{{ route('admin.students.update', $student) }}" class="space-y-6">
            @csrf 
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ $student->name }}" 
                           required 
                           class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ $student->email }}" 
                           required 
                           class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select id="status" 
                        name="status" 
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    <option value="Pending" @if($student->status == 'Pending') selected @endif>Pending</option>
                    <option value="Approved" @if($student->status == 'Approved') selected @endif>Approved</option>
                </select>
            </div>

            <div class="flex justify-end space-x-4 pt-6">
                <a href="{{ route('admin.students.index') }}" 
                   class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    Update Student
                </button>
            </div>
        </form>
    </div>
</div>
@endsection