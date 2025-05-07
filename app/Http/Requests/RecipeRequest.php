<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'calories'           => 'required|numeric',
            'protein'            => 'required|numeric',
            'carbs'              => 'required|numeric',
            'fats'               => 'required|numeric',
            'video'              => 'nullable|mimes:mp4|max:50000',
            'images'             => 'nullable|array',
            'images.*'           => 'image|mimes:png,jpg,jpeg,gif|max:5000',
            'recipe_category_id' => 'required|exists:recipe_categories,id',
        ];
    }
}
