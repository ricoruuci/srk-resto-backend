<?php

namespace App\Models\CF\Master; //1

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class CFMsRekening extends Model //nama class
{
    use HasFactory;

    protected $table = 'cfmsrekening'; 

    public $timestamps = false;

    function getListData()
    {
        $result = DB::select(
            "SELECT rekeningid,rekeningname,grouprekid,note,upddate,upduser,tipe,fgtipe,lbrg,fgactive from cfmsrekening where fgactive='Y' order by grouprekid,rekeningid"
        );

        return $result;
    }

    function cekRekening($rekeningid)
    {

        $result = DB::selectOne(
            'SELECT * from cfmsrekening WHERE rekeningid = :rekeningid',
            [
                'rekeningid' => $rekeningid
            ]
        );
        
        return $result;
    }

}

?>