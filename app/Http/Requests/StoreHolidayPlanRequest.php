<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHolidayPlanRequest extends FormRequest
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
            'title' => 'string|required|max:255',
            'description' => 'string|required|max:255',
            'location' => 'string|required|max:255',
            'date' => 'dateformat:d/m/Y|required',
            'participants' => 'array|nullable',
            'participants.*' => 'integer|required|exists:users,id',
        ];
    }
}
