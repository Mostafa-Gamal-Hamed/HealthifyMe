<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'desc',
        'user_id',
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(BlogLike::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->where('status', 'like')->count();
    }

    public function getDislikesCountAttribute()
    {
        return $this->likes()->where('status', 'dislike')->count();
    }
}
