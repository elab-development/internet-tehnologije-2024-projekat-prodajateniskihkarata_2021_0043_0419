<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            Log::error('Authentication error: ' . $exception->getMessage());
            return response()->json(['error' => 'Niste ovlašćeni za pristup ovoj akciji.'], 401);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'error' => 'Podaci nisu ispravni.',
                'details' => $exception->errors()
            ], 422);
        }

        // Takođe, možete dodati globalnu obradbu za sve neuhvaćene izuzetke
        return parent::render($request, $exception);
    }

}