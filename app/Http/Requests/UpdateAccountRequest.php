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
            'account_type_id' => 'required|exists:account_types,id',
            'code' => 'required|unique:accounts,code,'.$account->id,
            'date' => 'required|date',
            'description' => 'nullable|max:255',
            'start_balance' => 'required|numeric',

        ];
    }
}
