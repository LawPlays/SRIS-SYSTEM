@extends('layouts.admin')

@section('content')
    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-2xl leading-tight text-white">Enhanced Dashboard</h2>
                <a href="{{ route('admin.reports.enrollment-report') }}" class="text-sm px-3 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white">Go to Enrollment Report</a>
            </div>
            <!-- Top Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6">
                    <div class="text-sm text-blue-100">Total Students (with enrollment)</div>
                    <div class="mt-2 text-3xl font-bold text-blue-300">{{ $totalStudents }}</div>
                </div>
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6">
                    <div class="text-sm text-blue-100">Pending Enrollments</div>
                    <div class="mt-2 text-3xl font-bold text-yellow-400">{{ $pendingEnrollments }}</div>
                </div>
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6">
                    <div class="text-sm text-blue-100">Approved Enrollments</div>
                    <div class="mt-2 text-3xl font-bold text-green-400">{{ $approvedEnrollments }}</div>
                </div>
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6">
                    <div class="text-sm text-blue-100">Rejected Enrollments</div>
                    <div class="mt-2 text-3xl font-bold text-red-400">{{ $rejectedEnrollments }}</div>
                </div>
            </div>

            <!-- Monthly Trends & Grade/Strand Distribution -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-xl p-6 overflow-x-auto text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Enrollments (Last 12 months)</h3>
                    <table class="min-w-full table-auto border-collapse text-gray-900">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Month</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Year</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthlyEnrollments as $m)
                                <tr class="bg-white">
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ str_pad($m->month, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ $m->year }}</td>
                                    <td class="px-4 py-2 border border-gray-200 font-semibold text-gray-900">{{ $m->count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-gray-600">No data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 grid grid-cols-1 gap-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Grade Level Distribution</h3>
                        <table class="min-w-full table-auto border-collapse text-gray-900">
                            <thead>
                                <tr class="bg-gray-50 text-left">
                                    <th class="px-4 py-2 border border-gray-200 text-gray-800">Grade Level</th>
                                    <th class="px-4 py-2 border border-gray-200 text-gray-800">Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gradeLevelStats as $g)
                                    <tr class="bg-white">
                                        <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ $g->grade_level ?? '—' }}</td>
                                        <td class="px-4 py-2 border border-gray-200 font-semibold text-gray-900">{{ $g->count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 text-center text-gray-600">No data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="overflow-x-auto">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Strand Distribution</h3>
                        <table class="min-w-full table-auto border-collapse text-gray-900">
                            <thead>
                                <tr class="bg-gray-50 text-left">
                                    <th class="px-4 py-2 border border-gray-200 text-gray-800">Strand</th>
                                    <th class="px-4 py-2 border border-gray-200 text-gray-800">Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($strandStats as $s)
                                    <tr class="bg-white">
                                        <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ $s->strand ?? '—' }}</td>
                                        <td class="px-4 py-2 border border-gray-200 font-semibold text-gray-900">{{ $s->count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 text-center text-gray-600">No data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Document Stats -->
            <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6">
                <h3 class="text-lg font-semibold text-blue-100 mb-4">Document Submission</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <div class="text-sm text-blue-100">Total Students</div>
                        <div class="mt-1 text-2xl font-bold text-blue-300">{{ $documentStats['total_students'] ?? 0 }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-blue-100">With PSA (Birth Certificate)</div>
                        <div class="mt-1 text-2xl font-bold text-indigo-300">{{ $documentStats['with_psa'] ?? 0 }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-blue-100">Completion Rate</div>
                        <div class="mt-1 text-2xl font-bold text-green-300">{{ $documentStats['document_completion_rate'] ?? 0 }}%</div>
                    </div>
                </div>
            </div>

            <!-- Recent Enrollments -->
            <div class="bg-white rounded-2xl shadow-xl p-6 text-gray-900">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Enrollments (7 days)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse text-gray-900">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Student</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Status</th>
                                <th class="px-4 py-2 border border-gray-200 text-gray-800">Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEnrollments as $e)
                                <tr class="bg-white">
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ optional($e->user)->name ?? 'Unknown' }}</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ optional($e->user)->status === 'approved' ? 'bg-green-100 text-green-700' : (optional($e->user)->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                            {{ ucfirst(optional($e->user)->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 border border-gray-200 text-gray-800">{{ optional($e->created_at)->format('M d, Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-gray-600">No recent enrollments</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection