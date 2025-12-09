@extends('layouts.teacher')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Grade Management</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Grade Entry -->
            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg p-6 text-white">
                <h3 class="text-xl font-semibold mb-4">Grade Entry</h3>
                <p class="text-orange-100 mb-4">Update and manage student grades</p>
                <button class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition-colors">
                    Enter Grades
                </button>
            </div>
            
            <!-- Grade Reports -->
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg p-6 text-white">
                <h3 class="text-xl font-semibold mb-4">Grade Reports</h3>
                <p class="text-blue-100 mb-4">Generate grade summaries and reports</p>
                <button class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                    View Reports
                </button>
            </div>
        </div>
        
        <!-- Recent Grades Table -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Grade Entries</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">John Doe</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Mathematics</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">95</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-01-15</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Jane Smith</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Science</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">88</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-01-14</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection