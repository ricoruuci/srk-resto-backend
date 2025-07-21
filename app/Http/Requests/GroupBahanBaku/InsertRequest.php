<?php

namespace App\Http\Requests\GroupBahanBaku;

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
            'group_bahan_baku_name' => 'required|string|max:255',
        ];
    }
}
