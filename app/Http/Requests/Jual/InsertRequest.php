<?php

namespace App\Http\Requests\Jual;

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
            'nomor_meja' => 'required|string',
            'cashier' => 'required|string',
            'note' => 'nullable|string',
            'detail' => 'nullable|array',
            'detail.*.menu_id' => 'required|string',
            'detail.*.qty' => 'required|numeric|min:0',
            'detail.*.price' => 'required|numeric|min:0',
            'detail.*.note' => 'nullable|string',
        ];
    }
}
