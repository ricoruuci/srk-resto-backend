<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JualDt;
use App\Models\JualHd;
use App\Models\Meja;
use App\Models\Waiter;
use App\Models\Menu;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ArrayPaginator;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Jual\InsertRequest;
use App\Http\Requests\Jual\UpdateRequest;
use App\Http\Requests\Jual\UpdatePaymentRequest;
use App\Http\Requests\Jual\GetRequest;

class JualController extends Controller
{
    use ArrayPaginator, HttpResponse;

    public function insertData(InsertRequest $request)
    {
        $model_header = new JualHd();

        $model_detail = new JualDt();

        $model_meja = new Meja();

        $model_waiter = new Waiter();

        $model_menu = new Menu();

        $cek = $model_meja->cekData($request->nomor_meja ?? '');

        if ($cek == false) {

            return $this->responseError('nomor meja tidak ada atau tidak ditemukan', 400);
        }

        $params = [
            'transdate' => $request->transdate,
            'nomor_meja' => $request->nomor_meja,
            'cashier' => Auth::user()->currentAccessToken()['namauser'],
            'note' => $request->note ?? '',
            'upduser' => Auth::user()->currentAccessToken()['namauser'],
        ];

        DB::beginTransaction();

        try {
            $hasilpoid = $model_header->beforeAutoNumber($request->transdate);

            $params['nota_jual'] = $hasilpoid;

            $insertheader = $model_header->insertData($params);

            if ($insertheader == false) {
                DB::rollBack();

                return $this->responseError('insert header gagal', 400);
            }

            $arrDetail = $request->input('detail');

            if (empty($arrDetail) || !is_array($arrDetail)) {
                DB::rollBack();

                return $this->responseError('detail tidak boleh kosong', 400);
            }

            for ($i = 0; $i < sizeof($arrDetail); $i++) {

                $cek = $model_menu->cekData($arrDetail[$i]['menu_id'] ?? '');

                if ($cek == false) {
                    DB::rollBack();

                    return $this->responseError('menu tidak ada atau tidak ditemukan', 400);
                }

                $insertdetail = $model_detail->insertData([
                    'nota_jual' => $hasilpoid,
                    'menu_id' => $arrDetail[$i]['menu_id'],
                    'urut' => $i + 1,
                    'note' => $arrDetail[$i]['note'],
                    'qty' => $arrDetail[$i]['qty'],
                    'price' => $arrDetail[$i]['price'],
                    'upduser' => Auth::user()->currentAccessToken()['namauser']
                ]);

                if ($insertdetail == false) {
                    DB::rollBack();

                    return $this->responseError('insert detail gagal', 400);
                }
            }

            $hitung = $model_header->hitungTotal($hasilpoid);

            $model_header->updateTotal([
                'grand_total' => $hitung->grandtotal,
                'sub_total' => $hitung->subtotal,
                'total_ppn' => $hitung->pajak,
                'nota_jual' => $hasilpoid,
            ]);

            $model_detail->deleteAllItem($hasilpoid);

            $model_detail->insertAllItem($hasilpoid);

            DB::commit();

            return $this->responseSuccess('insert berhasil', 200, ['nota_jual' => $hasilpoid]);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->responseError($e->getMessage(), 400);
        }

    }

    public function UpdateData(UpdateRequest $request)
    {
        $model_header = new JualHd();

        $model_detail = new JualDt();

        $model_meja = new Meja();

        $model_waiter = new Waiter();

        $model_menu = new Menu();

        $cek = $model_header->cekData($request->nota_jual ?? '');

        if ($cek == false) {

            return $this->responseError('nota jual tidak ada atau tidak ditemukan', 400);
        }

        $cek = $model_meja->cekData($request->nomor_meja ?? '');

        if ($cek == false) {

            return $this->responseError('nomor meja tidak ada atau tidak ditemukan', 400);
        }

        $params = [
            'nota_jual' => $request->nota_jual,
            'transdate' => $request->transdate,
            'nomor_meja' => $request->nomor_meja,
            'cashier' => Auth::user()->currentAccessToken()['namauser'],
            'note' => $request->note ?? '',
            'upduser' => Auth::user()->currentAccessToken()['namauser'],
        ];

        DB::beginTransaction();

        try {

            $insertheader = $model_header->updateData($params);

            if ($insertheader == false) {
                DB::rollBack();

                return $this->responseError('update header gagal', 400);
            }

            $arrDetail = $request->input('detail');

            if (empty($arrDetail) || !is_array($arrDetail)) {
                DB::rollBack();

                return $this->responseError('detail tidak boleh kosong', 400);
            }

            $model_detail->deleteData($request->nota_jual);

            for ($i = 0; $i < sizeof($arrDetail); $i++) {

                $cek = $model_menu->cekData($arrDetail[$i]['menu_id'] ?? '');

                if ($cek == false) {
                    DB::rollBack();

                    return $this->responseError('menu tidak ada atau tidak ditemukan', 400);
                }

                $insertdetail = $model_detail->insertData([
                    'nota_jual' => $request->nota_jual,
                    'menu_id' => $arrDetail[$i]['menu_id'],
                    'urut' => $i + 1,
                    'note' => $arrDetail[$i]['note'],
                    'qty' => $arrDetail[$i]['qty'],
                    'price' => $arrDetail[$i]['price'],
                    'upduser' => Auth::user()->currentAccessToken()['namauser']
                ]);

                if ($insertdetail == false) {
                    DB::rollBack();

                    return $this->responseError('update detail gagal', 400);
                }
            }

            $hitung = $model_header->hitungTotal($request->nota_jual);

            $model_header->updateTotal([
                'grand_total' => $hitung->grandtotal,
                'sub_total' => $hitung->subtotal,
                'total_ppn' => $hitung->pajak,
                'nota_jual' => $request->nota_jual,
            ]);

            $model_detail->deleteAllItem($request->nota_jual);

            $model_detail->insertAllItem($request->nota_jual);

            DB::commit();

            return $this->responseSuccess('update berhasil', 200, ['nota_jual' => $request->nota_jual]);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->responseError($e->getMessage(), 400);
        }

    }

    public function UpdatePayment(UpdatePaymentRequest $request)
    {
        $model_header = new JualHd();

        $cek = $model_header->cekData($request->nota_jual);

        if ($cek == false) {

            return $this->responseError('nota jual tidak ada atau tidak ditemukan', 400);
        }

        $params = [
            'nota_jual' => $request->nota_jual,
            'paytype' => $request->payment_type ?? 3,
        ];
        // dd($params);
        if ($request->payment_type == 1 || $request->payment_type == 2) {

            $model_bank = new Bank();

            $cek = $model_bank->cekData($request->bank_id ?? '');

            if ($cek == false) {

                return $this->responseError('bank tidak ada atau tidak ditemukan', 400);
            }
        }

        DB::beginTransaction();

        try {

            $insertheader = $model_header->updatePayment($params);

            if ($insertheader == false) {
                DB::rollBack();

                return $this->responseError('update header gagal', 400);
            }

            DB::commit();

            return $this->responseSuccess('update berhasil', 200, ['nota_jual' => $request->nota_jual]);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->responseError($e->getMessage(), 400);
        }

    }

    public function getListData(GetRequest $request)
    {
        $model_header = new JualHd();

        $model_detail = new JualDt();

        $result = $model_header->getDataById($request->nota_jual ?? '');

        if ($result) {
            $header = $result;

            $detail_result = $model_detail->getDataById($result->nota_jual ?? '');

            $detail = !empty($detail_result) ? $detail_result : [];
        }
        else {
            $header = [];
            $detail = [];
        }

        $response = [
            'header' => $header,
            'detail' => $detail,
        ];

        return $this->responseData($response);

    }

    public function getDataMeja(Request $request)
    {
        $model = new JualHd();

        $result = $model->getDataMeja();

        $resultPaginated = $this->arrayPaginator($request, $result);

        return $this->responsePagination($resultPaginated);

    }

}

?>
