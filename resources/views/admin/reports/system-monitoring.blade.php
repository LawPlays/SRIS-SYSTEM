@extends('layouts.admin')

@section('content')
    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <h2 class="font-semibold text-2xl leading-tight text-white">System Monitoring</h2>
            <!-- Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Total Users</div>
                    <div class="mt-1 text-3xl font-bold text-blue-300">{{ $metrics['total_users'] ?? 0 }}</div>
                </div>
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Active Students</div>
                    <div class="mt-1 text-3xl font-bold text-green-400">{{ $metrics['active_students'] ?? 0 }}</div>
                </div>
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Total Teachers</div>
                    <div class="mt-1 text-3xl font-bold text-indigo-300">{{ $metrics['total_teachers'] ?? 0 }}</div>
                </div>
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Total Documents</div>
                    <div class="mt-1 text-3xl font-bold text-purple-300">{{ $metrics['total_documents'] ?? 0 }}</div>
                </div>
            </div>

            <!-- Storage Usage & DB Health -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-xl p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Storage Usage</h3>
                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <div class="text-sm text-gray-600">Total MB</div>
                            <div class="mt-1 text-2xl font-bold text-blue-600">{{ $metrics['storage_usage']['total_mb'] ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Total Bytes</div>
                            <div class="mt-1 text-2xl font-bold text-gray-800">{{ $metrics['storage_usage']['total_bytes'] ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Documents</div>
                            <div class="mt-1 text-2xl font-bold text-indigo-700">{{ $metrics['storage_usage']['document_count'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Database Health</h3>
                    <div class="space-y-2">
                        <div>
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="ml-2 font-semibold {{ ($dbHealth['status'] ?? 'error') === 'healthy' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($dbHealth['status'] ?? 'error') }}</span>
                        </div>
                        <div class="text-sm text-gray-600">Last Checked: <span class="font-medium text-gray-800">{{ $dbHealth['last_checked'] ?? '' }}</span></div>
                        <div class="mt-4">
                            <table class="min-w-full table-auto border-collapse text-gray-900">
                                <thead>
                                    <tr class="bg-gray-50 text-left">
                                        <th class="px-4 py-2 border border-gray-200 text-gray-800">Table</th>
                                        <th class="px-4 py-2 border border-gray-200 text-gray-800">Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(($dbHealth['tables'] ?? []) as $table => $count)
                                        <tr class="bg-white">
                                            <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ $table }}</td>
                                            <td class="px-4 py-2 border border-gray-200 font-semibold text-gray-900">{{ $count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            <div class="bg-white rounded-2xl shadow-xl p-6 text-gray-900">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">System Alerts</h3>
                <div class="space-y-3">
                    @forelse(($alerts ?? []) as $alert)
                        <div class="p-4 rounded-lg border
                            {{ $alert['type'] === 'warning' ? 'border-yellow-300 bg-yellow-50' : 'border-blue-300 bg-blue-50' }}">
                            <div class="font-semibold text-gray-800">{{ $alert['title'] }}</div>
                            <div class="text-gray-700">{{ $alert['message'] }}</div>
                            @if(!empty($alert['action_url']))
                                <a href="{{ $alert['action_url'] }}" class="mt-2 inline-block text-sm px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700">Take Action</a>
                            @endif
                        </div>
                    @empty
                        <div class="text-gray-500">No alerts.</div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Logins -->
            <div class="bg-white rounded-2xl shadow-xl p-6 text-gray-900">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent User Activity (7 days)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse text-gray-900">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">User</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Email</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Role</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Last Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($metrics['recent_logins'] ?? []) as $u)
                                <tr class="bg-white">
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ $u->name }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ $u->email }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ ucfirst($u->role) }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ optional($u->updated_at)->format('M d, Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-600">No recent activity</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection