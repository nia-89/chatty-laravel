<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{

    public function rules()
    {
        return [
            'file'=>'required|mimes:txt'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Please select a .txt file'
        ];
    }
}
