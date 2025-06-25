<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    public function autoNumber($namatable, $namafield, $formatso, $formatnumber)
    {
        $autonumber = DB::selectOne(
            "select '".$formatso."'+FORMAT(ISNULL((select top 1 RIGHT(".$namafield.",".strlen($formatnumber).") from ".$namatable."
            where ".$namafield." like '%".$formatso."%' order by ".$namafield." desc),0)+1,'".$formatnumber."') as nomor "

            // from ".$namatable." where ".$namafield." like '%".$formatso."%'"
        );

        return $autonumber->nomor;
    }

}
