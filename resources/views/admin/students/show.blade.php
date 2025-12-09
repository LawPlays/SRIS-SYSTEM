@extends('layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="bg-gray-900 text-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold mb-4">Student Details</h2>

    {{-- Basic info ng student --}}
    <div class="bg-gray-800 p-4 rounded">
        <p><strong>Name:</strong> {{ $student->name }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <p><strong>Status:</strong> {{ ucfirst($student->status) }}</p>
    </div>

    {{-- Enrollment info --}}
    @if ($student->enrollment)
    <div class="bg-gray-800 p-4 rounded mt-4">
        <h3 class="text-lg font-semibold mb-2">Registration Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Personal Information -->
            <div class="md:col-span-2">
                <h4 class="text-lg font-semibold text-gray-300 mb-3 border-b border-gray-600 pb-2">Personal Information</h4>
            </div>
            <div>
                <strong>Last Name:</strong> {{ $student->enrollment->last_name ?? 'N/A' }}
            </div>
            <div>
                <strong>First Name:</strong> {{ $student->enrollment->first_name ?? 'N/A' }}
            </div>
            <div>
                <strong>Middle Name:</strong> {{ $student->enrollment->middle_name ?? 'N/A' }}
            </div>
            <div>
                <strong>LRN:</strong> {{ $student->enrollment->lrn ?? 'N/A' }}
            </div>
            <div>
                <strong>Birthdate:</strong> {{ $student->enrollment->birthdate ?? 'N/A' }}
            </div>
            <div>
                <strong>Place of Birth:</strong> {{ $student->enrollment->place_of_birth ?? 'N/A' }}
            </div>
            <div>
                <strong>Sex:</strong> {{ $student->enrollment->sex ?? 'N/A' }}
            </div>
            <div>
                <strong>Age:</strong> {{ $student->enrollment->age ?? 'N/A' }}
            </div>

            <!-- Academic Information -->
            <div class="md:col-span-2 mt-4">
                <h4 class="text-lg font-semibold text-gray-300 mb-3 border-b border-gray-600 pb-2">Academic Information</h4>
            </div>
            <div>
                <strong>School Year:</strong> {{ $student->enrollment->school_year ?? 'N/A' }}
            </div>
            <div>
                <strong>Strand:</strong> {{ $student->enrollment->strand ?? 'N/A' }}
            </div>
            <div>
                <strong>Grade Level:</strong> {{ $student->enrollment->grade_level ?? 'N/A' }}
            </div>

            <!-- Address Information -->
            <div class="md:col-span-2 mt-4">
                <h4 class="text-lg font-semibold text-gray-300 mb-3 border-b border-gray-600 pb-2">Address Information</h4>
            </div>
            <div>
                <strong>Current Address:</strong> {{ $student->enrollment->current_address ?? 'N/A' }}
            </div>
            <div>
                <strong>Permanent Address:</strong> {{ $student->enrollment->permanent_address ?? 'N/A' }}
            </div>

            <!-- Family Information -->
            <div class="md:col-span-2 mt-4">
                <h4 class="text-lg font-semibold text-gray-300 mb-3 border-b border-gray-600 pb-2">Family Information</h4>
            </div>
            <div>
                <strong>Father's Name:</strong> {{ $student->enrollment->father_name ?? 'N/A' }}
            </div>
            <div>
                <strong>Mother's Name:</strong> {{ $student->enrollment->mother_name ?? 'N/A' }}
            </div>
            <div>
                <strong>Guardian's Name:</strong> {{ $student->enrollment->guardian_name ?? 'N/A' }}
            </div>
            <div>
                <strong>Contact Number:</strong> {{ $student->enrollment->contact_number ?? 'N/A' }}
            </div>
            <div>
                <strong>Email:</strong> {{ $student->enrollment->email ?? 'N/A' }}
            </div>

        </div>

        {{-- Uploaded Documents --}}
        <div class="mt-6">
            <h4 class="text-lg font-semibold text-gray-300 mb-3 border-b border-gray-600 pb-2">Uploaded Documents</h4>

            <div class="bg-gray-700 p-4 rounded-lg">
                @if ($student->enrollment->psa_birth_certificate)
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h5 class="text-white font-medium mb-2">PSA Birth Certificate</h5>
                            <p class="text-gray-300 text-sm mb-3">Document has been uploaded and is available for review.</p>
                            
                            {{-- Image Preview Thumbnail --}}
                            @php
                                $fileExtension = pathinfo($student->enrollment->psa_birth_certificate, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp
                            
                            @if($isImage)
                                <div class="mb-4">
                                    <img src="{{ route('files.public', ['path' => $student->enrollment->psa_birth_certificate]) }}" 
                                         alt="PSA Birth Certificate Preview" 
                                         class="w-32 h-32 object-cover rounded-lg border border-gray-600 cursor-pointer hover:opacity-80 transition-opacity"
                                         onclick="openImageModal('{{ route('files.public', ['path' => $student->enrollment->psa_birth_certificate]) }}')">
                                </div>
                            @endif
                            
                            <div class="flex space-x-3">
                                @if($isImage)
                                    <button onclick="openImageModal('{{ route('files.public', ['path' => $student->enrollment->psa_birth_certificate]) }}')"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Image
                                    </button>
                                @else
                                    <a href="{{ route('files.public', ['path' => $student->enrollment->psa_birth_certificate]) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Document
                                    </a>
                                @endif
                                <a href="{{ route('files.public', ['path' => $student->enrollment->psa_birth_certificate]) }}" 
                                   download 
                                   class="inline-flex items-center px-3 py-2 border border-gray-500 text-sm leading-4 font-medium rounded-md text-gray-300 bg-transparent hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Uploaded
                            </span>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gray-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h5 class="text-white font-medium mb-1">PSA Birth Certificate</h5>
                            <p class="text-gray-400 text-sm">No document uploaded</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Missing
                            </span>
                        </div>
                    </div>
                @endif

                {{-- Form 137 Document --}}
                <div class="mt-6">
                    @if ($student->enrollment->form137)
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h5 class="text-white font-medium mb-2">Form 137 (Report Card)</h5>
                                <p class="text-gray-300 text-sm mb-3">Document has been uploaded and is available for review.</p>
                                
                                {{-- Image Preview Thumbnail --}}
                                @php
                                    $form137Extension = pathinfo($student->enrollment->form137, PATHINFO_EXTENSION);
                                    $isForm137Image = in_array(strtolower($form137Extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                
                                @if($isForm137Image)
                                    <div class="mb-4">
                                        <img src="{{ route('files.public', ['path' => $student->enrollment->form137]) }}" 
                                             alt="Form 137 Preview" 
                                             class="w-32 h-32 object-cover rounded-lg border border-gray-600 cursor-pointer hover:opacity-80 transition-opacity"
                                             onclick="openImageModal('{{ route('files.public', ['path' => $student->enrollment->form137]) }}')">
                                    </div>
                                @endif
                                
                                <div class="flex space-x-3">
                                    @if($isForm137Image)
                                        <button onclick="openImageModal('{{ route('files.public', ['path' => $student->enrollment->form137]) }}')"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Image
                                        </button>
                                    @else
                                        <a href="{{ route('files.public', ['path' => $student->enrollment->form137]) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Document
                                        </a>
                                    @endif
                                    <a href="{{ route('files.public', ['path' => $student->enrollment->form137]) }}" 
                                       download 
                                       class="inline-flex items-center px-3 py-2 border border-gray-500 text-sm leading-4 font-medium rounded-md text-gray-300 bg-transparent hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Uploaded
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gray-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h5 class="text-white font-medium mb-1">Form 137 (Report Card)</h5>
                                <p class="text-gray-400 text-sm">No document uploaded</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Missing
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Action buttons --}}
    <div class="mt-6 flex space-x-3">
        <form action="{{ route('admin.students.approve', $student->id) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded">Approve</button>
        </form>

        <button type="button" onclick="openRejectModal()" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">Reject</button>

        <a href="{{ route('admin.students.index') }}" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded">Back</a>
    </div>

    {{-- Rejection Modal --}}
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Reject Student Enrollment</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="rejectForm" method="POST" action="{{ route('admin.students.reject', $student->id) }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <p class="text-gray-700 mb-2">Are you sure you want to reject the enrollment for <strong>{{ $student->name }}</strong>?</p>
                    <label for="rejectionReason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for Rejection <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="rejectionReason"
                        name="rejection_reason"
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900"
                        placeholder="Please provide a clear reason for rejecting this enrollment..."
                        required
                    ></textarea>
                    <p class="text-sm text-gray-500 mt-1">This reason will be sent to the student via email.</p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 rounded bg-gray-200 text-gray-800 hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Reject Student</button>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
    <script>
        function openRejectModal() {
            const modal = document.getElementById('rejectModal');
            if (modal) modal.classList.remove('hidden');
            const reason = document.getElementById('rejectionReason');
            if (reason) { reason.value = ''; setTimeout(() => reason.focus(), 100); }
        }
        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            if (modal) modal.classList.add('hidden');
            const reason = document.getElementById('rejectionReason');
            if (reason) reason.value = '';
        }
    </script>
    @endsection
</div>
@endsection
