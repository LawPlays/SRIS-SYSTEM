@extends('layouts.teacher')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Reports</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Performance Reports -->
            <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg p-6 text-white">
                <h3 class="text-xl font-semibold mb-4">Performance Reports</h3>
                <p class="text-pink-100 mb-4">Generate student performance analytics</p>
                <button class="bg-white text-pink-600 px-4 py-2 rounded-lg font-semibold hover:bg-pink-50 transition-colors">
                    Generate Report
                </button>
            </div>
            
            <!-- Attendance Reports -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg p-6 text-white">
                <h3 class="text-xl font-semibold mb-4">Attendance Reports</h3>
                <p class="text-indigo-100 mb-4">Monthly attendance summaries</p>
                <button class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-indigo-50 transition-colors">
                    View Report
                </button>
            </div>
            
            <!-- Grade Reports -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg p-6 text-white">
                <h3 class="text-xl font-semibold mb-4">Grade Reports</h3>
                <p class="text-green-100 mb-4">Class grade distributions</p>
                <button class="bg-white text-green-600 px-4 py-2 rounded-lg font-semibold hover:bg-green-50 transition-colors">
                    View Report
                </button>
            </div>
        </div>
        
        <!-- Recent Reports -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Reports</h3>
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-semibold text-gray-800">Mathematics Class Performance - Q1</h4>
                            <p class="text-sm text-gray-600">Generated on January 15, 2024</p>
                        </div>
                        <button class="text-blue-600 hover:text-blue-800 font-medium">Download</button>
                    </div>
                </div>
                
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-semibold text-gray-800">Attendance Summary - December 2023</h4>
                            <p class="text-sm text-gray-600">Generated on January 10, 2024</p>
                        </div>
                        <button class="text-blue-600 hover:text-blue-800 font-medium">Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection