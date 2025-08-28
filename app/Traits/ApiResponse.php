<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * Return a successful response
     */
    public function success(
        string $message = 'Request successful',
        mixed $data = null,
        int $statusCode = Response::HTTP_OK,
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
            'status_code' => $statusCode,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        $response['timestamp'] = now()->toISOString();

        return response()->json($response, $statusCode);
    }

    /**
     * Alias for success with 200 status
     */
    public function ok(string $message = 'Request successful', mixed $data = null, array $meta = []): JsonResponse
    {
        return $this->success($message, $data, Response::HTTP_OK, $meta);
    }

    /**
     * Return a created response (201)
     */
    public function created(string $message = 'Resource created successfully', mixed $data = null, array $meta = []): JsonResponse
    {
        return $this->success($message, $data, Response::HTTP_CREATED, $meta);
    }

    /**
     * Return an accepted response (202)
     */
    public function accepted(string $message = 'Request accepted', mixed $data = null, array $meta = []): JsonResponse
    {
        return $this->success($message, $data, Response::HTTP_ACCEPTED, $meta);
    }

    /**
     * Return a no content response (204)
     */
    public function noContent(string $message = 'No content'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'status_code' => Response::HTTP_NO_CONTENT,
            'timestamp' => now()->toISOString(),
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Return an error response
     */
    public function error(
        string $message,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        mixed $errors = null,
        ?string $errorCode = null,
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
            'status_code' => $statusCode,
        ];

        if ($errorCode) {
            $response['error_code'] = $errorCode;
        }

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        $response['timestamp'] = now()->toISOString();

        return response()->json($response, $statusCode);
    }

    /**
     * Return validation error response (422)
     */
    public function validationError(
        string $message = 'Validation failed',
        array $errors = [],
        array $meta = []
    ): JsonResponse {
        return $this->error($message, Response::HTTP_UNPROCESSABLE_ENTITY, $errors, 'VALIDATION_ERROR', $meta);
    }

    /**
     * Return unauthorized error (401)
     */
    public function unauthorized(string $message = 'Unauthorized access', array $meta = []): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNAUTHORIZED, null, 'UNAUTHORIZED', $meta);
    }

    /**
     * Return forbidden error (403)
     */
    public function forbidden(string $message = 'Access forbidden', array $meta = []): JsonResponse
    {
        return $this->error($message, Response::HTTP_FORBIDDEN, null, 'FORBIDDEN', $meta);
    }

    /**
     * Return not found error (404)
     */
    public function notFound(string $message = 'Resource not found', array $meta = []): JsonResponse
    {
        return $this->error($message, Response::HTTP_NOT_FOUND, null, 'NOT_FOUND', $meta);
    }

    /**
     * Return method not allowed error (405)
     */
    public function methodNotAllowed(string $message = 'Method not allowed', array $meta = []): JsonResponse
    {
        return $this->error($message, Response::HTTP_METHOD_NOT_ALLOWED, null, 'METHOD_NOT_ALLOWED', $meta);
    }

    /**
     * Return server error (500)
     */
    public function serverError(string $message = 'Internal server error', array $meta = []): JsonResponse
    {
        return $this->error($message, Response::HTTP_INTERNAL_SERVER_ERROR, null, 'SERVER_ERROR', $meta);
    }

    /**
     * Return paginated response
     */
    public function paginated(
        string $message = 'Data retrieved successfully',
        Paginator|LengthAwarePaginator $paginator,
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
            'status_code' => Response::HTTP_OK,
            'data' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'path' => $paginator->path(),
            ],
        ];

        // Add pagination info specific to LengthAwarePaginator
        if ($paginator instanceof LengthAwarePaginator) {
            $response['pagination'] = array_merge($response['pagination'], [
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
                'first_page_url' => $paginator->url(1),
                'last_page_url' => $paginator->url($paginator->lastPage()),
                'next_page_url' => $paginator->nextPageUrl(),
                'prev_page_url' => $paginator->previousPageUrl(),
                'has_more_pages' => $paginator->hasMorePages(),
            ]);
        } else {
            // For simple paginator
            $response['pagination'] = array_merge($response['pagination'], [
                'next_page_url' => $paginator->nextPageUrl(),
                'prev_page_url' => $paginator->previousPageUrl(),
                'has_more_pages' => $paginator->hasMorePages(),
            ]);
        }

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        $response['timestamp'] = now()->toISOString();

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Return collection response (non-paginated)
     */
    public function collection(
        string $message = 'Data retrieved successfully',
        iterable $data = [],
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
            'status_code' => Response::HTTP_OK,
            'data' => $data,
            'count' => is_countable($data) ? count($data) : null,
        ];

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        $response['timestamp'] = now()->toISOString();

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Return custom response with flexible structure
     */
    public function custom(
        array $data,
        int $statusCode = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        // Ensure basic structure
        $response = array_merge([
            'timestamp' => now()->toISOString(),
        ], $data);

        return response()->json($response, $statusCode, $headers);
    }
}
