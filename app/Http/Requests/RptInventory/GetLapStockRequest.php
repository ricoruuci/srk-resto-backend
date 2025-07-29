<?php

namespace App\Http\Requests\RptInventory;

use Illuminate\Foundation\Http\FormRequest;

class GetLapStockRequest extends FormRequest
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
            'show_zero' => 'nullable|in:Y,T',
        ];
    }
}
