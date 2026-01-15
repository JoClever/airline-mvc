<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlannerFlightRequest extends FormRequest
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
            'flight_number' => 'required|string|max:10',
            'aircraft_id' => 'required|exists:aircraft,id',
            'departure_time_scheduled' => 'required|date',
            'arrival_time_scheduled' => 'required|date',
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id',
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
            'flight_number.required' => 'The flight number is required.',
            'aircraft_id.required' => 'The aircraft is required.',
            'departure_time_scheduled.required' => 'The departure time is required.',
            'arrival_time_scheduled.required' => 'The arrival time is required.',
            'departure_airport_id.required' => 'The departure airport is required.',
            'departure_airport_id.exists' => 'The selected departure airport is invalid.',
            'arrival_airport_id.required' => 'The arrival airport is required.',
            'arrival_airport_id.exists' => 'The selected arrival airport is invalid.',
        ];
    }
}
