<?php

namespace App\Http\Requests\RptInventory;

use Illuminate\Foundation\Http\FormRequest;

class GetLapKartuStockRequest extends FormRequest
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
            'search_keyword' => 'nullable|string'
        ];
    }
}
