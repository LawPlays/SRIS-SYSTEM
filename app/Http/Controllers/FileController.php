<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;

class FileController extends Controller
{
    public function public(Request $request, string $path)
    {
        $fullPath = storage_path('app/public/'.ltrim($path, '/'));
        if (!is_file($fullPath)) {
            abort(404);
        }

        $doc = Document::where('file_path', ltrim($path, '/'))->first();
        if (!$doc) {
            abort(404);
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $isOwner = $doc->user_id === $user->id;
        $isStaff = in_array($user->role, ['admin','teacher']);

        if (!($isOwner || $isStaff)) {
            abort(403);
        }

        return response()->file($fullPath);
    }
}
