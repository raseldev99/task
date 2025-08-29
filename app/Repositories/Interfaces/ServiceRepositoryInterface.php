<?php

namespace App\Repositories\Interfaces;

use App\Models\Service;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ServiceRepositoryInterface
{
    /**
     * get all service collection
     */
    public function all(): Collection;

    /**
     * Find service by id
     */
    public function findById(string $id): ?Service;

    /**
     * Get filter services
     */
    public function pagination(int $perPage = 10, array $filters = []): LengthAwarePaginator;

    /**
     * Find service by id or fail
     */
    public function findOrFailById(string $id): Service;

    /**
     * Create a new service
     */
    public function create(array $data): Service;

    /**
     * Update service
     */
    public function update(Service $service, array $data): Service;

    /**
     * Delete a services
     */
    public function delete(Service $service): void;
}
