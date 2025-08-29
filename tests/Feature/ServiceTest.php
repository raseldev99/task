<?php

use App\Enums\Roles;
use App\Enums\ServiceStatus;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

// ---------------------
// User Routes
// ---------------------

it('allows a user to fetch only published services', function () {
    $user = User::factory()->create(['role' => Roles::User()->value]);
    Sanctum::actingAs($user, ['*']);

    Service::factory()->create(['status' => ServiceStatus::Published()->value]);
    Service::factory()->create(['status' => ServiceStatus::Draft()->value]);
    Service::factory()->create(['status' => ServiceStatus::Archived()->value]);
    $response = $this->getJson('/api/services');

    $response->assertStatus(200)
        ->assertJsonFragment(['status' =>  ServiceStatus::Published()->value])
        ->assertJsonMissing(['status' => ServiceStatus::Draft()->value])
        ->assertJsonMissing(['status' => ServiceStatus::Archived()->value]);
});

it('rejects unauthenticated users for user services route', function () {
    $response = $this->getJson('/api/services');
    $response->assertStatus(401);
});

it('rejects non-user roles for user services route', function () {
    $admin = User::factory()->create(['role' => Roles::Admin()->value]);
    Sanctum::actingAs($admin, ['*']);

    $response = $this->getJson('/api/services');
    $response->assertStatus(403);
});

// ---------------------
// Admin Routes
// ---------------------

it('allows admin to list all services', function () {
    $admin = User::factory()->create(['role' => Roles::Admin()->value]);
    Sanctum::actingAs($admin, ['*']);

    Service::factory()->count(10)->create();

    $response = $this->getJson('/api/admin/services');

    $response->assertStatus(200)
        ->assertJsonCount(10, 'data');
});

it('allows admin to create a new service', function () {
    $admin = User::factory()->create(['role' => Roles::Admin()->value]);
    Sanctum::actingAs($admin, ['*']);

    $payload = [
        'name' => 'New Service',
        'description' => 'Test description',
        'price' => 100,
    ];

    $response = $this->postJson('/api/admin/services', $payload);

    $response->assertStatus(201)
        ->assertJsonFragment(['name' => 'New Service']);

    $this->assertDatabaseHas('services', ['name' => 'New Service']);
});

it('allows admin to update a service', function () {
    $admin = User::factory()->create(['role' => Roles::Admin()->value]);
    Sanctum::actingAs($admin, ['*']);

    $service = Service::factory()->create();

    $response = $this->putJson("/api/admin/services/{$service->id}", [
        'name' => 'Updated Service',
        'description' => $service->description,
        'price' => 200,
        'status' => ServiceStatus::Archived()->value,
    ]);

    $response->assertStatus(200)
        ->assertJsonFragment(['name' => 'Updated Service']);

    $this->assertDatabaseHas('services', [
        'id' => $service->id,
        'name' => 'Updated Service',
        'status' => ServiceStatus::Archived()->value,
    ]);
});

it('allows admin to delete a service', function () {
    $admin = User::factory()->create(['role' => Roles::Admin()->value]);
    Sanctum::actingAs($admin, ['*']);

    $service = Service::factory()->create();

    $response = $this->deleteJson("/api/admin/services/{$service->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('services', ['id' => $service->id]);
});

it('rejects non-admin roles for admin routes', function () {
    $user = User::factory()->create(['role' => Roles::User()->value]);
    Sanctum::actingAs($user, ['*']);

    $response = $this->getJson('/api/admin/services');
    $response->assertStatus(403);
});
