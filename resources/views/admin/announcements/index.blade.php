@extends('layouts.admin')

@section('content')
<!-- Floating Tech Grid Background -->
<div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900"></div>
    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(59, 130, 246, 0.3) 1px, transparent 0); background-size: 50px 50px;"></div>
    
    <!-- Floating Neon Orbs -->
    <div class="absolute top-20 left-20 w-32 h-32 bg-blue-500 rounded-full filter blur-xl opacity-20 animate-pulse"></div>
    <div class="absolute top-40 right-32 w-24 h-24 bg-purple-500 rounded-full filter blur-xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-32 left-1/3 w-28 h-28 bg-cyan-500 rounded-full filter blur-xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
</div>

<div class="relative z-10 container mx-auto px-6 py-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-400 via-purple-400 to-cyan-400 bg-clip-text text-transparent mb-2">
                Announcements Management
            </h1>
            <p class="text-gray-300 text-lg">Manage and broadcast important announcements</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" 
           class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            Create Announcement
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-400/30 backdrop-blur-sm">
            <div class="flex items-center">
                <span class="text-2xl mr-3">✅</span>
                <span class="text-green-300 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Table Container -->
    <div class="bg-gray-800/40 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-700/50 overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-gray-800/80 to-gray-900/80 backdrop-blur-sm">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-bold text-blue-300 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-blue-300 uppercase tracking-wider">Priority</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-blue-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-blue-300 uppercase tracking-wider">Created By</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-blue-300 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-blue-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
                <tbody class="divide-y divide-blue-400/10">
                     @forelse($announcements as $announcement)
                         <tr class="hover:bg-blue-500/10 transition-all duration-300 group">
                             <td class="px-6 py-5">
                                 <div class="text-white font-semibold text-lg group-hover:text-blue-300 transition-colors">{{ $announcement->title }}</div>
                                 <div class="text-gray-400 text-sm mt-1">{{ Str::limit($announcement->content, 50) }}</div>
                             </td>
                             <td class="px-6 py-5">
                                 @if($announcement->priority === 'high')
                                     <span class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg">High</span>
                                 @elseif($announcement->priority === 'medium')
                                     <span class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-lg">Medium</span>
                                 @else
                                     <span class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg">Low</span>
                                 @endif
                             </td>
                             <td class="px-6 py-5">
                                 @if($announcement->is_active)
                                     <span class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg">Active</span>
                                 @else
                                     <span class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-gray-500 to-gray-600 text-white shadow-lg">Inactive</span>
                                 @endif
                             </td>
                             <td class="px-6 py-5">
                                 <div class="text-blue-200 font-medium">{{ $announcement->user->name }}</div>
                             </td>
                             <td class="px-6 py-5">
                                 <div class="text-gray-300 font-medium">{{ $announcement->created_at->format('M d, Y') }}</div>
                             </td>
                             <td class="px-6 py-5">
                                 <div class="flex space-x-3">
                                     <a href="{{ route('admin.announcements.edit', $announcement) }}" 
                                        class="px-4 py-2 rounded-lg bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-medium hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                         Edit
                                     </a>
                                     <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" 
                                           style="display:inline" 
                                           onsubmit="return confirm('Are you sure you want to delete this announcement?')">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" 
                                                 class="px-4 py-2 rounded-lg bg-gradient-to-r from-red-500 to-pink-500 text-white font-medium hover:from-red-600 hover:to-pink-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                             Delete
                                         </button>
                                     </form>
                                 </div>
                             </td>
                         </tr>
                     @empty
                         <tr>
                             <td colspan="6" class="px-6 py-12 text-center">
                                 <div class="text-6xl mb-4"></div>
                                 <p class="text-xl font-semibold text-blue-300 mb-2">No announcements found.</p>
                                 <p class="text-gray-400">Create your first announcement to get started.</p>
                             </td>
                         </tr>
                     @endforelse
                 </tbody>
            </table>
    </div>

    <!-- Pagination -->
    @if($announcements->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-gray-800/40 backdrop-blur-md rounded-xl p-4 border border-gray-700/50">
                {{ $announcements->links() }}
            </div>
        </div>
    @endif
</div>
@endsection