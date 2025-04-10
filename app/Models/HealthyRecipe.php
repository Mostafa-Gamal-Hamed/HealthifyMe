<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthyRecipe extends Model
{
    protected $fillable = [
        'title',
        'description',
        'calories',
        'images',
        'video',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
