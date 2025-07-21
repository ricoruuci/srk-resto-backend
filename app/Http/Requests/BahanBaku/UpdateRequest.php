<?php

namespace App\Http\Requests\BahanBaku;

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
            'bahan_baku_id' => 'required|string',
            'bahan_baku_name' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'group_bahan_baku_id' => 'required|string',
        ];
    }
}
