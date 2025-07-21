<?php

namespace App\Http\Requests\Jual;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nota_jual' => 'required|string',
            'transdate' => 'required',
            'nomor_meja' => 'required|string',
            'cashier' => 'required|string',
            'note' => 'nullable|string',
            'fgstatus' => 'required|in:0,1,2',
            'detail' => 'nullable|array',
            'detail.*.menu_id' => 'required|string',
            'detail.*.qty' => 'required|numeric|min:0',
            'detail.*.price' => 'required|numeric|min:0',
            'detail.*.note' => 'nullable|string',
        ];
    }
}
