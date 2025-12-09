@extends('layouts.teacher')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Attendance Management</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Today's Attendance -->
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg p-6 text-white">
                <h3 class="text-xl font-semibold mb-4">Today's Attendance</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Present:</span>
                        <span class="font-bold">85%</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Absent:</span>
                        <span class="font-bold">15%</span>
                    </div>
                </div>
            </div>
            
            <!-- Weekly Report -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg p-6 text-white">
                <h3 class="text-xl font-semibold mb-4">Weekly Report</h3>
                <p class="text-purple-100">View attendance trends and patterns</p>
                <button class="mt-4 bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-purple-50 transition-colors">
                    View Report
                </button>
            </div>
        </div>
    </div>
</div>
@endsection