<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|regex:/^[\pL\s]+$/',
            'type' => 'required|between:0,2',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'required|string|min:3|confirmed',
<<<<<<< HEAD
            'phone' => 'nullable|regex:/^[0-9+ ]/',
=======
            'phone' => 'nullable|numeric|min:9|max:14',
>>>>>>> c46ec2828f09e9011c5cbe3a1be31e45cc3ca9be
            'profile_photo' => 'nullable|image',
        ];
    }
}
