<?php

namespace App\Http\Requests\BahanBaku;

use Illuminate\Foundation\Http\FormRequest;

class GetRequestById extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bahan_baku_id' => 'required|string',
        ];
    }
}
