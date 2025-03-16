<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogLike extends Model
{
    protected $fillable = [
        'status',
        'blog_id',
        'user_id',
    ];

    // Relationship
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
