<?php

namespace Database\Seeders;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		//Create Admin
        User::create([
			'name' => 'Admin',
			'email' => 'admin@gmail.com',
			'password'=>bcrypt('password'),
			'role' => Role::ADMIN->value
		]);
    }
}
