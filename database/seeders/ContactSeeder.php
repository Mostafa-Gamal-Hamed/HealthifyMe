<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $status = ['unread', 'read'];
        for ($i = 0; $i < 100; $i++) {
            Contact::create([
                'name'    => Str::random(4) . $i,
                'email'   => Str::random(6) . '.' . $i . '@example.com',
                'subject' => Str::random(10),
                'message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'status'  => $status[array_rand($status)],
            ]);
        }
    }
}
