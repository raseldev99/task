<?php

// ---------------------
// User Routes
// ---------------------

use App\Enums\Roles;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

// ---------------------
// User Routes
// ---------------------

it('allows a user to fetch only own bookings', function () {
    $user = User::factory()->create(['role' => Roles::User()->value]);
    $user2 = User::factory()->create(['role' => Roles::User()->value]);
    Service::factory()->count(20)->create();
    Booking::factory()->count(100)->create(['user_id' => $user->id]);
    Booking::factory()->count(100)->create(['user_id' => $user2->id]);
    Sanctum::actingAs($user, ['*']);
    $response = $this->getJson('/api/bookings?per_page=1000');

    $response->assertStatus(200)
        ->assertJsonCount(100, 'data');
});

it('allows user to create a new booking', function () {
    $user = User::factory()->create(['role' => Roles::User()->value]);
    $service = Service::factory()->create(['status' => \App\Enums\ServiceStatus::Published()->value]);

    Sanctum::actingAs($user, ['*']);
    $booking_date = Carbon::now()->addDay()->format("Y-m-d");
    $payload = [
        'user_id' => $user->id,
        'service_id' => $service->id,
        'booking_date' => $booking_date,
    ];

    $response = $this->postJson('/api/bookings', $payload);

    $response->assertStatus(201)
        ->assertJsonFragment(['booking_date' => $booking_date]);

    $this->assertDatabaseHas('bookings', ['user_id' => $user->id, 'service_id' => $service->id,'booking_date' => $booking_date]);
});

it('rejects unauthenticated users for user bookings route', function () {
    $response = $this->getJson('/api/bookings');
    $response->assertStatus(401);
});

it('rejects non-user roles for user bookings route', function () {
    $admin = User::factory()->create(['role' => Roles::Admin()->value]);
    Sanctum::actingAs($admin, ['*']);

    $response = $this->getJson('/api/bookings');
    $response->assertStatus(403);
});


// ---------------------
// Admin Routes
// ---------------------

it('allows admin to list all bookings', function () {
    $admin = User::factory()->create(['role' => Roles::Admin()->value]);
    Sanctum::actingAs($admin, ['*']);

    $services = Service::factory()->count(10)->create();
    $users = User::factory()->count(10)->create();
    Booking::factory()->count(200)->create([
        'user_id' => $users->random()->id,
        'service_id' => $services->random()->id,
    ]);

    $response = $this->getJson('/api/admin/bookings?per_page=1000');

    $response->assertStatus(200)
        ->assertJsonCount(200, 'data');
});


