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
            'flight_number' => 'nullable|exists:flights,flight_number',
            'aircraft_id' => 'nullable|exists:aircraft,id',
            'no_aircraft' => 'nullable|boolean',
            'crew_id' => 'nullable|exists:crews,id',
            'no_crew' => 'nullable|string:on',
            'departure_time_scheduled' => 'nullable|date',
            'day' => 'nullable|date_format:Y-m-d',
            'month' => 'nullable|date_format:Y-m',
            'departure_airport_id' => 'nullable|exists:airports,id',
            'arrival_airport_id' => 'nullable|exists:airports,id',
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
