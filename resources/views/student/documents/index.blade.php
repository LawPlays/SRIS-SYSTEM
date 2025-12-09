<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">My Documents</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <!-- Enrollment Details (Full Form, Always Visible) -->
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-blue-100 mb-6">
                <div class="flex items-center justify-between p-4 border-b border-blue-100">
                    <div class="flex items-center">
                        <span class="material-icons text-blue-600 mr-2">assignment</span>
                        <h3 class="text-lg font-semibold text-gray-900">Enrollment Details</h3>
                    </div>
                    @if(isset($enrollment) && $enrollment && $enrollment->status)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $enrollment->status === 'approved' ? 'bg-green-100 text-green-700' : ($enrollment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    @endif
                </div>

                <div class="px-6 py-6 text-gray-800">
                    @if(isset($enrollment) && $enrollment)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Personal Information</h4>
                                <div class="space-y-1 text-sm text-gray-800">
                                    <p><span class="font-semibold">Name:</span> {{ $enrollment->first_name }} {{ $enrollment->middle_name }} {{ $enrollment->last_name }}</p>
                                    <p><span class="font-semibold">LRN:</span> {{ $enrollment->lrn ?? 'N/A' }}</p>
                                    <p><span class="font-semibold">Age:</span> {{ $enrollment->age ?? 'N/A' }}</p>
                                    <p><span class="font-semibold">Sex:</span> {{ $enrollment->sex }}</p>
                                    <p><span class="font-semibold">Birthdate:</span> {{ $enrollment->birthdate ?? 'N/A' }}</p>
                                    <p><span class="font-semibold">Place of Birth:</span> {{ $enrollment->place_of_birth }}</p>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Academic Information</h4>
                                <div class="space-y-1 text-sm text-gray-800">
                                    <p><span class="font-semibold">School Year:</span> {{ $enrollment->school_year ?? 'N/A' }}</p>
                                    <p><span class="font-semibold">Grade Level:</span> {{ $enrollment->grade_level ?? 'N/A' }}</p>
                                    <p><span class="font-semibold">Strand:</span> {{ $enrollment->strand ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Address</h4>
                                <div class="space-y-1 text-sm text-gray-800">
                                    <p><span class="font-semibold">Current Address:</span> {{ $enrollment->current_address }}</p>
                                    <p><span class="font-semibold">Permanent Address:</span> {{ $enrollment->permanent_address }}</p>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Family</h4>
                                <div class="space-y-1 text-sm text-gray-800">
                                    <p><span class="font-semibold">Father's Name:</span> {{ $enrollment->father_name ?? 'N/A' }}</p>
                                    <p><span class="font-semibold">Mother's Name:</span> {{ $enrollment->mother_name ?? 'N/A' }}</p>
                                    <p><span class="font-semibold">Guardian's Name:</span> {{ $enrollment->guardian_name ?? 'N/A' }}</p>
                                    <p><span class="font-semibold">Contact Number:</span> {{ $enrollment->contact_number }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Attachments (if provided in the form) -->
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">PSA Birth Certificate</h4>
                                @if(!empty($enrollment->psa_birth_certificate))
                                    <div class="flex items-center space-x-3 text-sm">
                                        <a href="{{ route('files.public', ['path' => $enrollment->psa_birth_certificate]) }}" target="_blank" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-3 py-1 rounded">View</a>
                                        <a href="{{ route('files.public', ['path' => $enrollment->psa_birth_certificate]) }}" target="_blank" download class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-3 py-1 rounded">Download</a>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No file uploaded.</p>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Form 137 (Report Card)</h4>
                                @if(!empty($enrollment->form137))
                                    <div class="flex items-center space-x-3 text-sm">
                                        <a href="{{ route('files.public', ['path' => $enrollment->form137]) }}" target="_blank" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-3 py-1 rounded">View</a>
                                        <a href="{{ route('files.public', ['path' => $enrollment->form137]) }}" target="_blank" download class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-3 py-1 rounded">Download</a>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No file uploaded.</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <p class="text-gray-700">You have not submitted an enrollment yet.</p>
                            <a href="{{ route('student.enrollment.create') }}" class="mt-3 inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded">Start Enrollment</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Removed: Additional Documents list. Requirement is to show the filled-out form. -->
        </div>
    </div>

    <!-- Upload Modal removed as per requirement -->
</x-app-layout>