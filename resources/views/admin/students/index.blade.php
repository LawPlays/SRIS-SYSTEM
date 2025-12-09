@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-gray-900 relative overflow-hidden p-8">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.1),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(147,51,234,0.08),transparent_40%)]"></div>
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10 mix-blend-overlay"></div>

    <div class="relative z-10 flex justify-between items-center mb-6">
        <h2 class="text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent tracking-wide">Students Management</h2>
    </div>

    {{-- Filters removed per request --}}

    {{-- Status Summary --}}
    <div class="relative z-10 grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-900/40 border border-blue-800/50 p-4 rounded-2xl text-center">
            <div class="text-blue-200 text-sm">Total Students</div>
            <div class="text-xl font-bold text-cyan-300">{{ $total }}</div>
        </div>
        <div class="bg-blue-900/40 border border-blue-800/50 p-4 rounded-2xl text-center">
            <div class="text-blue-200 text-sm">Pending</div>
            <div class="text-xl font-bold text-yellow-300">{{ $pending }}</div>
        </div>
        <div class="bg-blue-900/40 border border-blue-800/50 p-4 rounded-2xl text-center">
            <div class="text-blue-200 text-sm">Approved</div>
            <div class="text-xl font-bold text-green-300">{{ $approved }}</div>
        </div>
        <div class="bg-blue-900/40 border border-blue-800/50 p-4 rounded-2xl text-center">
            <div class="text-blue-200 text-sm">Rejected</div>
            <div class="text-xl font-bold text-red-300">{{ $rejected }}</div>
        </div>
    </div>

    {{-- Table --}}
    <table class="relative z-10 min-w-full bg-blue-900/40 border border-blue-800/50 rounded-2xl overflow-hidden backdrop-blur-xl">
        <thead class="bg-blue-950/40 text-blue-200">
            <tr>
                <th class="px-4 py-3 text-left">Name</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Date/Time</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-blue-800/40">
            @forelse ($students as $student)
                <tr class="hover:bg-blue-950/30">
                    <td class="px-4 py-2">{{ $student->name }}</td>
                    <td class="px-4 py-2">{{ $student->email }}</td>
                    <td class="px-4 py-2 capitalize">
                        @if ($student->status === 'pending')
                            <span class="inline-block px-2 py-1 rounded bg-yellow-700/60 text-yellow-200 font-semibold">Pending</span>
                        @elseif ($student->status === 'approved')
                            <span class="inline-block px-2 py-1 rounded bg-green-700/60 text-green-200 font-semibold">Approved</span>
                        @elseif ($student->status === 'rejected')
                            <div>
                                <span class="inline-block px-2 py-1 rounded bg-red-700/60 text-red-200 font-semibold">Rejected</span>
                                @if($student->enrollment && $student->enrollment->rejection_reason)
                                    <div class="text-xs text-blue-200 mt-1">
                                        Reason: {{ Str::limit($student->enrollment->rejection_reason, 30) }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-sm">
                        @if ($student->status === 'pending')
                            <span class="text-blue-200">{{ $student->created_at->timezone(config('app.timezone'))->format('M d, Y') }}</span>
                            <div class="text-xs text-blue-300">{{ $student->created_at->timezone(config('app.timezone'))->format('h:i A') }}</div>
                        @elseif ($student->status === 'approved')
                            @if($student->enrollment && $student->enrollment->updated_at)
                                <span class="text-green-300">{{ $student->enrollment->updated_at->timezone(config('app.timezone'))->format('M d, Y') }}</span>
                                <div class="text-xs text-blue-300">{{ $student->enrollment->updated_at->timezone(config('app.timezone'))->format('h:i A') }}</div>
                            @else
                                <span class="text-green-300">{{ $student->updated_at->timezone(config('app.timezone'))->format('M d, Y') }}</span>
                                <div class="text-xs text-blue-300">{{ $student->updated_at->timezone(config('app.timezone'))->format('h:i A') }}</div>
                            @endif
                        @elseif ($student->status === 'rejected')
                            @if($student->enrollment && $student->enrollment->rejected_at)
                                <span class="text-red-300">{{ $student->enrollment->rejected_at->timezone(config('app.timezone'))->format('M d, Y') }}</span>
                                <div class="text-xs text-blue-300">{{ $student->enrollment->rejected_at->timezone(config('app.timezone'))->format('h:i A') }}</div>
                            @elseif($student->enrollment && $student->enrollment->updated_at)
                                <span class="text-red-300">{{ $student->enrollment->updated_at->timezone(config('app.timezone'))->format('M d, Y') }}</span>
                                <div class="text-xs text-blue-300">{{ $student->enrollment->updated_at->timezone(config('app.timezone'))->format('h:i A') }}</div>
                            @else
                                <span class="text-red-300">{{ $student->updated_at->timezone(config('app.timezone'))->format('M d, Y') }}</span>
                                <div class="text-xs text-blue-300">{{ $student->updated_at->timezone(config('app.timezone'))->format('h:i A') }}</div>
                            @endif
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        @if ($student->status === 'pending')
                            <a href="{{ route('admin.students.show', $student->id) }}" 
                            class="btn btn-blue btn-sm">
                                View
                            </a>
                            <a href="{{ route('admin.students.documents', $student->id) }}" 
                            class="btn btn-gray btn-sm">
                                Documents
                            </a>

                            <form action="{{ route('admin.students.approve', $student->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-green btn-sm">Approve</button>
                            </form>

                            <button type="button" onclick="console.log('Reject button clicked'); openRejectModal({{ $student->id }}, {{ json_encode($student->name) }})" 
                                class="btn btn-red btn-sm">Reject</button>
                        @elseif ($student->status === 'approved')
                            <a href="{{ route('admin.students.show', $student->id) }}" 
                            class="btn btn-blue btn-sm">
                                View
                            </a>
                            <a href="{{ route('admin.students.documents', $student->id) }}" 
                            class="btn btn-gray btn-sm">
                                Documents
                            </a>
                        @elseif ($student->status === 'rejected')
                            <a href="{{ route('admin.students.show', $student->id) }}" 
                            class="btn btn-blue btn-sm">
                                View
                            </a>
                            <a href="{{ route('admin.students.documents', $student->id) }}" 
                            class="btn btn-gray btn-sm">
                                Documents
                            </a>
                            @if($student->enrollment && $student->enrollment->rejection_reason)
                                <button type="button" onclick="showRejectionReason('{{ addslashes($student->enrollment->rejection_reason) }}')" 
                                    class="btn btn-yellow btn-sm">
                                    Reason
                                </button>
                            @endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-gray-400">No students found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
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
        
        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="mb-4">
                <p class="text-gray-700 mb-2">Are you sure you want to reject the enrollment for <strong id="studentName"></strong>?</p>
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
                <button type="button" onclick="closeRejectModal()" 
                    class="btn btn-gray">
                    Cancel
                </button>
                <button type="submit" 
                    class="btn btn-red">
                    Reject Student
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openRejectModal(studentId, studentName) {
    console.log('Opening reject modal for student:', studentName);
    
    // Get modal element
    const modal = document.getElementById('rejectModal');
    if (!modal) {
        console.error('Modal element not found!');
        return;
    }
    
    // Show modal - simply remove hidden class (flex is already in the class)
    modal.classList.remove('hidden');
    
    // Set student name
    const studentNameElement = document.getElementById('studentName');
    if (studentNameElement) {
        studentNameElement.textContent = studentName;
    }
    
    // Set form action
    const rejectForm = document.getElementById('rejectForm');
    if (rejectForm) {
        rejectForm.action = `/admin/students/${studentId}/reject`;
    }
    
    // Clear and focus textarea
    const rejectionReason = document.getElementById('rejectionReason');
    if (rejectionReason) {
        rejectionReason.value = '';
        setTimeout(() => {
            rejectionReason.focus();
        }, 100);
    }
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    if (modal) {
        modal.classList.add('hidden');
    }
    const reasonField = document.getElementById('rejectionReason');
    if (reasonField) {
        reasonField.value = '';
    }
}

function showRejectionReason(reason) {
    Swal.fire({
        title: 'Rejection Reason',
        text: reason,
        icon: 'info',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Close'
    });
}

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('rejectModal');
    
    if (modal) {
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    }
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('rejectModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeRejectModal();
            }
        }
    });
});
</script>
@endsection
