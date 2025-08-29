<?php

namespace App\Services;

use App\Enums\ServiceStatus;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceRegistry
{
    public ServiceRepositoryInterface $serviceRepository;

    public function all(): \Illuminate\Support\Collection
    {
        return $this->serviceRepository->all();
    }

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getPaginatedServices(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        return $this->serviceRepository->pagination($perPage, $filters);
    }

    /**
     * Get published services only
     */
    public function getPublishedServices(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $filters['status'] = ServiceStatus::Published();

        return $this->serviceRepository->pagination($perPage, $filters);
    }

    /**
     * Create a service
     */
    public function createService(array $data): Service
    {
        return $this->serviceRepository->create($data);
    }

    /**
     * Update a service
     */
    public function updateService(Service $service, array $data): Service
    {
        return $this->serviceRepository->update($service, $data);
    }

    /**
     * delete a service
     */
    public function deleteService(Service $service): void
    {
        $this->serviceRepository->delete($service);
    }
}
