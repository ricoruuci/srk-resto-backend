<?php

namespace App\Http\Controllers\AR\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AR\Master\ARMsSales;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ArrayPaginator;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    use ArrayPaginator, HttpResponse;

    public function insertData(Request $request)
    {

        $sales = new ARMsSales();

        $validator = Validator::make($request->all(), $sales::$rulesInsert);

        if ($validator->fails())
        {
            return $this->responseError($validator->messages(), 400);
        }
        else
        {

            $kodesales = $sales->beforeAutoNumber($request->input('salesname')); 

            DB::beginTransaction();

            try 
            {
                $insert = $sales->insertData([
                    'salesid' => $kodesales,
                    'salesname' => $request->input('salesname'),
                    'address' => $request->input('address'),
                    'phone' => $request->input('phone'),
                    'hp' => $request->input('hp'),
                    'email' => $request->input('email'),
                    'note' => $request->input('note'),
                    'upduser' => Auth::user()->currentAccessToken()['namauser'],
                    'jabatan' => $request->input('jabatan'),
                    'uangmakan' => $request->input('uangmakan'),
                    'uangbulanan' => $request->input('uangbulanan'),
                    'fgactive' => $request->input('fgactive'),
                    'tglgabung' => $request->input('tglgabung'),
                    'limitkasbon' => $request->input('limitkasbon'),
                    'kerajinan' => $request->input('kerajinan'),
                    'tomzet' => $request->input('tomzet'),
                    'kom1' => $request->input('kom1'),
                    'kom2' => $request->input('kom2'),
                    'kom3' => $request->input('kom3'),
                    'kom4' => $request->input('kom4')
                ]);

                if ($insert)
                {   
                    DB::commit();

                    return $this->responseSuccess('insert berhasil', 200, [ 'salesid' => $kodesales ]);
                }
                else
                {
                    DB::rollBack();

                    return $this->responseError('insert gagal', 400);
                }

            } 
            catch (\Exception $e)
            {
                DB::rollBack();

                return $this->responseError($e->getMessage(), 400);
            }

        }

    }

    public function getListData(Request $request)
    {
        $sales = new ARMsSales();

        $result = $sales->getListData();

        $resultPaginated = $this->arrayPaginator($request, $result);

        return $this->responsePagination($resultPaginated);

    }

    public function getData(Request $request, $salesid)
    {
        $sales = new ARMsSales();

        $result = $sales->getdata(
            [
                'salesid' => $salesid
            ]
        );

        return $this->responseData($result);

    }

    public function updateAllData(Request $request, $salesid)
    {
        $sales = new ARMsSales();

        $validator = Validator::make($request->all(), $sales::$rulesUpdateAll);

        if ($validator->fails())
        {
            return $this->responseError($validator->messages(), 400);
        }
        else
        {
            
            $cek = $sales->cekSales($salesid);
            
            if($cek==false){

                return $this->responseError('kode sales tidak terdaftar dalam master', 400);
            }

            DB::beginTransaction();

            try 
            {
                $updated = $sales->updateAllData([
                    'salesid' => $salesid,
                    'salesname' => $request->input('salesname'),
                    'address' => $request->input('address'),
                    'phone' => $request->input('phone'),
                    'hp' => $request->input('hp'),
                    'email' => $request->input('email'),
                    'note' => $request->input('note'),
                    'upduser' => Auth::user()->currentAccessToken()['namauser'],
                    'jabatan' => $request->input('jabatan'),
                    'uangmakan' => $request->input('uangmakan'),
                    'uangbulanan' => $request->input('uangbulanan'),
                    'fgactive' => $request->input('fgactive'),
                    'tglgabung' => $request->input('tglgabung'),
                    'limitkasbon' => $request->input('limitkasbon'),
                    'kerajinan' => $request->input('kerajinan'),
                    'tomzet' => $request->input('tomzet'),
                    'kom1' => $request->input('kom1'),
                    'kom2' => $request->input('kom2'),
                    'kom3' => $request->input('kom3'),
                    'kom4' => $request->input('kom4')                  
                ]);

                if ($updated)
                {   
                    DB::commit();

                    return $this->responseSuccess('update berhasil', 200, [ 'salesid' => $salesid ]);
                }
                else
                {
                    DB::rollBack();

                    return $this->responseError('update gagal', 400);
                }
            } 
            catch (\Exception $e)
            {
                DB::rollBack();

                return $this->responseError($e->getMessage(), 400);
            }

            
        }

    }
    
    public function deleteData(Request $request, $salesid)
    {
        $sales = new ARMsSales();

        $cek = $sales->cekSales($salesid);
            
        if($cek==false){

            return $this->responseError('kode sales tidak terdaftar dalam master', 400);
        }
        
        DB::beginTransaction();

        try 
        {
            $deleted = $sales->deleteData([
                'salesid' => $salesid
            ]);

            if ($deleted)
            {   
                DB::commit();

                return $this->responseSuccess('delete berhasil', 200, [ 'salesid' => $salesid ]);
            }
            else
            {
                DB::rollBack();

                return $this->responseError('delete gagal', 400);
            }
        } 
        catch (\Exception $e)
        {
            DB::rollBack();

            return $this->responseError($e->getMessage(), 400);
        }
    }
}

?>