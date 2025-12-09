<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">My Notifications</h2>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('student.notifications.mark-all-read') }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                        Mark All as Read
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white/95 overflow-hidden shadow-xl rounded-2xl border border-blue-100">
                <div class="p-6 text-gray-800">
                    @if($notifications->count() > 0)
                        @foreach($notifications as $notification)
                        <div class="group border-b border-gray-200 py-4 rounded-lg transition {{ !$notification->is_read ? 'bg-blue-50' : 'hover:bg-gray-50' }}">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $notification->type === 'success' ? 'bg-green-100 text-green-800' : 
                                               ($notification->type === 'warning' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($notification->type === 'error' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                            {{ ucfirst($notification->type) }}
                                        </span>
                                        @if(!$notification->is_read)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                New
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1 group-hover:text-gray-800">{{ $notification->title }}</h3>
                                    <p class="text-gray-800 mb-2">{{ $notification->message }}</p>
                                    <p class="text-sm text-gray-600">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    @if(!$notification->is_read)
                                        <form method="POST" action="{{ route('student.notifications.mark-read', $notification) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
                                                Mark as Read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 text-6xl mb-4">
                                <span class="material-icons" style="font-size: 4rem;">notifications_none</span>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications yet</h3>
                            <p class="text-gray-500">You'll see notifications here when there are updates about your enrollment or documents.</p>
                        </div>
                    @endif

                    @if($notifications->hasPages())
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>