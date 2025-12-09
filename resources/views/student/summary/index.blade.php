@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Registration Summary') }}</div>

                <div class="card-body">
                    @if($enrollment)
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Personal Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>{{ $enrollment->first_name }} {{ $enrollment->middle_name }} {{ $enrollment->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>LRN:</strong></td>
                                        <td>{{ $enrollment->lrn ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Age:</strong></td>
                                        <td>{{ $enrollment->age ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sex:</strong></td>
                                        <td>{{ $enrollment->sex }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Birthdate:</strong></td>
                                        <td>{{ $enrollment->birthdate }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Place of Birth:</strong></td>
                                        <td>{{ $enrollment->place_of_birth }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Academic Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>School Year:</strong></td>
                                        <td>{{ $enrollment->school_year ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Grade Level:</strong></td>
                                        <td>{{ $enrollment->grade_level ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Strand:</strong></td>
                                        <td>{{ $enrollment->strand ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $enrollment->status === 'approved' ? 'success' : ($enrollment->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Address Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Current Address:</strong></td>
                                        <td>{{ $enrollment->current_address }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Permanent Address:</strong></td>
                                        <td>{{ $enrollment->permanent_address }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Family Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Father's Name:</strong></td>
                                        <td>{{ $enrollment->father_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mother's Name:</strong></td>
                                        <td>{{ $enrollment->mother_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Guardian's Name:</strong></td>
                                        <td>{{ $enrollment->guardian_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Number:</strong></td>
                                        <td>{{ $enrollment->contact_number }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($enrollment->psa_birth_certificate)
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Uploaded Documents</h5>
                                <p><strong>PSA Birth Certificate:</strong> 
                                    <a href="{{ route('files.public', ['path' => $enrollment->psa_birth_certificate]) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        View Document
                                    </a>
                                </p>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <h5>No Registration Found</h5>
                    <p>You haven't submitted a registration application yet.</p>
                    <a href="{{ route('student.enrollment.create') }}" class="btn btn-primary">Start Registration</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection