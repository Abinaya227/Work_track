<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'manager@worktrack.test'],
            [
                'name' => 'WorkTrack Manager',
                'password' => Hash::make('Manager@123'),
                'role' => 'manager',
            ]
        );

        User::updateOrCreate(
            ['email' => 'employee@worktrack.test'],
            [
                'name' => 'WorkTrack Employee',
                'password' => Hash::make('Employee@123'),
                'role' => 'employee',
            ]
        );
    }
}
