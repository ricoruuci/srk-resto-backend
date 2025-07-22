<?php

namespace App\Http\Requests\TxnKKBB;

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
            'dari' => 'required|date_format:Ymd',
            'sampai' => 'required|date_format:Ymd',
            'flagkkbb' => 'required|string|in:KM,KK,BM,BK,JU,APB,APK',
            'search_keyword' => 'nullable|string',
            'bank_id' => 'nullable|string',
            'actor_keyword' => 'nullable|string',
            'voucher_keyword' => 'nullable|string',
            'sort_by' => 'nullable|string|in:new,old',
        ];
    }
}
