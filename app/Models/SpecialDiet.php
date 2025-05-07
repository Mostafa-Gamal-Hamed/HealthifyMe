<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialDiet extends Model
{
    protected $fillable = [
        'name',
        'description',
        'calories',
        'protein',
        'carbs',
        'fats',
        'workouts',
        'images',
        'user_id',
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
}
