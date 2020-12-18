<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class GetUserRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'id is required'
        ];
    }
}
