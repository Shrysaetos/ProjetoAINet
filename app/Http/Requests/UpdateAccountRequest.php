<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


use Carbon\Carbon;

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

        $date = Carbon::now();

        return [
            'account_type_id' => 'required',
            'code' => 'required|unique:accounts|regex:/^[A-Za-z0-9]/',
            'date' => 'required|before_or_equal:'.$date->format('Y-m-d'),
            'description' => 'max:255',
            'start_balance' => 'numeric',

        ];
    }
}
