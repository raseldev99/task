<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Services\BookingService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use ApiResponse;

    public BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * get bookings
     */
    public function index(Request $request): JsonResponse
    {
        // get specific query parameter
        $filters = $request->only(['status', 'order', 'user_id', 'service_id', 'booking_start_date', 'booking_end_date']);
        // retrieve data from database.
        $bookings = $this->bookingService->getPaginatedBookings($request->get('per_page', 10), $filters, ['user', 'service']);

        // send a paginated success response
        return $this->paginated(BookingResource::collection($bookings));
    }
}
