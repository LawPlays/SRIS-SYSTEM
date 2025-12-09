@extends('layouts.admin')

@section('content')
    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <h2 class="font-semibold text-2xl leading-tight text-white">Enrollment Report</h2>
            <!-- Filters -->
            <div class="bg-gradient-to-br from-blue-900 to-indigo-900 rounded-2xl shadow-xl border border-blue-800/40 p-6 text-white">
                <form method="GET" action="{{ route('admin.reports.enrollment-report') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-blue-100 mb-1">Status</label>
                        <select name="status" class="w-full rounded-lg border border-blue-300 bg-white text-gray-900 px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="" {{ request('status') ? '' : 'selected' }}>All</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-blue-100 mb-1">Grade Level</label>
                        <input type="text" name="grade_level" value="{{ request('grade_level') }}" placeholder="e.g., Grade 7, Grade 11" class="w-full rounded-lg border border-blue-300 bg-white text-gray-900 px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="block text-blue-100 mb-1">Strand</label>
                        <input type="text" name="strand" value="{{ request('strand') }}" placeholder="e.g., STEM, HUMSS, TVL" class="w-full rounded-lg border border-blue-300 bg-white text-gray-900 px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-blue-100 mb-1">Date From</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-lg border border-blue-300 bg-white text-gray-900 px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block text-blue-100 mb-1">Date To</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-lg border border-blue-300 bg-white text-gray-900 px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </div>

                    <div class="md:col-span-4 flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium">Filter</button>
                        <a href="{{ route('admin.reports.enrollment-report') }}" class="px-4 py-2 rounded-lg bg-white text-blue-700 font-medium border border-blue-300 hover:bg-blue-50">Clear</a>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Total</div>
                    <div class="mt-1 text-3xl font-bold text-blue-300">{{ $summary['total'] ?? 0 }}</div>
                </div>
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Approved</div>
                    <div class="mt-1 text-3xl font-bold text-green-400">{{ $summary['approved'] ?? 0 }}</div>
                </div>
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Pending</div>
                    <div class="mt-1 text-3xl font-bold text-yellow-400">{{ $summary['pending'] ?? 0 }}</div>
                </div>
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Rejected</div>
                    <div class="mt-1 text-3xl font-bold text-red-400">{{ $summary['rejected'] ?? 0 }}</div>
                </div>
            </div>

            <!-- Results -->
            <div class="bg-white rounded-2xl shadow-xl p-6 text-gray-900">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Filtered Results</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse text-gray-900">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">ID</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Student</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Grade Level</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Strand</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Status</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrollments as $enrollment)
                                <tr class="bg-white">
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ $enrollment->id }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ optional($enrollment->user)->name ?? 'Unknown' }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ $enrollment->grade_level ?? '—' }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ $enrollment->strand ?? '—' }}</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ optional($enrollment->user)->status === 'approved' ? 'bg-green-100 text-green-700' : (optional($enrollment->user)->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                            {{ ucfirst(optional($enrollment->user)->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ optional($enrollment->created_at)->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-600">No results found</td>
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
    </section>
@endsection