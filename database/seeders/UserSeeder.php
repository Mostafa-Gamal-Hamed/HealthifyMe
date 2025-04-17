<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'firstName' => 'Mostafa',
            'lastName'  => 'Gamal',
            'email'     => 'm@m.m',
            'email_verified_at' => now(),
            'password'  => bcrypt('Mm123456@'),
            'role'      => 'superAdmin',
            'status'    => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'firstName'         => 'Ali',
            'lastName'          => 'Mohamed',
            'email'             => 'a@a.a',
            'email_verified_at' => now(),
            'password'          => bcrypt('Mm123456@'),
            'role'              => 'admin',
            'status'            => 'active',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        User::create([
            'firstName' => 'ahmed',
            'lastName'  => 'mohassen',
            'email'     => 'ah@ah.ah',
            'email_verified_at' => now(),
            'password'  => bcrypt('Mm123456@'),
            'role'      => 'doctor',
            'status'    => 'inactive',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'firstName' => 'User',
            'lastName'  => 'mohamed',
            'email'     => 'user@example.com',
            'email_verified_at' => now(),
            'password'  => bcrypt('Mm123456@'),
            'role'      => 'user',
            'status'    => 'inactive',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
