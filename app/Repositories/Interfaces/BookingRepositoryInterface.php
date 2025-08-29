<?php

namespace App\Repositories\Interfaces;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface
{
    /**
     * get all Booking collection
     */
    public function all(): Collection;

    /**
     * Find Booking by id
     */
    public function findById(string $id): ?Booking;

    /**
     * Get filter Bookings
     */
    public function pagination(int $perPage = 10, array $filters = [], array $relations = []): LengthAwarePaginator;

    /**
     * Find Booking by id or fail
     */
    public function findOrFailById(string $id): Booking;

    /**
     * Create a new Booking
     */
    public function create(array $data): Booking;

    /**
     * Update Booking
     */
    public function update(Booking $Booking, array $data): Booking;

    /**
     * Delete a Booking
     */
    public function delete(Booking $Booking): void;
}
