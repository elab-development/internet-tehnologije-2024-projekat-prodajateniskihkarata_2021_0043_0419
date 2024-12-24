<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads');
        
        return response()->json(['message' => 'Fajl je uspešno otpremljen', 'path' => $path], 200);
    }
}
