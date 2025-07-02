<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;
use function PHPUnit\Framework\isNull;

class JualHd extends BaseModel
{
    use HasFactory;

    protected $table = 'trjualhd';

    public $timestamps = false;

    function insertData($params)
    {
        $result = DB::insert(
            "INSERT TrJualHD (nota,tgljual,jamjual,ppn,disc,kdpos,waiter,nomeja,jmlorang,
            cashier,fgbayar,fgbatal,keterangan,paytype,disctype,upddate,upduser,charge,fgfromqb,kdmember,fgstatus)
            VALUES (:nota, :transdate, :transdate1, (select top 1 isnull(nmset,0) from setup where kdset='ppn'), 0, 'DL',
            :waiter, :nomeja, 0, :cashier, 'T', 'T', :note, 0, 0, getdate(), :upduser, 0, 'T', '00000', 0) ",
            [
                'nota' => $params['nota_jual'],
                'transdate' => $params['transdate'],
                'transdate1' => $params['transdate'], // Assuming jamjual is the same as transdate
                'waiter' => $params['waiter'],
                'nomeja' => $params['nomor_meja'],
                'cashier' => $params['cashier'],
                'note' => $params['note'],
                'upduser' => $params['upduser']
            ]
        );

        return $result;
    }

    function updateData($params)
    {
        $result = DB::update(
            "UPDATE TrJualHD
            SET
            tgljual = :transdate,
            jamjual = :transdate1,
            waiter = :waiter,
            nomeja = :nomeja,
            cashier = :cashier,
            keterangan = :note,
            upddate = getdate(),
            upduser = :upduser
            WHERE nota = :nota",
            [
                'nota' => $params['nota_jual'],
                'transdate' => $params['transdate'],
                'transdate1' => $params['transdate'],
                'waiter' => $params['waiter'],
                'nomeja' => $params['nomor_meja'],
                'cashier' => $params['cashier'],
                'note' => $params['note'],
                'upduser' => $params['upduser']
            ]
        );

        return $result;
    }

    function updatePayment($params)
    {
        $result = DB::update(
            "UPDATE TrJualHD SET
            PayType = :paytype,
            KdCard = :kdcard,
            NoCard = :nocard,
            BankId = :bankid,
            FgBayar = 'Y'
            WHERE nota = :nota",
            [
                'nota' => $params['nota_jual'],
                'paytype' => $params['paytype'],
                'kdcard' => $params['kdcard'],
                'nocard' => $params['nocard'],
                'bankid' => $params['bank_id']
            ]
        );

        return $result;
    }

    function getDataById($id)
    {
        $result = DB::selectOne(
            "SELECT a.nota as nota_jual,
            a.tgljual as transdate,
            isnull(a.waiter,'') as waiter,
            isnull(a.nomeja,'') as nomor_meja,
            a.cashier as cashier,
            isnull(a.keterangan,'') as note,
            a.ppn as ppn,
            isnull(a.stpj,0) as sub_total,
            isnull(a.ttltax,0) as total_ppn,
            isnull(a.ttlpj,0) as grand_total,
            --a.fgstatus as fg_status,
            --case when a.fgstatus=0 then 'DINE IN' when a.fgstatus=1 then 'TAKE AWAY'  else 'DELIVERY' end as fg_status_name,
            --a.fgbayar as fg_bayar,
            --a.paytype as jenis_bayar,
            --isnull(a.kdcard,'') as card_id,
            --isnull(a.nocard,'') as card_no,
            --a.fgbatal as status_batal,
            a.upddate,
            a.upduser
            from trjualhd a
            left join msposisi b on a.kdpos=b.kdpos
            where a.nota = :id",
            [
                'id' => $id
            ]
        );

        return $result;
    }

    function getDataMeja()
    {
        $result = DB::select(
            "SELECT distinct isnull(b.nomeja,'') as nomor_meja,b.nota as nota_jual from trjualhd b
            where convert(varchar(8),b.tgljual,112) = convert(varchar(8),getdate(),112) and b.fgbayar='T'
            order by isnull(b.nomeja,'') "
        );

        return $result;
    }

    function hitungTotal($id)
    {
        $result = DB::selectOne(
            "SELECT subtotal,  diskon
            ,(subtotal - diskon) * charge / 100 as sc
            ,(subtotal - diskon + ((subtotal - diskon) * charge / 100)) * ppn / 100 as pajak
            ,subtotal + ((subtotal - diskon + ((subtotal - diskon) * charge / 100)) * ppn / 100) - diskon + ((subtotal - diskon) * charge / 100) as grandtotal
            from
            (
            select sum(a.jumlah*a.harga) as subtotal
            ,sum(a.jumlah*a.harga*a.disc/100)  as diskon
            , b.disc, b.ppn, b.charge
            from trjualdt a
            inner join trjualhd b on a.nota=b.nota
            where a.nota=:id
            group by b.disc, b.ppn, b.charge
            ) a",
            [
                'id' => $id
            ]
        );

        return $result;
    }

    function updateTotal($params)
    {
        $result = DB::update(
            "UPDATE trjualhd
            SET stpj = :subtotal,
            ttlpj = :grandtotal,
            ttltax = :pajak
            where nota=:id ",
            [
                'subtotal' => $params['sub_total'],
                'grandtotal' => $params['grand_total'],
                'pajak' => $params['total_ppn'],
                'id' => $params['nota_jual']
            ]
        );

        return $result;
    }

    function cekData($id)
    {

        $result = DB::selectOne(
            'SELECT * from trjualhd WHERE nota = :id',
            [
                'id' => $id
            ]
        );

        return $result;
    }

    public function beforeAutoNumber($transdate)
    {
        $autoNumber = $this->autoNumber($this->table, 'nota', $transdate, '0000');

        return $autoNumber;
    }

}

?>
