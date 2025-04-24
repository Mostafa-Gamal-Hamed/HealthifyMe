<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DietInfo extends Model
{
    protected $fillable = [
        'age',
        'gender',
        'weight',
        'height',
        'activity_level',
        'workout_hours_per_week',
        'bodyFat',
        'bodyWater',
        'diseases',
        'treatment',
        'user_id',
    ];

    //Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
