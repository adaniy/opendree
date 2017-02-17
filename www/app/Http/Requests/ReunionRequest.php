<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReunionRequest extends FormRequest
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
            'id' => 'filled|numeric',
            'sujet' => 'filled|min:1',
            'date' => 'filled|date_format:Y-m-d H:i:s',
            'date_prochain' => 'filled|date_format:Y-m-d H:i:s'
        ];
    }
}
