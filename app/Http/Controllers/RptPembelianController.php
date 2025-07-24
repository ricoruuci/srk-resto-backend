<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RptPembelian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ArrayPaginator;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RptPembelian\GetLapPembelianRequest;
use App\Http\Requests\RptPembelian\GetLapHutangRequest;

class RptPembelianController extends Controller
{
    use ArrayPaginator, HttpResponse;

    public function getLapPembelian(GetLapPembelianRequest $request)
    {
        $model = new RptPembelian();

        $result = $model->getLapPembelian([
            'dari' => $request->input('dari'),
            'sampai' => $request->input('sampai'),
            'search_keyword' => $request->input('search_keyword', ''),
            'supplier_keyword' => $request->input('supplier_keyword', '')
        ]);

        $resultPaginated = $this->arrayPaginator($request, $result);

        return $this->responsePagination($resultPaginated);
    }

    public function getLapHutang(GetLapHutangRequest $request)
    {
        $model = new RptPembelian();

        $result = $model->getLapHutang([
            'transdate' => $request->input('transdate'),
            'search_keyword' => $request->input('search_keyword', ''),
            'supplier_keyword' => $request->input('supplier_keyword', '')
        ]);

        $resultPaginated = $this->arrayPaginator($request, $result);

        return $this->responsePagination($resultPaginated);
    }

}

?>
