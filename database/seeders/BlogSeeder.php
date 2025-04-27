<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        Blog::create([
            'title' => 'How to Lose Weight Effectively',
            'slug'  => 'How to Lose Weight Effectively',
            'image' => 'blogs/blog.jpg',
            'desc'  => "<p class='card-text fs-5'>
                        Losing weight isn't just about cutting calories. It's about building a lifestyle you can maintain.
                        At <strong>HealthifyMe.top</strong>, we help you build healthy habits with custom meal plans,
                        accurate calorie tracking, and science-based tips tailored to your body and routine.
                        </p>
                        <p class='card-text fs-5'>
                        Start your fitness journey today and discover how our platform makes it easier to stay on track —
                        whether you want to burn fat, eat better, or just feel more energetic. 🚀
                        </p>
                        <a href='/register' class='btn btn-success mt-3'>Start Your Plan Now</a>
            ",
            'user_id' => rand(1, 2),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
