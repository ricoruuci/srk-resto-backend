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
            'payment_type' => 'required|in:0,1,2',
            'bank_id' => 'required_if:payment_type,1,2|string',
            'payment_code' => 'nullable|string',
            'payment_card_number' => 'nullable|string',
        ];
    }
}
