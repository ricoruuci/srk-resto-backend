<?php

namespace App\Http\Requests\SetRekening;

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
            'rek_pembelian' => 'required|string',
            'rek_penjualan' => 'required|string',
            'rek_ppn_beli' => 'required|string',
            'rek_ppn_jual' => 'required|string',
            'rek_hutang' => 'required|string',
            'rek_piutang' => 'required|string',
            'rek_kas' => 'required|string',
            'rek_laba' => 'required|string',
        ];
    }
}
