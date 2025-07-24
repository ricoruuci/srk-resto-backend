<?php

namespace App\Http\Requests\RptFinance;

use Illuminate\Foundation\Http\FormRequest;

class GetRequestLabaRugi extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'dari' => 'required|date_format:Ymd',
            'sampai' => 'required|date_format:Ymd',
        ];
    }
}
