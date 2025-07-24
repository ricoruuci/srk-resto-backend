<?php

namespace App\Http\Requests\RptFinance;

use Illuminate\Foundation\Http\FormRequest;

class GetRequestNeraca extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'periode' => 'required|date_format:Ymd'
        ];
    }
}
