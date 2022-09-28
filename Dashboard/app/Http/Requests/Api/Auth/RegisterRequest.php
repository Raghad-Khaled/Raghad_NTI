<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name'=>['required','between:2,255'],
            'last_name'=>['required','between:2,255'],
            'email' => ['required', 'string', 'email','unique:admins'],
            'password' => ['required',Password::defaults(),'confirmed'],
            'password_confirmation' => ['required'],
            'phone' => ['required','regex:/^01[0125][0-9]{8}$/'],
            'gender'=>['required','in:f,m'],
            'device_name' => ['required']
        ];
    }
}
