<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CreateRequest;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {
        //get specific query parameter
        $filters = $request->only(['status','order','service_id','booking_start_date','booking_end_date']);
        //set auth user id
        $filters['user_id'] = $request->user()->id;
        //retrieve data from database.
        $bookings = $this->bookingService->getPaginatedBookings($request->get('per_page',10),$filters,['service','user']);
        //send a paginated success response
        return $this->paginated(BookingResource::collection($bookings));
    }

    public function store(CreateRequest $request): JsonResponse
    {
       $data = $request->validated();
       //set authenticate user id
       $data['user_id'] = $request->user()->id;
       //set status
        $data['status'] = BookingStatus::Pending();
       $booking = $this->bookingService->createBooking($data);
       $booking->load('service');

       //send a successful created response
       return $this->created('Booking successfully created', BookingResource::make($booking));
    }
}
