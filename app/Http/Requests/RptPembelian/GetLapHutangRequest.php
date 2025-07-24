<?php

namespace App\Http\Requests\RptPembelian;

use Illuminate\Foundation\Http\FormRequest;

class GetLapHutangRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'transdate' => 'required|date_format:Ymd',
            'search_keyword' => 'nullable|string',
            'supplier_keyword' => 'nullable|string',
        ];
    }
}
