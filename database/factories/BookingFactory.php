<?php

namespace Database\Factories;

use App\Enums\Roles;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::inRandomOrder()->first()->id,
            'booking_date' => $this->faker->date(),
            'user_id' => User::where('role', Roles::User())->inRandomOrder()->first()->id,
        ];
    }
}
