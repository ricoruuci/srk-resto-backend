<?php

namespace App\Http\Requests\RptPenjualan;

use Illuminate\Foundation\Http\FormRequest;

class GetLapPenjualanHarianRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'transdate' => 'required|date_format:Ymd',
        ];
    }
}
