<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;

class Handler extends ExceptionHandler {
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Personalizar las respuestas de excepciones.
     */
    public function render($request, Throwable $e) {
        if ($e instanceof ThrottleRequestsException) {
            // Cabecera Retry-After trae los segundos de espera
            $seconds = (int) ($e->getHeaders()['Retry-After'] ?? 900);
            $minutes = ceil($seconds / 60);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __("Has hecho demasiados intentos, por favor espera :minutes minutos.", [
                        'minutes' => $minutes,
                    ]),
                ], 429);
            }

            return response()->view('errors.429', [
                'minutes' => $minutes,
            ], 429);
        }

        return parent::render($request, $e);
    }
}
