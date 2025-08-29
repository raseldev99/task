<?php

namespace App\Services;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingService
{
    public BookingRepositoryInterface $bookingRepository;

    public function all(): \Illuminate\Support\Collection
    {
        return $this->bookingRepository->all();
    }

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function getPaginatedBookings(int $perPage = 10, array $filters = [], array $relations = []): LengthAwarePaginator
    {
        return $this->bookingRepository->pagination($perPage, $filters, $relations);
    }

    /**
     * Create a Booking
     */
    public function createBooking(array $data): Booking
    {
        return $this->bookingRepository->create($data);
    }

    /**
     * Update a Booking
     */
    public function updateBooking(Booking $booking, array $data): Booking
    {
        return $this->bookingRepository->update($booking, $data);
    }

    /**
     * delete a Booking
     */
    public function deleteBooking(Booking $Booking): void
    {
        $this->bookingRepository->delete($Booking);
    }
}
