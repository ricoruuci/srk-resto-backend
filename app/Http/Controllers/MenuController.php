<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupMenu;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ArrayPaginator;
use App\Traits\HttpResponse;
use App\Http\Requests\Menu\InsertRequest;
use App\Http\Requests\Menu\UpdateRequest;
use App\Http\Requests\Menu\DeleteRequest;
use App\Http\Requests\Menu\GetRequest;
use App\Http\Requests\Menu\GetRequestById;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    use ArrayPaginator, HttpResponse;

    public function getListMenuPenjualan(Request $request)
    {
        $group_model = new GroupMenu();

        $menu_model = new Menu();

        $params =[
            'search_keyword' => $request->search_keyword ?? '',
        ];

        $result = $group_model->getAllData($params);

        foreach ($result as $item) {

            $group_result = $menu_model->getDataByGroupMenuId($item->group_menu_id);

            if (isset($group_result)) {
                // foreach ($group_result as $menuItem) {
                //     if (isset($menuItem->item_picture)) {
                //         $menuItem->item_picture = base64_encode($menuItem->item_picture);
                //     }
                // }

                $item->items = $group_result;
            } else {
                $item->items = [];
            }

        }

        $resultPaginated = $this->arrayPaginator($request, $result);

        return $this->responsePagination($resultPaginated);

    }

    public function getDataById(GetRequestById $request)
    {
        $menu_model = new Menu();

        $id = $request->menu_id;

        $cek = $model->cekData($request->menu_id);
        if ($cek == false) {
            return $this->responseError('Menu tidak ditemukan', 404);
        }

        $result = $menu_model->getDataById($id);

        return $this->responseData($result);
    }

    public function insertData(InsertRequest $request)
    {
        $model = new Menu();

        
        DB::beginTransaction();
        
        try {
            $autonumber = $model->beforeAutoNumber();
            
            $params = [
                'menu_id' => $autonumber,
                'menu_name' => $request->menu_name,
                'price' => $request->price,
                'fg_item' => $request->fg_item,
                'group_menu_id' => $request->group_menu_id,
                'item_picture' => $request->item_picture ?? null,
                'upduser' => Auth::user()->currentAccessToken()['namauser'],
            ];

            $insertResult = $model->insertData($params);

            if ($insertResult == false) {
                return $this->responseError('Gagal menyimpan data menu', 500);
            }

            DB::commit();
            return $this->responseSuccess('Data menu berhasil disimpan', 200, ['menu_id' => $autonumber]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseError('Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    public function updateData(UpdateRequest $request)
    {
        $model = new Menu();

        $params = [
            'menu_id' => $request->menu_id,
            'menu_name' => $request->menu_name,
            'price' => $request->price,
            'fg_item' => $request->fg_item,
            'group_menu_id' => $request->group_menu_id,
            'item_picture' => $request->item_picture ?? null,
            'upduser' => Auth::user()->currentAccessToken()['namauser'],
        ];

        $cek = $model->cekData($request->menu_id);
        if ($cek == false) {
            return $this->responseError('Menu tidak ditemukan', 404);
        }

        DB::beginTransaction();

        try {
            $updateResult = $model->updateData($params);

            if ($updateResult == false) {
                return $this->responseError('Gagal memperbarui data menu', 500);
            }

            DB::commit();
            return $this->responseSuccess('Data menu berhasil diperbarui', 200, ['menu_id' => $request->menu_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseError('Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    public function deleteData(DeleteRequest $request)
    {
        $model = new Menu();

        $id = $request->menu_id;

        $cek = $model->cekData($request->menu_id);
        if ($cek == false) {
            return $this->responseError('Menu tidak ditemukan', 404);
        }

        DB::beginTransaction();

        try {
            $deleteResult = $model->deleteData($id);

            if ($deleteResult == false) {
                return $this->responseError('Gagal menghapus data menu', 500);
            }

            DB::commit();
            return $this->responseSuccess('Data menu berhasil dihapus',200, ['menu_id' => $id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseError('Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    public function getListData(GetRequest $request)
    {
        $menu_model = new Menu();

        $params = [
            'search_keyword' => $request->search_keyword ?? '',
        ];

        $result = $menu_model->getAllData($params);

        $resultPaginated = $this->arrayPaginator($request, $result);

        return $this->responsePagination($resultPaginated);

    }

}

?>
