<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RptPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ArrayPaginator;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RptPenjualan\GetLapPenjualanRequest;
use App\Http\Requests\RptPenjualan\GetLapPenjualanHarianRequest;

class RptPenjualanController extends Controller
{
    use ArrayPaginator, HttpResponse;

    public function getLapPenjualan(GetLapPenjualanRequest $request)
    {
        $model = new RptPenjualan();

        $result = $model->getLapPenjualan([
            'dari' => $request->input('dari'),
            'sampai' => $request->input('sampai'),
            'search_keyword' => $request->input('search_keyword', '')
        ]);

        $resultPaginated = $this->arrayPaginator($request, $result);

        return $this->responsePagination($resultPaginated);
    }

    public function getLapPenjualanHarian(GetLapPenjualanHarianRequest $request)
    {
        $model = new RptPenjualan();

        $result = $model->getLapPenjualanHarian($request->input('transdate'));

        return $this->responseData($result);
    }

}

?>
