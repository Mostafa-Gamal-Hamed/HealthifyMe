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
            'firstName' => 'Mayar',
            'lastName'  => 'Mohamed',
            'email'     => 'y@y.y',
            'email_verified_at' => now(),
            'password'  => bcrypt('Mm123456@'),
            'role'      => 'admin',
            'status'    => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i=0; $i < 100; $i++) {
            User::create([
                'firstName' => 'User first ' . $i,
                'lastName'  => 'User last ' . $i,
                'email'     => 'user' . $i . '@example.com',
                'email_verified_at' => now(),
                'password'  => bcrypt('Mm123456@'),
                'role'      => 'user',
                'status'    => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
