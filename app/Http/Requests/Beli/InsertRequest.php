<?php

namespace App\Http\Requests\Beli;

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
            'transdate' => 'required',
            'supplier_id' => 'required|string',
            'ppn' => 'required|numeric|min:0',
            'note' => 'nullable|string',
            'detail' => 'nullable|array',
            'detail.*.bahan_baku_id' => 'required|string',
            'detail.*.qty' => 'required|numeric|min:0',
            'detail.*.price' => 'required|numeric|min:0',
            'detail.*.satuan' => 'required|string',
        ];
    }
}
