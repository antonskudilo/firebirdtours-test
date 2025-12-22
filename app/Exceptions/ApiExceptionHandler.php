<?php
namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionHandler
{
    /**
     * Map of exception classes to their handler methods
     */
    public static array $handlers = [
        EntityNotFoundException::class => 'entityNotFoundException',
        CurrencyRateNotFoundException::class => 'currencyRateNotFoundException',
        ValidationException::class => 'handleValidationException',
        HttpException::class => 'handleHttpException',
        MethodNotAllowedHttpException::class => 'handleMethodNotAllowedException',
        NotFoundHttpException::class => 'handleNotFoundException',
    ];

    /**
     * Handle validation exceptions
     */
    public function handleValidationException(ValidationException $e, Request $request): JsonResponse {
        $errors = [];

        foreach ($e->errors() as $field => $messages) {
            foreach ($messages as $message) {
                $errors[] = [
                    'field' => $field,
                    'message' => $message,
                ];
            }
        }

        return response()->json([
            'error' => [
                'type' => $this->getExceptionType($e),
                'status' => 422,
                'message' => 'The provided data is invalid.',
                'timestamp' => now()->toISOString(),
                'validation_errors' => $errors,
            ]
        ], 422);
    }

    /**
     * Handle not found exceptions
     */
    public function entityNotFoundException(EntityNotFoundException $e): JsonResponse {
        return response()->json([
            'error' => [
                'type' => $this->getExceptionType($e),
                'status' => 404,
                'message' => $e->getMessage(),
                'timestamp' => now()->toISOString(),
            ]
        ], 404);
    }

    /**
     * Handle not found exceptions
     */
    public function currencyRateNotFoundException(CurrencyRateNotFoundException $e): JsonResponse {
        return response()->json([
            'error' => [
                'type' => $this->getExceptionType($e),
                'status' => 404,
                'message' => $e->getMessage(),
                'timestamp' => now()->toISOString(),
            ]
        ], 404);
    }

    /**
     * Handle general HTTP exceptions
     */
    public function handleHttpException(HttpException $e, Request $request): JsonResponse
    {
        return response()->json([
            'error' => [
                'type' => $this->getExceptionType($e),
                'status' => $e->getStatusCode(),
                'message' => $e->getMessage() ?: 'An HTTP error occurred.',
                'timestamp' => now()->toISOString(),
            ]
        ], $e->getStatusCode());
    }

    /**
     * Handle method not allowed exceptions
     */
    public function handleMethodNotAllowedException(
        MethodNotAllowedHttpException $e,
        Request $request
    ): JsonResponse {
        return response()->json([
            'error' => [
                'type' => $this->getExceptionType($e),
                'status' => 405,
                'message' => "The {$request->method()} method is not allowed for this endpoint.",
                'timestamp' => now()->toISOString(),
                'allowed_methods' => $e->getHeaders()['Allow'] ?? 'Unknown',
            ]
        ], 405);
    }

    /**
     * Handle not found exceptions
     */
    public function handleNotFoundException(
        ModelNotFoundException|NotFoundHttpException $e,
        Request $request
    ): JsonResponse {
        $message = $e instanceof ModelNotFoundException
            ? 'The requested resource was not found.'
            : "The requested endpoint '{$request->getRequestUri()}' was not found.";

        return response()->json([
            'error' => [
                'type' => $this->getExceptionType($e),
                'status' => 404,
                'message' => $message,
                'timestamp' => now()->toISOString(),
            ]
        ], 404);
    }

    /**
     * Extract a clean exception type name
     */
    private function getExceptionType(Throwable $e): string
    {
        return basename(str_replace('\\', '/', get_class($e)));
    }
}
