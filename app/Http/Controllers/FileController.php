<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        $path = $request->file('file')->store('uploads');

        return response()->json(['path' => $path]);
    }

    /**
     * Prikaz forme za upload fajlova (ako je potrebno).
     */
    public function create()
    {
        return view('upload.create');
    }

    /**
     * Čuvanje uploadovanog fajla.
     */
    public function store(Request $request)
    {
        // Validacija fajla
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Čuvanje fajla u 'public' disk (public/storage)
        if ($request->file('file')->isValid()) {
            $path = $request->file('file')->store('uploads', 'public');
            return response()->json(['message' => 'File uploaded successfully', 'path' => $path], 201);
        }

        return response()->json(['error' => 'Failed to upload file'], 500);
    }
}
