<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AskForDiet extends Model
{
    protected $fillable = ['ask', 'user_id', 'accept'];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
