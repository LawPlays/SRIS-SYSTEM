<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Auth::user()->documents()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch the student's latest enrollment to show the complete filled-out form
        $enrollment = Auth::user()->enrollment;

        $requiredDocuments = [
            'PSA Birth Certificate',
            'Form 137 (Report Card)',
            'Certificate of Good Moral Character',
            'Medical Certificate',
            'Passport Size Photo (2x2)',
        ];

        return view('student.documents.index', compact('documents', 'requiredDocuments', 'enrollment'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $file = $request->file('file');

        // Server-side MIME verification
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $detectedMime = $finfo->file($file->getRealPath());
        $allowedMimes = ['image/jpeg','image/png','application/pdf'];
        if (!in_array($detectedMime, $allowedMimes)) {
            return redirect()->back()->with('error', 'Invalid file type detected.');
        }

        // Filename sanitization
        $base = preg_replace('/[^a-z0-9\-_.]/i', '_', strtolower($request->document_type));
        $filename = time() . '_' . $base . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('uploads/documents', $filename, 'public');

        $document = Document::create([
            'user_id' => Auth::id(),
            'file_name' => $request->document_type,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'status' => 'submitted',
        ]);

        // Send notification
        NotificationService::notifyDocumentUpload(Auth::user(), $request->document_type);

        return redirect()->back()->with('success', 'Document uploaded successfully!');
    }

    public function download($id)
    {
        $document = Auth::user()->documents()->findOrFail($id);
        
        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    public function delete($id)
    {
        $document = Auth::user()->documents()->findOrFail($id);
        
        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->back()->with('success', 'Document deleted successfully!');
    }
}
