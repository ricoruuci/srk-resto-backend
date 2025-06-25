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
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    use ArrayPaginator, HttpResponse;

    public function getListData(Request $request)
    {
        $group_model = new GroupMenu();

        $menu_model = new Menu();

        $result = $group_model->getAllData();

        foreach ($result as $item) {

            $group_result = $menu_model->getDataById($item->kdgroupmenu);

            if (isset($group_result)) {
                foreach ($group_result as $menuItem) {
                    if (isset($menuItem->item_picture)) {
                        $menuItem->item_picture = base64_encode($menuItem->item_picture);
                    }
                }

                $item->items = $group_result;
            } else {
                $item->items = [];
            }

        }

        $resultPaginated = $this->arrayPaginator($request, $result);

        return $this->responsePagination($resultPaginated);

    }

}

?>
