<?php

namespace Authenticate\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'full-name' => 'required|string|max:85',
            'username' => 'required|string|alpha_num|unique:users,username|min:6',
            'mobile' => 'required|string|unique:users,mobile|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
        ];
    }

    public function attributes()
    {
        return [
            'full-name' => "نام و نام خانوادگی"
           
        ];
    }

}
