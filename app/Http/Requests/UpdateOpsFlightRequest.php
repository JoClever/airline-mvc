<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOpsFlightRequest extends FormRequest
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
            'crew_id' => 'nullable|integer|exists:crews,id',
            'diversion_airport_id' => 'nullable|integer|exists:airports,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'crew_id.exists' => 'The selected crew is invalid.',
            'diversion_airport_id.exists' => 'The selected diversion airport is invalid.',
        ];
    }
}
