<?php

namespace App\Http\Requests\Jual;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nota_jual' => 'required|string',
            'payment_type' => 'required|in:0,1,2,3',
            'bank_id'      => 'required_if:payment_type,0,1,2|string|nullable',
        ];
    }
}
