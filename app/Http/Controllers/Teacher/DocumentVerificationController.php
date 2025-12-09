<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentVerificationController extends Controller
{
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|in:submitted,verified,rejected',
            'remarks' => 'nullable|string|max:2000',
        ]);

        $document->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
            'verified_by' => Auth::id(),
            'verified_at' => $request->status === 'verified' ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Document verification updated.');
    }
}

