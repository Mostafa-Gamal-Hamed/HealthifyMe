<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = [
        "name",
        "image",
        "category_id",
        "calories",
        "protein",
        "carbs",
        "fats",
        "vitamins",
        "fiber",
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
