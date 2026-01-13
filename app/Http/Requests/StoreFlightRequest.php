<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFlightRequest extends FormRequest
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
            'departure_time' => 'required|date',
            'enroute_time' => 'required|decimal:0,2',
            'departure_airport_icao' => 'required|string|size:4',
            'arrival_airport_icao' => 'required|string|size:4',
            'registration_number' => 'required|string|max:10',
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
            'flight_number.required' => 'Die Flugnummer ist erforderlich.',
            'departure_time.required' => 'Die Abflugzeit ist erforderlich.',
            'enroute_time.required' => 'Die Flugzeit ist erforderlich.',
            'departure_airport_icao.required' => 'Der Abflughafen ist erforderlich.',
            'departure_airport_icao.size' => 'Der ICAO-Code muss genau 4 Zeichen lang sein.',
            'arrival_airport_icao.required' => 'Der Ankunftsflughafen ist erforderlich.',
            'arrival_airport_icao.size' => 'Der ICAO-Code muss genau 4 Zeichen lang sein.',
            'registration_number.required' => 'Die Registrierungsnummer ist erforderlich.',
        ];
    }
}
