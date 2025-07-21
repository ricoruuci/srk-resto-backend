<?php

namespace App\Http\Requests\Satuan;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'satuan' => 'required|string',
        ];
    }
}
