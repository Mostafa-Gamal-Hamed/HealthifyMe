<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'name',
        'complaint',
        'user_id',
        'diet_id',
        'SpecialDiet_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diet()
    {
        return $this->belongsTo(Diet::class);
    }

    public function specialDiet()
    {
        return $this->belongsTo(SpecialDiet::class);
    }
}
