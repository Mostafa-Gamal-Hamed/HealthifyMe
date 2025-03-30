<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeLike extends Model
{
    protected $fillable = [
        'status',
        'healthy_recipe_id',
        'user_id',
    ];

    // Relationship
    public function recipes()
    {
        return $this->belongsTo(HealthyRecipe::class);
    }
}
