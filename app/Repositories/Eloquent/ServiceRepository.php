<?php

namespace App\Repositories\Eloquent;

use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ServiceRepository implements ServiceRepositoryInterface
{
    public Service $model;

    public function __construct(Service $service)
    {
        $this->model = $service;
    }

    /**
     * Get all the services
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find service by id
     */
    public function findById(string $id): ?Service
    {
        return $this->model->find($id);
    }

    /**
     * Get pagination with filter data
     */
    public function pagination(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        return $this->filter($this->model->query(), $filters)->paginate($perPage);
    }

    /**
     * Find a service by id or fail
     */
    public function findOrFailById(string $id): Service
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a service
     */
    public function create(array $data): Service
    {
        return $this->model->create($data);
    }

    /**
     * Update a service
     */
    public function update(Service $service, array $data): Service
    {
        $service->update($data);

        return $service->fresh();
    }

    /**
     * Delete a service
     */
    public function delete(Service $service): void
    {
        $service->delete();
    }

    /**
     * Build a filter query
     */
    public function filter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%');
        })->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        })->when($filters['min_price'] ?? null, function ($query, $price) {
            $query->where('price', '>=', $price);
        })->when($filters['max_price'] ?? null, function ($query, $price) {
            $query->where('price', '<=', $price);
        })->when(isset($filters['order_by']) || isset($filters['order']), function ($query) use ($filters) {
            $orderBy = $filters['order_by'] ?? 'id';
            $order = $filters['order'] ?? 'desc';
            $query->orderBy($orderBy, $order);
        });
    }
}
