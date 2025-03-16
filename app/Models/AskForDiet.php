<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AskForDiet extends Model
{
    protected $fillable = ['ask', 'user_id'];

    // Relationship
    public function user()
    {
        return $this->belongsTo(Diet::class, 'user_id');
    }
}
