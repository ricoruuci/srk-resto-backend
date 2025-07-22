<?php

namespace App\Http\Requests\Rekening;

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
            'rekening_id' => 'required|string',
            'rekening_name' => 'required|string|max:255',
            'note' => 'nullable|string|max:500',
            'group_rek_id' => 'required|string|max:50',
        ];
    }
}
