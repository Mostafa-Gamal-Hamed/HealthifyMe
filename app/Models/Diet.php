<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    protected $fillable = [
        'name',
        'description',
        'calories',
        'protein',
        'carbs',
        'fats',
        'workouts',
        'image',
    ];

    // Relationships
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_diets', 'diet_id', 'user_id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
}
