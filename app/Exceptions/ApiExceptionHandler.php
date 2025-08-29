<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionHandler extends Exception
{
    use ApiResponse;

    /**
     * Handle the exception and return the appropriate JSON response.
     */
    public function handle(Throwable $e, Request $request): JsonResponse
    {

        // Validation Exception
        if ($e instanceof ValidationException) {
            return $this->validationError($e->getMessage(), $e->errors());
        }

        // Model Not Found Exception
        if ($e instanceof ModelNotFoundException) {
            return $this->notFound($e->getMessage());
        }

        // Authentication Exception
        if ($e instanceof AuthenticationException) {
            return $this->unauthorized($e->getMessage());
        }

        // Authorization Exception
        if ($e instanceof AuthorizationException) {
            return $this->forbidden($e->getMessage());
        }

        // Page Not Found Exception
        if ($e instanceof NotFoundHttpException) {
            return $this->notFound('Record not found');
        }

        // Bad Request Exception
        if ($e instanceof BadRequestHttpException) {
            return $this->error('Bad request', 400);
        }
        // Dynamically determine the status code if available
        $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

        return $this->error($e->getMessage(), $statusCode);
    }
}
