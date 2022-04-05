<?php

namespace Authenticate\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IssueTokenRequest extends FormRequest
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
            'mobile' => 'required|string|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/'
        ];
    }

    public function attributes()
    {
        return [
          'mobile'=>'تلفن همراه'
        ];
    }
}
