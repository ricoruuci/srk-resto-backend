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

    public function queryAccounting()
    {
        $result = 
        "SELECT b.flagkkbb,'d' as kode,a.rekeningid,b.transdate,a.jenis,isnull(a.amount,0) as amount,a.note,
        case when b.flagkkbb in ('bk','bm','gc','apb','arb','arc','apc') then b.voucherno else a.voucherid end as voucherid,
        b.fgpayment,b.voucherid as bnote,b.currid,b.rate 
        from cftrkkbbdt a inner join cftrkkbbhd b on a.voucherid=b.voucherid 
        union all 
        select a.flagkkbb,'h',b.rekeningid,a.transdate,case when c.flagkkbb in ('bm','arb','arc') then 'D' else 'K' end,
        isnull(case when c.flagkkbb in ('bm','arb','arc') then a.jumlahd when c.flagkkbb in ('bk','apb','apc') then a.jumlahk end,0),
        c.note,a.voucherno,a.fgpayment,a.voucherid,a.currid,a.rate from cftrkkbbhd a inner join cfmsbank b on a.bankid=b.bankid 
        inner join cftrkkbbhd c on a.idvoucher=c.voucherid 
        union all 
        select a.flagkkbb,'h',b.rekeningid,a.transdate,case when a.flagkkbb in ('bm','arb','arc') then 'D' else 'K' end,
        isnull(case when a.flagkkbb in ('bm','arb','arc') then jumlahd when a.flagkkbb in ('bk','apb','apc') then jumlahk end,0),
        a.note,case when a.flagkkbb in ('bk','bnm','gc','arb','arc','apb','apc') then a.voucherno else a.voucherid end,
        a.fgpayment,a.voucherid,a.currid,a.rate from cftrkkbbhd a inner join cfmsbank b on a.bankid=b.bankid 
        where a.flagkkbb in ('bm','bk','arb','arc','apb','apc') 
        union all 
        select a.flagkkbb,'h',(select drkas from samsset),a.transdate,case when a.flagkkbb in ('km','ark') then 'D' else 'K' end,
        isnull(case when a.flagkkbb in ('km','ark') then jumlahd when a.flagkkbb in ('kk','apk') then jumlahk end,0),
        a.note,a.voucherid,a.fgpayment,a.voucherid,a.currid,a.rate 
        from cftrkkbbhd a where a.flagkkbb in ('km','kk','ark','apk') 
        union all 
        select 'ar','d',rekeningu,transdate,'D',isnull(ttlpj,0),a.saleid,a.saleid,'t' as fgpayment,a.saleid,a.currid,a.rate from artrpenjualanhd a union all 
        select 'ar','d',rekeningk,transdate,'K',isnull(stpj-dp,0),a.saleid,a.saleid,'t',a.saleid,a.currid,a.rate from artrpenjualanhd a union all 
        select 'ar','d',rekeningp,transdate,'K',isnull(ppn,0),a.saleid,a.saleid,'t',a.saleid,a.currid,a.rate from artrpenjualanhd a union all 
        select 'ar','d',rekhpp,transdate,'D',isnull(hpp,0),a.saleid,a.saleid,'t' as fgpayment,a.saleid,a.currid,a.rate from artrpenjualanhd a union all 
        select 'ar','d',rekpersediaan,transdate,'K',isnull(hpp,0),a.saleid,a.saleid,'t' as fgpayment,a.saleid,a.currid,a.rate from artrpenjualanhd a union all 
        
        select 'ap','p',rekeningk,transdate,'D',isnull(stpb,0),'bb',a.purchaseid ,'t',a.purchaseid,a.currid,a.rate from aptrpurchasehd a union all 
        select 'ap','p',rekeningp,transdate,'D',isnull(ppn,0),'cc',a.purchaseid,'t',a.purchaseid,a.currid,a.rate from aptrpurchasehd a union all 
        select 'ap','p',rekeningu,transdate,'K',isnull(ttlpb,0),'aa',a.purchaseid,'t' as fgpayment,a.purchaseid,a.currid,a.rate from aptrpurchasehd a union all 
        select 'ap','p',rekpersediaan,transdate,'D',isnull(stpb,0),'aa',a.purchaseid,'t' as fgpayment,a.purchaseid,a.currid,a.rate from aptrpurchasehd a union all 
        select 'ap','p',rekhpp,transdate,'K',isnull(stpb,0),'aa',a.purchaseid,'t' as fgpayment,a.purchaseid,a.currid,a.rate from aptrpurchasehd a";

        return $result;
    }
}