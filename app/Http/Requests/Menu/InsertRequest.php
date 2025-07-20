<?php

namespace App\Http\Requests\Menu;

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
            'menu_name' => 'required|string',
            'price' => 'required|numeric',
            'fg_item' => 'required|in:A,B',
            'group_menu_id' => 'required|string',
            'item_picture' => 'nullable|string',
        ];
    }
}
