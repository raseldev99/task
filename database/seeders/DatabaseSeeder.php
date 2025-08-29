<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create a customer
        User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'role' => Roles::User(),
            'password' => '12345678',
        ]);

        // create an admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => Roles::Admin(),
            'password' => '12345678',
        ]);

        // create 10 example customers
        User::factory()
            ->count(10)
            ->create();

        // call all the seeder
        $this->call([
            ServiceSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
