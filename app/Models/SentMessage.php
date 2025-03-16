<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentMessage extends Model
{
    protected $fillable = [
        'email',
        'message',
        'user_id',
        'contact_id',
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
