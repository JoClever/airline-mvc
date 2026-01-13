<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterFlightsRequest extends FormRequest
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
            'day' => 'nullable|date_format:Y-m-d',
            'month' => 'nullable|date_format:Y-m',
            'flightnumber' => 'nullable|string|max:10',
            'aircraft_id' => 'nullable|exists:aircraft,id',
            'departure_airport' => 'nullable|string|max:100',
            'arrival_airport' => 'nullable|string|max:100',
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
            'aircraft_id.exists' => 'Das ausgewählte Flugzeug existiert nicht.',
        ];
    }
}
