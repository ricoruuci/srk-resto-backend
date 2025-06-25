<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;
use function PHPUnit\Framework\isNull;

class JualDt extends BaseModel
{
    use HasFactory;

    protected $table = 'trjualdt';

    public $timestamps = false;

    function insertData($params)
    {
        $result = DB::insert(
            "INSERT INTO trjualdt
            (nota, nodetil, kdmenu, jumlah, harga, disc, discfrom, upddate, upduser, fgprint)
            VALUES
            (:nota, :urut, :kdmenu, :qty, :price, 0, 'H', getdate(), :upduser, 0)",
            [
                'nota' => $params['nota_jual'],
                'urut' => $params['urut'],
                'kdmenu' => $params['menu_id'],
                'qty' => $params['qty'],
                'price' => $params['price'],
                'upduser' => $params['upduser']
            ]
        );


        return $result;
    }

    function deleteData($id)
    {
        $result = DB::delete(
            "DELETE FROM trjualdt where nota = :nota",
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
            a.nota as nota_jual,
            a.kdmenu as menu_id,
            b.nmmenu as menu_name,
            a.jumlah as qty,
            a.harga as price,
            a.jumlah*a.harga as total,
            isnull(a.keterangan,'') as note,
            a.upddate,
            a.upduser
            from trjualdt a
            left join msmenuhd b on a.kdmenu=b.kdmenu
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
            "DELETE FROM AllBB where Nota= :id",
            [
                'id' => $id
            ]
        );

        return $result;
    }

    function insertAllItem($id)
    {
        $result = DB::insert(
            "INSERT into allbb (kode, bukti, tanggal, nota, kdbb, kdmenu, jumlah, harga, kdsat, kdpos, jmlasli, jumsat, satasli)
            SELECT 4,a.nodetil,b.tgljual,a.nota,c.kdbb,a.kdmenu,a.jumlah*c.jumlah*(case when c.kdsat=d.satbesar then d.jumsat else 1 end),0,
            d.satkecil,b.kdpos,a.jumlah*c.jumlah,d.jumsat,c.kdsat
            from trjualdt a
            inner join trjualhd b on a.nota=b.nota
            left join msmenudt c on a.kdmenu=c.kdmenu
            left join msbahanbaku d on c.kdbb=d.kdbb
            where a.nota=:id ",
            [
                'id' => $id
            ]
        );

        return $result;
    }

}

?>
