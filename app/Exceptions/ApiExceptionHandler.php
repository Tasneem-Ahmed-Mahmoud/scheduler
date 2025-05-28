<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiExceptionHandler
{
    public function __invoke(Throwable $exception, Request $request): Response
    {
     
        if (!$request->expectsJson()) {
            
            throw $exception;
        }
        // Validation error
        if ($exception instanceof ValidationException) {
            return ApiResponseError('Validation Error', 422, $exception->errors());
        }
        
        // Resource not found
        if ($exception instanceof NotFoundHttpException) {
            return ApiResponseError('Resource not found', 404);
        }

        // Method not allowed
        if ($exception instanceof MethodNotAllowedHttpException) {
            return ApiResponseError('Method not allowed', 405);
        }
        // Unauthenticated
        if ($exception instanceof AuthenticationException) {
            return ApiResponseError('Unauthenticated', 401);
        }
        // Default/fallback
        return ApiResponseError(
            config('app.debug') ? $exception->getMessage() : 'Server Error',
            500
        );
    }
}