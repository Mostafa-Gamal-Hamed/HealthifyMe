<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];

    // Relationship
    public function sentMessage()
    {
        return $this->hasOne(SentMessage::class, 'contact_id');
    }
}
