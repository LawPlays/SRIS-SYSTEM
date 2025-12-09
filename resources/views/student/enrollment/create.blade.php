@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8 px-4">
    <div class="max-w-5xl mx-auto">
        
        {{-- Modern Header --}}
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 mb-8 overflow-hidden">
            <div class="px-8 py-10 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 relative">
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white bg-opacity-10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white bg-opacity-5 rounded-full translate-y-12 -translate-x-12"></div>
                
                <div class="flex items-center space-x-6 relative z-10">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white border-opacity-30">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">Student Enrollment Application</h1>
                        <p class="text-blue-100 text-lg font-medium">Complete your registration to join our academic community</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 rounded-lg p-6 mb-8 shadow-md">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-red-800">Please correct the following errors:</h3>
                </div>
                <ul class="text-base text-red-700 space-y-2">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('student.enrollment.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- School Information --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-300 hover:scale-[1.01]">
                <div class="px-8 py-6 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-t-2xl">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        School Information
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="school_year" class="block text-base font-semibold text-gray-800 mb-3">School Year *</label>
                        <input type="text" name="school_year" id="school_year" value="{{ old('school_year') }}" required 
                               placeholder="e.g., 2024-2025" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200 hover:border-gray-400">
                        <p class="text-sm text-gray-600 mt-2">Enter the school year (e.g., 2024-2025)</p>
                    </div>
                    <div>
                        <label for="grade_level" class="block text-base font-semibold text-gray-800 mb-3">Grade Level *</label>
                        <select name="grade_level" id="grade_level" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                            <option value="">Select Grade Level</option>
                            <option value="Grade 7" {{ old('grade_level') == 'Grade 7' ? 'selected' : '' }}>Grade 7</option>
                            <option value="Grade 8" {{ old('grade_level') == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                            <option value="Grade 9" {{ old('grade_level') == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                            <option value="Grade 10" {{ old('grade_level') == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                            <option value="Grade 11" {{ old('grade_level') == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                            <option value="Grade 12" {{ old('grade_level') == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Student Information --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-300 hover:scale-[1.01]">
                <div class="px-8 py-6 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-t-2xl">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Student Information
                    </h2>
                </div>
                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label for="last_name" class="block text-base font-semibold text-gray-800 mb-3">Last Name *</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                        </div>
                        <div>
                            <label for="first_name" class="block text-base font-semibold text-gray-800 mb-3">First Name *</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                        </div>
                        <div>
                            <label for="middle_name" class="block text-base font-semibold text-gray-800 mb-3">Middle Name</label>
                            <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label for="sex" class="block text-base font-semibold text-gray-800 mb-3">Sex *</label>
                            <select name="sex" id="sex" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                                <option value="">Select Sex</option>
                                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div>
                            <label for="age" class="block text-base font-semibold text-gray-800 mb-3">Age *</label>
                            <input type="number" name="age" id="age" value="{{ old('age') }}" required min="1" max="100" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                        </div>
                        <div>
                            <label for="birthdate" class="block text-base font-semibold text-gray-800 mb-3">Birthdate *</label>
                            <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label for="place_of_birth" class="block text-base font-semibold text-gray-800 mb-3">Place of Birth *</label>
                            <input type="text" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                        </div>
                        <div>
                            <label for="lrn" class="block text-base font-semibold text-gray-800 mb-3">LRN (Learner Reference Number) *</label>
                            <input type="text" name="lrn" id="lrn" value="{{ old('lrn') }}" required maxlength="12" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                        </div>
                        <div>
                            <label for="strand" id="strand-label" class="block text-base font-semibold text-gray-800 mb-3">Strand *</label>
                            <select name="strand" id="strand" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                                <option value="" id="strand-placeholder">Select Strand</option>
                                <!-- Senior High School Strands (Grades 11-12) -->
                                <option value="STEM" {{ old('strand') == 'STEM' ? 'selected' : '' }} class="shs-option">STEM (Science, Technology, Engineering, Mathematics)</option>
                                <option value="ABM" {{ old('strand') == 'ABM' ? 'selected' : '' }} class="shs-option">ABM (Accountancy, Business, Management)</option>
                                <option value="HUMSS" {{ old('strand') == 'HUMSS' ? 'selected' : '' }} class="shs-option">HUMSS (Humanities and Social Sciences)</option>
                                <option value="GAS" {{ old('strand') == 'GAS' ? 'selected' : '' }} class="shs-option">GAS (General Academic Strand)</option>
                                <option value="TVL-ICT" {{ old('strand') == 'TVL-ICT' ? 'selected' : '' }} class="shs-option">TVL - ICT (Information and Communications Technology)</option>
                                <option value="TVL-HE" {{ old('strand') == 'TVL-HE' ? 'selected' : '' }} class="shs-option">TVL - HE (Home Economics)</option>
                                <option value="TVL-IA" {{ old('strand') == 'TVL-IA' ? 'selected' : '' }} class="shs-option">TVL - IA (Industrial Arts)</option>
                                <option value="ARTS" {{ old('strand') == 'ARTS' ? 'selected' : '' }} class="shs-option">ARTS and Design</option>
                                <option value="SPORTS" {{ old('strand') == 'SPORTS' ? 'selected' : '' }} class="shs-option">Sports Track</option>
                                <!-- Junior High School Curriculum (Grades 7-10) -->
                                <option value="Regular" {{ old('strand') == 'Regular' ? 'selected' : '' }} class="jhs-option" style="display: none;">Regular</option>
                                <option value="SPA" {{ old('strand') == 'SPA' ? 'selected' : '' }} class="jhs-option" style="display: none;">SPA (Special Program in the Arts)</option>
                                <option value="STE" {{ old('strand') == 'STE' ? 'selected' : '' }} class="jhs-option" style="display: none;">STE (Science, Technology, Engineering)</option>
                            </select>
                        </div>
                    </div>
                    <!-- SPA Major Field (only shows when SPA is selected for grades 7-10) -->
                    <div id="spa-major-container" class="grid grid-cols-1 md:grid-cols-3 gap-8" style="display: none;">
                        <div>
                            <label for="spa_major" class="block text-base font-semibold text-gray-800 mb-3">SPA Major *</label>
                            <select name="spa_major" id="spa_major" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                                <option value="">Select SPA Major</option>
                                <option value="Theater Arts" {{ old('spa_major') == 'Theater Arts' ? 'selected' : '' }}>Theater Arts</option>
                                <option value="Media Arts" {{ old('spa_major') == 'Media Arts' ? 'selected' : '' }}>Media Arts</option>
                                <option value="Visual Arts" {{ old('spa_major') == 'Visual Arts' ? 'selected' : '' }}>Visual Arts</option>
                                <option value="Dance" {{ old('spa_major') == 'Dance' ? 'selected' : '' }}>Dance</option>
                                <option value="Music" {{ old('spa_major') == 'Music' ? 'selected' : '' }}>Music</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Address Information --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Address Information
                    </h2>
                </div>
                <div class="p-8 space-y-8">
                    <div>
                        <label for="current_address" class="block text-base font-semibold text-gray-800 mb-3">Current Address *</label>
                        <textarea name="current_address" id="current_address" rows="4" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">{{ old('current_address') }}</textarea>
                    </div>
                    <div>
                        <label for="permanent_address" class="block text-base font-semibold text-gray-800 mb-3">Permanent Address *</label>
                        <textarea name="permanent_address" id="permanent_address" rows="4" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">{{ old('permanent_address') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Parent/Guardian Information --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Parent/Guardian Information
                    </h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="father_name" class="block text-base font-semibold text-gray-800 mb-3">Father's Name</label>
                        <input type="text" name="father_name" id="father_name" value="{{ old('father_name') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                    </div>
                    <div>
                        <label for="mother_name" class="block text-base font-semibold text-gray-800 mb-3">Mother's Name</label>
                        <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                    </div>
                    <div>
                        <label for="guardian_name" class="block text-base font-semibold text-gray-800 mb-3">Guardian's Name</label>
                        <input type="text" name="guardian_name" id="guardian_name" value="{{ old('guardian_name') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                    </div>
                    <div>
                        <label for="contact_number" class="block text-base font-semibold text-gray-800 mb-3">Contact Number *</label>
                        <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800 font-medium transition-all duration-200">
                    </div>
                </div>
            </div>

            {{-- Document Requirements --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Document Requirements
                    </h2>
                </div>
                <div class="p-8 space-y-8">
                    {{-- Form 137 Upload --}}
                    <div>
                        <label for="form_137" class="block text-base font-semibold text-gray-800 mb-4">Form 137 (Report Card) *</label>
                        <div class="mt-1 flex justify-center px-8 pt-8 pb-8 border-3 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition-colors bg-gray-50 hover:bg-blue-50">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-16 w-16 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-base text-gray-600">
                                    <label for="form_137" class="relative cursor-pointer bg-white rounded-lg font-bold text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-3 py-1">
                                        <span>Upload Form 137</span>
                                        <input id="form_137" name="form_137" type="file" class="sr-only" accept="image/*,.pdf" required>
                                    </label>
                                    <p class="pl-1 font-medium">or drag and drop</p>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">PNG, JPG, PDF up to 10MB</p>
                            </div>
                        </div>
                        <div id="form-137-preview" class="mt-6 hidden">
                            <div class="flex items-center p-4 bg-green-50 rounded-lg border-2 border-green-200">
                                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span id="form-137-name" class="text-base text-gray-700 font-medium"></span>
                                <span class="ml-2 text-sm text-green-600 font-semibold">✓ Uploaded</span>
                                <button type="button" id="remove-form-137" class="ml-auto text-red-500 hover:text-red-700 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- PSA Birth Certificate Upload --}}
                    <div>
                        <label for="psa_birth_certificate" class="block text-base font-semibold text-gray-800 mb-4">PSA Birth Certificate *</label>
                        <div class="mt-1 flex justify-center px-8 pt-8 pb-8 border-3 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition-colors bg-gray-50 hover:bg-blue-50">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-16 w-16 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-base text-gray-600">
                                    <label for="psa_birth_certificate" class="relative cursor-pointer bg-white rounded-lg font-bold text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-3 py-1">
                                        <span>Upload PSA Birth Certificate</span>
                                        <input id="psa_birth_certificate" name="psa_birth_certificate" type="file" class="sr-only" accept="image/*,.pdf" required>
                                    </label>
                                    <p class="pl-1 font-medium">or drag and drop</p>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">PNG, JPG, PDF up to 10MB</p>
                            </div>
                        </div>
                        <div id="psa-preview" class="mt-6 hidden">
                            <div class="flex items-center p-4 bg-green-50 rounded-lg border-2 border-green-200">
                                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span id="psa-name" class="text-base text-gray-700 font-medium"></span>
                                <span class="ml-2 text-sm text-green-600 font-semibold">✓ Uploaded</span>
                                <button type="button" id="remove-psa" class="ml-auto text-red-500 hover:text-red-700 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-6 sm:space-y-0">
                    <div class="text-base text-gray-700">
                        <p class="font-medium">By submitting this form, you confirm that all information provided is accurate and complete.</p>
                    </div>
                    <button type="submit" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl shadow-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Submit Application
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form 137 file upload handling
    const form137Input = document.getElementById('form_137');
    const form137Preview = document.getElementById('form137-preview');
    const form137FileName = document.getElementById('form137-file-name');
    const removeForm137Btn = document.getElementById('remove-form137');

    form137Input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('File size must be less than 10MB');
                form137Input.value = '';
                return;
            }

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please upload a valid image (JPG, PNG) or PDF file');
                form137Input.value = '';
                return;
            }

            form137FileName.textContent = file.name;
            form137Preview.classList.remove('hidden');
        }
    });

    removeForm137Btn.addEventListener('click', function() {
        form137Input.value = '';
        form137Preview.classList.add('hidden');
    });

    // PSA Birth Certificate file upload handling
    const psaInput = document.getElementById('psa_birth_certificate');
    const psaPreview = document.getElementById('psa-preview');
    const psaFileName = document.getElementById('psa-file-name');
    const removePsaBtn = document.getElementById('remove-psa');

    psaInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('File size must be less than 10MB');
                psaInput.value = '';
                return;
            }

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please upload a valid image (JPG, PNG) or PDF file');
                psaInput.value = '';
                return;
            }

            psaFileName.textContent = file.name;
            psaPreview.classList.remove('hidden');
        }
    });

    removePsaBtn.addEventListener('click', function() {
        psaInput.value = '';
        psaPreview.classList.add('hidden');
    });

    // Dynamic form functionality for grade level and strand/curriculum
    const gradeLevelSelect = document.getElementById('grade_level');
    const strandSelect = document.getElementById('strand');
    const strandLabel = document.getElementById('strand-label');
    const strandPlaceholder = document.getElementById('strand-placeholder');
    const spaMajorContainer = document.getElementById('spa-major-container');
    const spaMajorSelect = document.getElementById('spa_major');

    function updateStrandOptions() {
        const selectedGrade = gradeLevelSelect.value;
        const jhsGrades = ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'];
        const shsGrades = ['Grade 11', 'Grade 12'];
        
        // Get all options
        const jhsOptions = strandSelect.querySelectorAll('.jhs-option');
        const shsOptions = strandSelect.querySelectorAll('.shs-option');
        
        // Reset selection
        strandSelect.value = '';
        spaMajorContainer.style.display = 'none';
        spaMajorSelect.removeAttribute('required');
        
        if (jhsGrades.includes(selectedGrade)) {
            // Change label and placeholder to Curriculum for JHS
            strandLabel.textContent = 'Curriculum *';
            strandPlaceholder.textContent = 'Select Curriculum';
            
            // Show JHS options, hide SHS options
            jhsOptions.forEach(option => option.style.display = 'block');
            shsOptions.forEach(option => option.style.display = 'none');
            
        } else if (shsGrades.includes(selectedGrade)) {
            // Change label and placeholder to Strand for SHS
            strandLabel.textContent = 'Strand *';
            strandPlaceholder.textContent = 'Select Strand';
            
            // Show SHS options, hide JHS options
            shsOptions.forEach(option => option.style.display = 'block');
            jhsOptions.forEach(option => option.style.display = 'none');
            
        } else {
            // No grade selected, show default label and hide all specific options
            strandLabel.textContent = 'Strand *';
            strandPlaceholder.textContent = 'Select Strand';
            jhsOptions.forEach(option => option.style.display = 'none');
            shsOptions.forEach(option => option.style.display = 'block');
        }
    }

    function updateSpaMajor() {
        const selectedStrand = strandSelect.value;
        const selectedGrade = gradeLevelSelect.value;
        const jhsGrades = ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'];
        
        if (jhsGrades.includes(selectedGrade) && selectedStrand === 'SPA') {
            spaMajorContainer.style.display = 'block';
            spaMajorSelect.setAttribute('required', 'required');
        } else {
            spaMajorContainer.style.display = 'none';
            spaMajorSelect.removeAttribute('required');
            spaMajorSelect.value = '';
        }
    }

    // Event listeners
    gradeLevelSelect.addEventListener('change', function() {
        updateStrandOptions();
        updateSpaMajor();
    });

    strandSelect.addEventListener('change', function() {
        updateSpaMajor();
    });

    // Initialize on page load
    updateStrandOptions();
    updateSpaMajor();
});
</script>
@endsection
