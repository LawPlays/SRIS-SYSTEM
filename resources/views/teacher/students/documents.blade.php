@extends('layouts.teacher')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-blue-950 to-gray-900 relative overflow-hidden p-8">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.1),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(147,51,234,0.08),transparent_40%)]"></div>
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10 mix-blend-overlay"></div>

    <div class="relative z-10 flex items-center justify-between mb-8">
        <h2 class="text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Student Documents</h2>
        <a href="{{ route('teacher.students.index') }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white">Back to list</a>
    </div>

    <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Required Documents --}}
        <div class="bg-blue-900/40 border border-blue-800/50 rounded-2xl p-6 backdrop-blur-xl">
            <h3 class="text-xl font-bold text-blue-300 mb-4">Required Documents</h3>
            <ul class="list-disc list-inside text-blue-100">
                @foreach($requiredDocuments as $doc)
                    <li>{{ $doc }}</li>
                @endforeach
            </ul>
        </div>

        {{-- Submitted Documents --}}
        <div class="bg-blue-900/40 border border-blue-800/50 rounded-2xl p-6 backdrop-blur-xl">
            <h3 class="text-xl font-bold text-blue-300 mb-4">Submitted Documents</h3>
            @if($student->documents->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-blue-100">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->documents as $doc)
                                <tr>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('files.public', ['path' => $doc->file_path]) }}" class="underline hover:text-blue-300" target="_blank">{{ $doc->file_name }}</a>
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="inline-block px-2 py-1 rounded text-sm {{ $doc->status === 'verified' ? 'bg-green-700/60 text-green-200' : ($doc->status === 'rejected' ? 'bg-red-700/60 text-red-200' : 'bg-yellow-700/60 text-yellow-200') }}">
                                            {{ ucfirst($doc->status ?? 'submitted') }}
                                        </span>
                                        @if($doc->remarks)
                                            <div class="text-xs text-blue-200 mt-1">{{ $doc->remarks }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        <form method="POST" action="{{ route('teacher.documents.verify', $doc) }}" class="inline-flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="bg-blue-950 text-blue-100 border border-blue-800 rounded px-2 py-1 text-sm">
                                                <option value="submitted" {{ $doc->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                                <option value="verified" {{ $doc->status === 'verified' ? 'selected' : '' }}>Verified</option>
                                                <option value="rejected" {{ $doc->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                            <input type="text" name="remarks" placeholder="Remarks (optional)" value="{{ old('remarks', $doc->remarks) }}" class="bg-blue-950 text-blue-100 border border-blue-800 rounded px-2 py-1 text-sm w-64">
                                            <button type="submit" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-500 text-white text-sm">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-blue-200">No documents submitted.</p>
            @endif
        </div>

        {{-- Missing Documents --}}
        <div class="md:col-span-2 bg-blue-900/40 border border-blue-800/50 rounded-2xl p-6 backdrop-blur-xl">
            <h3 class="text-xl font-bold text-blue-300 mb-4">Missing Documents</h3>
            @if(count($missingDocuments))
                <ul class="list-disc list-inside text-orange-200">
                    @foreach($missingDocuments as $doc)
                        <li>{{ $doc }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-green-200">All required documents submitted.</p>
            @endif
        </div>
    </div>
</div>
@endsection
