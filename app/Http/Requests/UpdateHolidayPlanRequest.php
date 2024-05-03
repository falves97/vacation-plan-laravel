<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHolidayPlanRequest extends FormRequest
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
            'title' => 'string|nullable|max:255',
            'description' => 'string|nullable|max:255',
            'location' => 'string|nullable|max:255',
            'date' => 'dateformat:d/m/Y|nullable',
            'participants' => 'array|nullable',
            'participants.*' => 'email|required|max:255|exists:users,email',
        ];
    }
}
