<?php

namespace App\Models\CF\Master; //1

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class CFMsBank extends Model 
{
    use HasFactory;

    protected $table = 'cfmsbank'; 

    public $timestamps = false;

    function getListData()
    {

        $result = DB::select(
            "SELECT bankid,bankname,note,upddate,upduser,fgactive,rekeningid from cfmsbank where fgactive='Y' order by bankname"
        );

        return $result;
    }

    function cekBank($bankid)
    {

        $result = DB::selectOne(
            'SELECT * from cfmsbank WHERE bankid = :bankid',
            [
                'bankid' => $bankid
            ]
        );
        
        return $result;
    }

}

?>