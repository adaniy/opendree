<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardRequest extends FormRequest
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
            'idAgent' => 'filled|numeric',
            'name' => 'filled|min:1',
            'type' => 'filled|in:money,amount',
            'agents' => 'filled|numeric',
            'holidays' => 'filled|numeric',
            'hours' => 'filled|numeric',

            // pour les congés
            'debut' => 'filled|date',
            'fin' => 'filled|date'
        ];
    }
}
