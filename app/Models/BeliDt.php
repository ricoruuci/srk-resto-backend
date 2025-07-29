<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;
use function PHPUnit\Framework\isNull;

class BeliDt extends BaseModel
{
    use HasFactory;

    protected $table = 'trbelibbdt';

    public $timestamps = false;

    function insertData($params)
    {
        $result = DB::insert(
            "INSERT INTO trbelibbdt
            (nota, kdsupplier, kdbb, jml, harga, disc, upddate, upduser, kdsat)
            VALUES
            (:nota, :kdsupplier, :kdbb, :jml, :harga, 0, getdate(), :upduser, :kdsat)",
            [
                'nota' => $params['nota_beli'],
                'kdsupplier' => $params['supplier_id'],
                'kdbb' => $params['bahan_baku_id'],
                'jml' => $params['qty'],
                'harga' => $params['price'],
                'upduser' => $params['upduser'],
                'kdsat' => $params['satuan']
            ]
        );


        return $result;
    }

    function deleteData($id)
    {
        $result = DB::delete(
            "DELETE FROM trbelibbdt where nota = :nota ",
            [
                'nota' => $id
            ]
        );

        return $result;
    }

    function getDataById($id)
    {
        $result = DB::select(
            "SELECT
            a.nota as nota_beli,
            a.kdbb as bahan_baku_id,
            b.nmbb as bahan_baku_name,
            a.jml as qty,
            a.harga as price,
            a.jml*a.harga as total,
            a.kdsat as satuan,
            a.upddate,
            a.upduser
            from trbelibbdt a
            left join msbahanbaku b on a.kdbb=b.kdbb
            where a.nota = :id",
            [
                'id' => $id
            ]
        );

        return $result;
    }

    function deleteAllItem($id)
    {
        $result = DB::delete(
            "DELETE FROM AllItem where VoucherNo= :id",
            [
                'id' => $id
            ]
        );

        return $result;
    }

    function insertAllItem($id)
    {
        $result = DB::insert(
            "INSERT into allitem (transdate,voucherno,itemid,qty,price,fgtrans,warehouseid,actorid,reffid,hpp,upddate,upduser)
            SELECT b.tglbeli,a.nota,a.kdbb,a.jml,a.harga,1,'DL',a.kdsupplier,a.nota,a.harga,getdate(),a.upduser
            from trbelibbdt a
            inner join trbelibbhd b on a.nota=b.nota and a.kdsupplier=b.kdsupplier
            left join msbahanbaku d on a.kdbb=d.kdbb
            where a.nota=:id  ",
            [
                'id' => $id
            ]
        );

        return $result;
    }
    
    function updateAllTransaction($params)
    {
        $result = DB::delete(
            "DELETE FROM AllTransaction where VoucherNo= :id",
            [
                'id' => $params['id']
            ]
        );

        $result = DB::insert(
            "INSERT into AllTransaction (transdate,voucherno,fgtrans)
            SELECT :transdate, :id, :fgtrans ",
            [
                'transdate' => $params['transdate'],
                'id' => $params['id'],
                'fgtrans' => $params['fgtrans'],
            ]
        );

        return $result;
    }

}

?>
