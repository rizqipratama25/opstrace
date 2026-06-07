<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "Rizqi Pratama",
                "email" => "rizqipratama.se@gmail.com",
                "password" => Hash::make("rizqi123"),
            ],
            [
                "name" => "Admin Opstrace",
                "email" => "admin@opstrace.com",
                "password" => Hash::make("admin123"),
            ],
        ];

        foreach($users as $user) {
            User::create($user);
        }
    }
}
