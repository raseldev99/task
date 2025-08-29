<?php

namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BookingRepository implements BookingRepositoryInterface
{
    public Booking $model;

    public function __construct(Booking $Booking)
    {
        $this->model = $Booking;
    }

    /**
     * Get all the Bookings
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find Booking by id
     * @param string $id
     * @return Booking|null
     */
    public function findById(string $id): ?Booking
    {
        return $this->model->find($id);
    }

    /**
     * Get pagination with filter data
     * @param int $perPage
     * @param array $filters
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function pagination(int $perPage = 10, array $filters = [], array $relations = []): LengthAwarePaginator
    {
        return $this->filter($this->model->query(),$filters)->with($relations)->paginate($perPage);
    }

    /**
     * Find a Booking by id or fail
     * @param string $id
     * @return Booking
     */
    public function findOrFailById(string $id): Booking
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a Booking
     * @param array $data
     * @return Booking
     */
    public function create(array $data): Booking
    {
        return $this->model->create($data);
    }

    /**
     * Update a Booking
     * @param Booking $Booking
     * @param array $data
     * @return Booking
     */
    public function update(Booking $Booking, array $data): Booking
    {
        $Booking->update($data);
        return $Booking->fresh();
    }

    /**
     * Delete a Booking
     * @param Booking $Booking
     * @return void
     */
    public function delete(Booking $Booking): void
    {
        $Booking->delete();
    }

    /**
     * Build a filter query
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function filter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['booking_start_date'] ?? null, function ($query, $date) {
            $query->whereDate('booking_date', '>=', $date);
        })->when($filters['booking_end_date'] ?? null, function ($query, $date) {
            $query->whereDate('booking_date', '<=', $date);
        })->when($filters['user_id'] ?? null, function ($query, $user_id) {
            $query->where('user_id', $user_id);
        })->when($filters['service_id'] ?? null,function ($query,$service_id){
            $query->where('service_id', $service_id);
        })->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        })->when(isset($filters['order_by']) || isset($filters['order']), function ($query) use ($filters) {
            $orderBy = $filters['order_by'] ?? 'id';
            $order = $filters['order'] ?? 'desc';
            $query->orderBy($orderBy, $order);
        });
    }
}
