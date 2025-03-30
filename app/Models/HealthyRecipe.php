<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthyRecipe extends Model
{
    protected $fillable = [
        'title',
        'description',
        'calories',
        'image',
        'video',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
