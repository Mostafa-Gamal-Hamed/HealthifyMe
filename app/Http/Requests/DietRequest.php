<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DietRequest extends FormRequest
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
            "name"        => "required|string|min:3|max:255",
            "description" => "required|string",
            "calories"    => "required|integer",
            "workouts"    => "required|string",
            "images"      => "array",
            "images.*"    => "image|mimes:png,jpg,jpeg,gif",
        ];
    }
}
