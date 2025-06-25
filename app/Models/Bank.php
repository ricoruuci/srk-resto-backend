<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;
use function PHPUnit\Framework\isNull;

class Bank extends BaseModel
{
    use HasFactory;

    protected $table = 'cfmsbank';

    public $timestamps = false;

    function getAllData()
    {
        $result = DB::select(
            "SELECT a.bankid as bank_id, a.bankname as bank_name,
            a.rekeningid as rekening_id, b.rekeningname as rekening_name,
            a.note, a.upduser, a.upddate
            from cfmsbank a
            left join cfmsrekening b on a.rekeningid=b.rekeningid
            where a.fgactive='Y' order by a.bankname "
        );

        return $result;
    }

    function cekData($id)
    {

        $result = DB::selectOne(
            'SELECT * from CFMsBank WHERE bankid = :id',
            [
                'id' => $id
            ]
        );

        return $result;
    }

}

?>
