<?php

namespace Authenticate\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckUsernameRequest extends FormRequest
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
            'username' => 'required|string|alpha_num|min:6',
            'uid' => 'nullable|integer|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'uid'=>"کاربر"
        ];
    }
}
