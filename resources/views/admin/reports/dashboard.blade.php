@extends('layouts.admin')

@section('content')
    <section class="py-6">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="font-semibold text-2xl leading-tight mb-4 text-white">Reports & Summary</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Students with Submitted Forms</div>
                    <div class="text-3xl font-bold text-blue-300">{{ $totalStudents }}</div>
                </div>

                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Pending Registrations</div>
                    <div class="text-3xl font-bold text-yellow-400">{{ $pending }}</div>
                </div>

                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Approved Registrations</div>
                    <div class="text-3xl font-bold text-green-400">{{ $approved }}</div>
                </div>

                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 border border-blue-800/40 rounded-2xl shadow-xl p-6 text-center">
                    <div class="text-sm text-blue-100">Total Registrations</div>
                    <div class="text-3xl font-bold text-indigo-300">{{ $totalEnrollments }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
