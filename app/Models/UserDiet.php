<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDiet extends Model
{
    protected $fillable = [
        'user_id',
        'diet_id',
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
}
