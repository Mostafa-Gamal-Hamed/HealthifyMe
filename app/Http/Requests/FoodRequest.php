<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodRequest extends FormRequest
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
        $rules = [
            'name'        => 'required|unique:food,name,'. $this->id,
            'calories'    => 'required|numeric',
            'protein'     => 'required|numeric',
            'carbs'       => 'required|numeric',
            'fats'        => 'required|numeric',
            'fiber'       => 'required|numeric',
            'vitamins'    => 'nullable',
            'category_id' => 'required|exists:categories,id',
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:png,jpg,jpeg,gif';
        } else {
            $rules['image'] = 'nullable|image|mimes:png,jpg,jpeg,gif';
        }

        return $rules;
    }
}
