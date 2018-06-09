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
            'phone' => 'nullable|regex:/^[0-9+ ]/',
            'profile_photo' => 'nullable|image',
        ];
    }
}
