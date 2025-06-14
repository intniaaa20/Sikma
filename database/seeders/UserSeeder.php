<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create the 'admin' role if it doesn't exist
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Create the 'customer' role if it doesn't exist
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // Create a user and assign the 'admin' role
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('admin');

        // Create an additional admin user
        $additionalAdmin = User::create([
            'name' => 'Additional Admin',
            'email' => 'additional_admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $additionalAdmin->assignRole('admin');

        User::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('customer');
    }
}
