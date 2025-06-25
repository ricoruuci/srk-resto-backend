<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ArrayPaginator;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    use ArrayPaginator, HttpResponse;

    public function getListData(Request $request)
    {
        $model = new Bank();

        $result = $model->getAllData();

        $resultPaginated = $this->arrayPaginator($request, $result);

        return $this->responsePagination($resultPaginated);

    }

}

?>
