<?php

namespace App\Repositories\Interfaces;

use App\Models\Service;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ServiceRepositoryInterface
{
    /**
     * get all service collection
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find service by id
     * @param string $id
     * @return Service|null
     */
    public function findById(string $id): ?Service;

    /**
     * Get filter services
     * @param int $perPage
     * @param array $filters
     * @return Collection
     */
    public function pagination(int $perPage = 10, array $filters = []): LengthAwarePaginator;

    /**
     * Find service by id or fail
     * @param string $id
     * @return Service
     */
    public function findOrFailById(string $id): Service;

    /**
     * Create a new service
     * @param array $data
     * @return Service
     */
    public function create(array $data): Service;

    /**
     * Update service
     * @param Service $service
     * @param array $data
     * @return Service
     */
    public function update(Service $service, array $data): Service;

    /**
     * Delete a services
     * @param Service $service
     * @return void
     */
    public function delete(Service $service): void;

}
