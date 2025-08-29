<?php

namespace App\Repositories\Interfaces;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface
{
    /**
     * get all Booking collection
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find Booking by id
     * @param string $id
     * @return Booking|null
     */
    public function findById(string $id): ?Booking;

    /**
     * Get filter Bookings
     * @param int $perPage
     * @param array $filters
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function pagination(int $perPage = 10, array $filters = [], array $relations = []): LengthAwarePaginator;

    /**
     * Find Booking by id or fail
     * @param string $id
     * @return Booking
     */
    public function findOrFailById(string $id): Booking;

    /**
     * Create a new Booking
     * @param array $data
     * @return Booking
     */
    public function create(array $data): Booking;

    /**
     * Update Booking
     * @param Booking $Booking
     * @param array $data
     * @return Booking
     */
    public function update(Booking $Booking, array $data): Booking;

    /**
     * Delete a Booking
     * @param Booking $Booking
     * @return void
     */
    public function delete(Booking $Booking): void;

}
