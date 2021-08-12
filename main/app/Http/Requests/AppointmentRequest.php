<?php

namespace App\Http\Requests;

use App\Rules\emailCustom;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'call' => 'required',
            // 'patient.email' => 'required|email',
            // 'diagnosticoId' => 'required',
            // 'diagnosticoId.value' => 'required|exists:cie10s,code',
            'person_remisor' => 'required',
            'ips_remisor' =>  'required',
            'especiality' =>  'required',
            'date_remisor' =>  'required',
            'procedureId.value' =>  'required|exists:cups,id',
            'observation' => 'required',
            'patient.email' => ['required','email', new emailCustom]
        ];
    }

    public function messages()
    {
        return [
            'procedureId.value.required' => 'Debe elegir un procedimiento valido',
            'diagnosticoId.value.required' => 'Debe elegir un procedimiento valido',
            'patient.email.email' => 'Debe elegir un email valido',
            'diagnosticoId.required'  => 'Debe elegir un diagnostico valido',
        ];
    }
}
