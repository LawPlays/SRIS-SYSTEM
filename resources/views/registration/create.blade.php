@extends('layouts.app')
@section('content')
  <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Student Registration</h2>
    <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input name="first_name" placeholder="First name" value="{{ old('first_name') }}" class="p-2 border rounded" required>
        <input name="last_name" placeholder="Last name" value="{{ old('last_name') }}" class="p-2 border rounded" required>
        <input name="birthdate" type="date" class="p-2 border rounded">
        <select name="gender" class="p-2 border rounded">
          <option value="">Gender</option>
          <option>Male</option><option>Female</option>
        </select>
        <input name="contact_number" placeholder="Contact number" class="p-2 border rounded">
        <input name="address" placeholder="Address" class="p-2 border rounded md:col-span-2">
        <input type="file" name="documents[]" multiple class="p-2 border rounded md:col-span-2">
      </div>
      <div class="mt-4">
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Submit</button>
      </div>
    </form>
  </div>
@endsection
