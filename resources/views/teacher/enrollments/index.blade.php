@extends('layouts.teacher')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-blue-300">Registration Records</h1>
            <p class="text-sm text-gray-300">Manage and review student enrollment submissions.</p>
        </div>

        <div class="bg-white/95 rounded-xl shadow-lg border border-white/10">
            <div class="p-6 text-gray-900">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border text-left">ID</th>
                                <th class="px-4 py-2 border text-left">Student Name</th>
                                <th class="px-4 py-2 border text-left">Birthdate</th>
                                <th class="px-4 py-2 border text-left">Sex</th>
                                <th class="px-4 py-2 border text-left">Status</th>
                                <th class="px-4 py-2 border text-left">Date Submitted</th>
                                <th class="px-4 py-2 border text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrollments as $enrollment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $enrollment->id }}</td>
                                    <td class="px-4 py-2 border">
                                        {{ ($enrollment->first_name ?? $enrollment->name ?? '') . ' ' . ($enrollment->last_name ?? '') }}
                                    </td>
                                    <td class="px-4 py-2 border">{{ optional($enrollment->birthdate)->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 border">{{ $enrollment->sex }}</td>
                                    <td class="px-4 py-2 border">
                                        <span class="px-2 py-1 rounded text-white {{ ($enrollment->status ?? 'pending') === 'approved' ? 'bg-green-500' : (($enrollment->status ?? 'pending') === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                            {{ ucfirst($enrollment->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 border">{{ $enrollment->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-2 border">
                                        <a href="{{ route('teacher.students.show', $enrollment->user->id) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm">
                                            View
                                        </a>

                                        @if(($enrollment->user->status ?? 'pending') === 'pending')
                                            <form method="POST" action="{{ route('teacher.enrollments.approve', $enrollment) }}" style="display:inline" class="ms-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-sm">
                                                    Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if(($enrollment->user->status ?? 'pending') === 'pending')
                                            <button type="button"
                                                    onclick="openRejectModal({{ $enrollment->id }}, '{{ addslashes(($enrollment->first_name ?? $enrollment->name ?? '') . ' ' . ($enrollment->last_name ?? '')) }}')"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm ms-2">
                                                Reject
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 border text-gray-500">No registrations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $enrollments->links() }}
                </div>
            </div>
        </div>
    </div>
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
                <button type="button" onclick="closeRejectModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded">
                    Reject Student
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
function openRejectModal(enrollmentId, studentName) {
    const modal = document.getElementById('rejectModal');
    if (!modal) return;
    modal.classList.remove('hidden');

    const studentNameElement = document.getElementById('studentName');
    if (studentNameElement) {
        studentNameElement.textContent = studentName;
    }

    const rejectForm = document.getElementById('rejectForm');
    if (rejectForm) {
        rejectForm.action = `/teacher/enrollments/${enrollmentId}/reject`;
    }

    const rejectionReason = document.getElementById('rejectionReason');
    if (rejectionReason) {
        rejectionReason.value = '';
        setTimeout(() => rejectionReason.focus(), 100);
    }
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    if (modal) modal.classList.add('hidden');
    const reasonField = document.getElementById('rejectionReason');
    if (reasonField) reasonField.value = '';
}

// Close modal when clicking overlay
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('rejectModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    }

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
@endsection
