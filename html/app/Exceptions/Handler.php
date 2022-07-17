<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Convert the given exception to an array.
     *
     * @param Exception $e
     * @return array
     */
    public function convertExceptionToArray(Throwable $e): array
    {
        return config('app.debug') ? [
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : [
            'message' => $this->isProtectedException($e) ? 'Server Error' : $e->getMessage()
        ];
    }

    /**
     * @param Exception $e
     * @return bool
     */
    public function isProtectedException(Exception $e): bool
    {
        return $e instanceof QueryException ||
            $e instanceof EncryptException ||
            $e instanceof DecryptException;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        switch (get_class($e)) {
            case AuthorizationException::class:
                /** @var AuthorizationException $e */
                return response()->json([
                    'message' => $e->getMessage()
                ], 403);
            case ValidationException::class:
                /** @var ValidationException $e */
                return response()->json([
                    'message' => __('validation.error-message'),
                    'errors' => $e->errors()
                ], $e->status);
            default:
                /** @var Exception $e */
                if ($request->expectsJson()) {
                    return response()->json($this->convertExceptionToArray($e), 500);
                }
        }

        return parent::render($request, $e);
    }
}
