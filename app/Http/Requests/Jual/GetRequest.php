<?php

namespace App\Http\Requests\Jual;

use Illuminate\Foundation\Http\FormRequest;

class GetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nota_jual' => 'required|string',
        ];
    }
}
