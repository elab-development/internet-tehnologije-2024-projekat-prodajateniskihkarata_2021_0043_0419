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
}
