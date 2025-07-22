<?php

namespace App\Http\Requests\TxnKKBB;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'voucher_id' => 'required|string',
        ];
    }
}
