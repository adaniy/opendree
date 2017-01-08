<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActionRequest extends FormRequest
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
            'nom' => 'required',
            'alert' => 'required|boolean',
            'alertStart' => 'numeric',
            'realise' => 'required|boolean',
            'date_creation' => 'required|date_format:d/m/Y',
            'date_realisation' => 'date_format:d/m/Y',
            'date_butoire' => 'required|date_format:d/m/Y',
        ];
    }
}