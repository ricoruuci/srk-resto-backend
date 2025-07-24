<?php

namespace App\Http\Requests\RptPembelian;

use Illuminate\Foundation\Http\FormRequest;

class GetLapPembelianRequest extends FormRequest
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
            'search_keyword' => 'nullable|string',
            'supplier_keyword' => 'nullable|string',
        ];
    }
}
