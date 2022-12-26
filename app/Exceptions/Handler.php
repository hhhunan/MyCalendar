<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param  Throwable  $exception
     *
     * @return JsonResponse
     */
    public function render($request, Throwable $exception):JsonResponse
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => 'Data not found'], 404);
        }

        //todo handle all exceptions
        if ($exception instanceof ValidationException) {
            return response()->json([
                'error_code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'errors' => $exception->errors()
            ]);
        }

        return response()->json([
            'error_code' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ]);
    }
    protected function unauthenticated($request, AuthenticationException $exception):?JsonResponse
    {
        if ($request->expectsJson())
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }
}
