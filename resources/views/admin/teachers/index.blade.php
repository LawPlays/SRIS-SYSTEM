@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-gray-900 relative overflow-hidden p-10">

    {{-- Floating Tech Grid Background --}}
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.15),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(147,51,234,0.1),transparent_40%)]"></div>
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10 mix-blend-overlay"></div>

    {{-- Neon Glow Orbs --}}
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-blue-700/30 rounded-full blur-[180px]"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-700/20 rounded-full blur-[180px]"></div>

    {{-- Title --}}
    <div class="flex justify-between items-center mb-14 relative z-10">
        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent tracking-wide drop-shadow-[0_0_25px_rgba(59,130,246,0.4)]">
            Teacher Management
        </h1>
        <a href="{{ route('admin.teachers.create') }}" 
           class="btn btn-green btn-lg">
            Create Teacher Account
        </a>
    </div>

    @if(session('success'))
        <div class="relative z-10 mb-6 p-4 rounded-xl border border-green-400/20 bg-gradient-to-r from-green-900/40 to-emerald-900/20 backdrop-blur-xl text-green-300 shadow-[0_0_20px_-5px_rgba(34,197,94,0.4)]">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative z-10 overflow-hidden rounded-2xl border border-blue-400/20 
                bg-gradient-to-b from-blue-900/40 to-gray-900/20 backdrop-blur-xl 
                shadow-[0_0_20px_-5px_rgba(59,130,246,0.4)]">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-blue-600/60 to-indigo-600/60 backdrop-blur-sm">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold text-blue-200 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-blue-200 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-blue-200 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-blue-200 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-blue-200 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-400/10">
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-blue-500/10 transition-all duration-300 group">
                            <td class="px-6 py-5">
                                <div class="text-white font-semibold text-lg group-hover:text-blue-300 transition-colors">{{ $teacher->name }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-blue-200 font-medium">{{ $teacher->email }}</div>
                            </td>
                            <td class="px-6 py-5">
                                @if($teacher->status === 'approved')
                                    <span class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg">Active</span>
                                @else
                                    <span class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg">Suspended</span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-gray-300 font-medium">{{ $teacher->created_at->timezone(config('app.timezone'))->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.teachers.show', $teacher) }}" 
                                       class="btn btn-blue">
                                        View
                                    </a>
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}" 
                                       class="btn btn-yellow">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" 
                                          style="display:inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this teacher account?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-red">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-6xl mb-4"></div>
                                <p class="text-xl font-semibold text-blue-300 mb-2">No teacher accounts found.</p>
                                <p class="text-gray-400">Create your first teacher account to get started.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($teachers->hasPages())
            <div class="px-6 py-4 border-t border-white/10">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection