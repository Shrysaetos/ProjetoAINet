<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateUserRequest extends FormRequest
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
        $hashedPassword = Auth::user()->password;
        $user = \Route::current()->parameter('user');
        return [
            'name' => 'required|regex:/^[\pL\s]+$/',
            'type' => 'required|between:0,2',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'old_password' => 'required|string|min:3',
            'password' => 'required|string|min:3|confirmed',
            'phone' => 'nullable|numeric|min:9|max:9',
            'profile_photo' => 'nullable|mimes:jpg,png',
        ];
    }
}
