<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //Relationships
    public function dietInfo()
    {
        return $this->hasOne(DietInfo::class, 'user_id');
    }

    public function diets()
    {
        return $this->belongsToMany(Diet::class, 'user_diets', 'user_id', 'diet_id');
    }

    public function specialDiet()
    {
        return $this->hasOne(SpecialDiet::class, 'user_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function blogLikes()
    {
        return $this->hasMany(BlogLike::class);
    }

    public function askForDiet()
    {
        return $this->hasMany(AskForDiet::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function sentMessage()
    {
        return $this->hasMany(SentMessage::class);
    }

    public function recipe()
    {
        return $this->hasMany(HealthyRecipe::class);
    }

    public function recipeLikes()
    {
        return $this->hasMany(RecipeLike::class);
    }
}
