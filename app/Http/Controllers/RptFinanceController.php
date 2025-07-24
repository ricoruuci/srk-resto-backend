<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RptFinance;
use App\Models\Rekening;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ArrayPaginator;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RptFinance\GetRequestBukuBesar;
use App\Http\Requests\RptFinance\GetRequestLabaRugi;
use App\Http\Requests\RptFinance\GetRequestNeraca;

class RptFinanceController extends Controller
{
    use ArrayPaginator, HttpResponse;

    public function getRptBukuBesar(GetRequestBukuBesar $request)
    {
        $model = new RptFinance();
        $rekening = new Rekening();

        $rekeningId = $request->input('rekening_id');

        if ($rekeningId !== null && $rekeningId !== '') {
            $cek = $rekening->cekData($rekeningId);
            if ($cek == false) {
                return $this->responseError('Rekening not found', 404);
            }
        }

        $result = $model->getRptBukuBesar([
            'dari' => $request->input('dari'),
            'sampai' => $request->input('sampai'),
            'rekening_id' => $request->input('rekening_id', '')
        ]);

        return $this->responseData($result);
    }

    public function getRptLabaRugi(GetRequestLabaRugi $request)
    {
        $model = new RptFinance();

        $result = $model->getRptLabaRugi([
            'dari' => $request->input('dari'),
            'sampai' => $request->input('sampai')
        ]);

        return $this->responseData($result);
    }

    public function getRptNeraca(GetRequestNeraca $request)
    {
        $model = new RptFinance();

        $result = $model->getRptNeraca([
            'periode' => $request->input('periode')
        ]);

        return $this->responseData($result);
    }

}

?>
