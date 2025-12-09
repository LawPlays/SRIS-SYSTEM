<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">Announcements</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">
                @forelse($announcements as $announcement)
                    <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-blue-100">
                        <div class="p-6 flex items-start justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">{{ $announcement->title }}</h2>
                                <p class="mt-2 text-gray-700">{{ $announcement->content }}</p>
                                <div class="mt-3 text-sm text-gray-500">
                                    Posted by {{ $announcement->user->name ?? '—' }} · {{ optional($announcement->created_at)->format('M d, Y') }}
                                </div>
                            </div>
                            <span class="px-2 py-1 rounded text-xs bg-blue-600 text-white">Priority {{ $announcement->priority }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-600">No announcements available.</div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
