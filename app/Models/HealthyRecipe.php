<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthyRecipe extends Model
{
    protected $fillable = [
        'title',
        'description',
        'calories',
        'images',
        'video',
        'recipe_category_id',
        'user_id'
    ];

    public function category()
    {
        return $this->belongsTo(RecipeCategory::class, 'recipe_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
