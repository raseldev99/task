<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Services\ServiceRegistry;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ApiResponse;

    public ServiceRegistry $service;

    public function __construct(ServiceRegistry $service)
    {
        $this->service = $service;
    }

    /**
     * get services
     */
    public function index(Request $request): JsonResponse
    {
        // get specific query parameter
        $filters = $request->only(['search', 'order', 'min_price', 'max_price']);
        // retrieve data from database.
        $services = $this->service->getPublishedServices($request->get('per_page', 10), $filters);

        // send a paginated success response
        return $this->paginated(ServiceResource::collection($services));
    }
}
