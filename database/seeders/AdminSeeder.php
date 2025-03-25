<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin1 User',
            'number' => '1234567890',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);
    }
}
