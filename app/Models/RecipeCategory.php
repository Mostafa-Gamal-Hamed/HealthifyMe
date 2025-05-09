<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{
    protected $fillable = ['name'];

    // Relationship
    public function recipes()
    {
        return $this->hasMany(HealthyRecipe::class);
    }
}
