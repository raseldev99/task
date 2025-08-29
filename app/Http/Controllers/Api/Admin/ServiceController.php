<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\CreateRequest;
use App\Http\Requests\Service\UpdateRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {
        //get specific query parameter
        $filters = $request->only(['search','status','order','min_price','max_price']);
        //retrieve data from database.
        $services = $this->service->getPaginatedServices($request->get('per_page',10),$filters);
        //send a paginated success response
        return $this->paginated(ServiceResource::collection($services));
    }

    /**
     * create a service
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $service = $this->service->createService($request->validated());
        return $this->created('Service created successful',new ServiceResource($service));
    }

    /**
     * Update a service
     * @param UpdateRequest $request
     * @param Service $service
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Service $service): JsonResponse
    {
        $service = $this->service->updateService($service,$request->validated());
        return $this->success('Service updated successful',new ServiceResource($service));
    }

    /**
     * Delete a service
     * @param Service $service
     * @return JsonResponse
     */
    public function destroy(Service $service): JsonResponse
    {
        $this->service->deleteService($service);
        return $this->noContent('Service deleted successful');
    }
}
