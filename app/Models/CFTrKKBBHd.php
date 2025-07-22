<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

use function PHPUnit\Framework\isNull;

class CFTrKKBBHd extends BaseModel //nama class
{
    use HasFactory;

    protected $table = 'cftrkkbbhd'; //sesuaiin nama tabel

    public $timestamps = false;

    public function insertData($param)
    {

        $result = DB::insert(
            "INSERT INTO cftrkkbbhd
            (voucherid,transdate,actor,bankid,note,flagkkbb,upddate,upduser,currid,total) 
            VALUES 
            (:voucherid,:transdate,:actor,:bankid,:note,:flagkkbb,getDate(),:upduser,:currid,:total)", 
            [
            'voucherid' => $param['voucherid'],
            'transdate' => $param['transdate'],
            'actor' => $param['actor'],
            'bankid' => $param['bankid'],
            'note' => $param['note'],
            'flagkkbb' => $param['flagkkbb'],
            'upduser' => $param['upduser'],
            'currid' => $param['currid'],
            'total' => $param['total']
            ]
        );        

        return $result;
    }

    function getListData($param)
    {
        if ($param['sortby'] == 'new') {
            $order = 'DESC';
        } else {
            $order = 'ASC';
        }
        $result = DB::select(
            "SELECT 
            case when a.flagkkbb in ('apb','arb','bm','bk') then 'Y' else 'T' end as txnbank,
            case when a.FlagKKBB in ('ark','arc','arb','apk','apb','apc') then 'T'
	        when a.FlagKKBB in ('ju') then 'X' else 'Y' end as userinput,
            case when a.FlagKKBB in ('arc','apc') then 'Y' else 'T' end as dualtgl, 
            a.voucherid as voucher_id,a.transdate,a.actor,
            case when a.FlagKKBB in ('ark','arb','arc') then (select x.custname from MsCustomer x where x.custid=a.actor)
                 when a.FlagKKBB in ('apk','apb','apc') then (select x.NmSupplier from MsSupplier x where x.KdSupplier=a.actor)
                 else a.actor end as actor_name,
            a.bankid,a.note,a.upddate,a.upduser,a.total
            from cftrkkbbhd a 
			where 
			convert(varchar(10),a.transdate,112) between :dari and :sampai and a.flagkkbb=:flagkkbb 
            and isnull(a.bankid,'') like :bankid and isnull(a.actor,'') like :actorkeyword and a.voucherid like :voucherkeyword 
            order by a.transdate $order",
            [
                'dari' => $param['dari'],
                'sampai' => $param['sampai'],
                'flagkkbb' => $param['flagkkbb'],
                'bankid' => '%' . $param['bankid'] . '%',
                'actorkeyword' => '%' . $param['actorkeyword'] . '%',
                'voucherkeyword' => '%' . $param['voucherkeyword'] . '%',
            ]
        );

        return $result;
    }

    function getData($param)
    {
        $result = DB::selectOne(
            "SELECT 
            case when a.flagkkbb in ('apb','arb','bm','bk') then 'Y' else 'T' end as txnbank,
            case when a.FlagKKBB in ('ark','arc','arb','apk','apb','apc') then 'T'
	        when a.FlagKKBB in ('ju') then 'X' else 'Y' end as userinput,
            case when a.FlagKKBB in ('arc','apc') then 'Y' else 'T' end as dualtgl, 
            a.voucherid as voucher_id,a.transdate,a.actor,
            case when a.FlagKKBB in ('ark','arb','arc') then (select x.custname from MsCustomer x where x.custid=a.actor)
                 when a.FlagKKBB in ('apk','apb','apc') then (select x.NmSupplier from MsSupplier x where x.KdSupplier=a.actor)
                 else a.actor end as actor_name,
            a.bankid,a.note,a.upddate,a.upduser,a.total
            from cftrkkbbhd a 
			WHERE a.voucherid = :voucherid ",
            [
                'voucherid' => $param['voucherid']
            ]
        );

        return $result;
    }

    function updateAllData($param)
    {
        $result = DB::update(
            'UPDATE cftrkkbbhd SET 
                transdate = :transdate,
                actor = :actor,
                bankid = :bankid,
                note = :note,
                currid = :currid,
                total = :total
            WHERE voucherid = :voucherid ',
            [
            'voucherid' => $param['voucherid'],
            'transdate' => $param['transdate'],
            'actor' => $param['actor'],
            'bankid' => $param['bankid'],
            'note' => $param['note'],
            'currid' => $param['currid'],
            'total' => $param['total']
            ]
        );

        return $result;
    }


    function deleteData($id)
    {

        $result = DB::delete(
            'DELETE FROM cftrkkbbhd WHERE voucherid = :voucherid',
            [
                'voucherid' => $id
            ]
        );

        return $result;
    }

    function cekVoucher($voucherid)
    {
        $result = DB::selectOne(
            'SELECT * from cftrkkbbhd WHERE voucherid = :voucherid',
            [
                'voucherid' => $voucherid
            ]
        );

        return $result;
    }

    public function beforeAutoNumber($fgtrans, $transdate)
    {

        $year = substr($transdate, 2, 2);
        $month = substr($transdate, 4, 2);

        $autoNumber = $this->autoNumber($this->table, 'voucherid', $fgtrans.'/'.$year.'/'.$month.'-', '0000');

        return $autoNumber;
    }
}
