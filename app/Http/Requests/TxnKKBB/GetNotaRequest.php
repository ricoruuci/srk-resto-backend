<?php

namespace App\Http\Requests\TxnKKBB;

use Illuminate\Foundation\Http\FormRequest;

class GetNotaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'actor' => 'required|string',
            'transdate' => 'required|string'
        ];
    }
}
