<?php

namespace App\Http\Requests\TxnKKBB;

use Illuminate\Foundation\Http\FormRequest;

class InsertRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'transdate' => 'required|date_format:Ymd',
            'actor' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
            'flagkkbb' => 'required|string|in:KM,KK,BM,BK,JU,APK,APB',
            'bank_id' => 'nullable|required_if:flagkkbb,BM,BK,APB|string',
            'total' => 'required|numeric',
            'detail' => 'required|array',
            'detail.*.rekeningid' => 'required|string',
            'detail.*.note' => 'nullable|string|max:255',
            'detail.*.amount' => 'required|numeric',
            'detail.*.jenis' => 'required|string|in:D,K',
        ];
    }
}
