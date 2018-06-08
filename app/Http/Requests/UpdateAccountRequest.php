<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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

        return [
            'account_type_id' => 'required|exists:account_types,id',
            'code' => ['required', Rule::unique('accounts')->where(function ($query) {
                return $query->where('owner_id', \Auth::id());
            })],
            'date' => 'required|date',
            'description' => 'nullable|max:255',
            'start_balance' => 'required|numeric',

        ];
    }
}
