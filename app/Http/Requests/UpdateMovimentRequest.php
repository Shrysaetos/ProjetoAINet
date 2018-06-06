<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovimentRequest extends FormRequest
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
            'moviment_category_id'=>'required',
            'description' => 'max:255',
            'date' => 'required|before_or_equal:'.$date->format('Y-m-d'),
            'value' => 'required|numeric',
            //'document' => ''
        ];
    }
}
