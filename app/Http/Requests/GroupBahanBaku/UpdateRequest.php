<?php

namespace App\Http\Requests\GroupBahanBaku;

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
            'group_bahan_baku_id' => 'required|string',
            'group_bahan_baku_name' => 'required|string|max:255',
        ];
    }
}
