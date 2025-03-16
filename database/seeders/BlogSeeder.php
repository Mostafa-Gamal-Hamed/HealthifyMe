<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        for ($i=0; $i < 150; $i++) {
            Blog::create([
                'title' => 'Blog Post ' . $i,
                'slug'  => uniqid(),
                'image' => 'blogs/blog.jpg',
                'desc'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla
                    auctor, vestibulum magna sed, convallis ex. Cum sociis natoque p
                    odium estibulum at ligula. Donec malesuada orci a ex blandit
                    rhoncus. Ut et nulla auctor, vestibulum magna sed, convallis ex.
                    Cum sociis natoque penatibus et magnis dis parturient montes,
                    nascetur ridiculus mus. Cum sociis natoque penatibus et magnis
                    dis parturient montes, nascetur ridiculus mus. Cum sociis nato
                    que penatibus et magnis dis parturient montes, nascetur ridicu
                    lus mus.',
                'user_id' => rand(1,3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
