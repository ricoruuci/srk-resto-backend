<?php

namespace App\Http\Requests\Beli;

use Illuminate\Foundation\Http\FormRequest;

class GetRequestById extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nota_beli' => 'required|string',
        ];
    }
}
