<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DietInfoRequest extends FormRequest
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
            'age' => 'required|integer',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'gender' => 'required|string',
            'activity_level' => 'required|string',
            'workout_hours_per_week' => 'required|numeric',
        ];
    }
}
