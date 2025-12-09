@extends('layouts.teacher')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">My Announcements</h1>
        <a href="{{ route('teacher.announcements.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            <i class="material-icons inline-block mr-2">add</i>
            Create Announcement
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white/10 backdrop-blur-md rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-blue-600/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-white/5 transition duration-200">
                            <td class="px-6 py-4">
                                <div class="text-white font-medium">{{ $announcement->title }}</div>
                                <div class="text-gray-300 text-sm mt-1">{{ Str::limit($announcement->content, 100) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($announcement->priority == 3)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500 text-white">High</span>
                                @elseif($announcement->priority == 2)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500 text-white">Medium</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500 text-white">Low</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($announcement->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500 text-white">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-500 text-white">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-white">{{ $announcement->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('teacher.announcements.edit', $announcement) }}" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm transition duration-200">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('teacher.announcements.destroy', $announcement) }}" 
                                          style="display:inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this announcement?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition duration-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                <i class="material-icons text-4xl mb-2">announcement</i>
                                <p>No announcements found.</p>
                                <p class="text-sm mt-2">Create your first announcement to communicate with students.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($announcements->hasPages())
            <div class="px-6 py-4 border-t border-white/10">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</div>
@endsection