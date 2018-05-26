<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
        $account = \Route::current()->parameter('account');
        return [
            'code' => 'required|regex:/^[\pL\s]+$/|unique:accounts,code,'.$account->code,
            'date' => 'required|', /** falta verificar que é menor que a data do sistema */
            'description' => 'max:255'
        ];
    }
}
