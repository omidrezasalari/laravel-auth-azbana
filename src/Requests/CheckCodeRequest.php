<?php

namespace Authenticate\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckCodeRequest extends FormRequest
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
            'code' => 'required|string|digits:5'
        ];
    }

    public function attributes()
    {
        return [
            'code'=>'کد فعال سازی'
        ];

    }
}
