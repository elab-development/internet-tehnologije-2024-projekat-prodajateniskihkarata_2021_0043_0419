<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        // Validacija fajla (tip, veličina)
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        // Smeštanje fajla u 'uploads' direktorijum u storage
        $path = $request->file('file')->store('uploads', 'public'); // 'public' disk

        // Vraćanje odgovora sa putanjom fajla
        return response()->json(['path' => $path]);
    }

    /**
     * Prikaz forme za upload fajlova.
     */
    public function create()
    {
        return view('upload.create'); // Blade fajl za formu
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

        // Provera da li je fajl validan
        if ($request->file('file')->isValid()) {
            // Čuvanje fajla u 'public' disk (public/storage)
            $path = $request->file('file')->store('uploads', 'public');

            // Vraćanje odgovora sa putanjom fajla
            return response()->json([
                'message' => 'File uploaded successfully',
                'path' => $path,
            ], 201); // Status 201 označava uspešan upload
        }

        // Ako fajl nije validan
        return response()->json([
            'error' => 'Failed to upload file',
        ], 500); // Status 500 označava grešku servera
    }
}