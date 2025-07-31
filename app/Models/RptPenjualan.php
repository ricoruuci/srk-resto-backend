<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;
use function PHPUnit\Framework\isNull;

class RptPenjualan extends BaseModel
{
    use HasFactory;

    function getLapPenjualan($params)
    {
        $result = DB::select(
            "SELECT a.nota as nota_jual,a.tgljual as transdate,a.nomeja as nomor_meja,
            case when a.fgbayar='Y' then 'LUNAS' else 'BELUM LUNAS' end as status_bayar,a.paytype as payment_type,
            case when a.PayType=0 then 'QRIS' when a.PayType=1 then 'DEBIT CARD' 
                 when a.paytype=2 then 'CREDIT CARD' when a.paytype=3 then 'CASH' end as payment_type_name,
            a.upduser,a.upddate,a.stpj as sub_total,a.ttltax as total_ppn,a.ttlpj as grand_total
            from trjualhd a
            where convert(varchar(10),a.tgljual,112) between :dari and :sampai and a.nota like :search_keyword 
            order by a.tgljual,a.nota ",
            [
                'dari' => $params['dari'],
                'sampai' => $params['sampai'],
                'search_keyword' => '%'.$params['search_keyword'].'%'
            ]
        );

        return $result;
    }

    function getLapPenjualanHarian($transdate)
    {
        $per_group = DB::select(
            "SELECT c.KdGroupMenu,d.NmGroupMenu,isnull(sum(a.jumlah),0) as qty,isnull(sum(a.jumlah*a.harga),0) as total 
            from TrJualdt a 
            left join TrJualHd b on a.Nota=b.Nota and b.FgBatal='T'
            left join MsMenuHd c on a.KdMenu=c.KdMenu
            left join MsGroupMenu d on c.KdGroupMenu=d.KdGroupMenu
            where convert(varchar(10),b.tgljual,112) = :transdate and b.fgbatal='T'
            group by c.KdGroupMenu,d.NmGroupMenu
            order by c.KdGroupMenu ",
            [
                'transdate' => $transdate
            ]
        );

        $per_menu = DB::select(
            "SELECT c.kdgroupmenu,a.kdmenu,c.NmMenu,isnull(sum(a.jumlah),0) as qty,a.harga,isnull(sum(a.jumlah*a.harga),0) as total from TrJualdt a 
            left join TrJualHd b on a.Nota=b.Nota and b.FgBatal='T'
            left join MsMenuHd c on a.KdMenu=c.KdMenu
            where convert(varchar(10),b.tgljual,112) = :transdate and b.fgbatal='T'
            group by c.kdgroupmenu,a.kdmenu,c.NmMenu,a.harga
            order by c.kdgroupmenu,c.NmMenu,a.kdmenu,a.harga ",
            [
                'transdate' => $transdate
            ]
        );

        $count_transaksi = DB::selectOne(
            "SELECT isnull(sum(1),0) as total,
            isnull(sum(case when a.fgbatal='T' then (case when a.fgbayar='Y' then 1 else 0 end) else 0 end),0) as lunas,
            isnull(sum(case when a.fgbatal='T' then (case when a.fgbayar='T' then 1 else 0 end) else 0 end),0) as blm_lunas,
            isnull(sum(case when a.fgbatal='Y' then 1 else 0 end),0) as batal
            from trjualhd a
            where convert(varchar(10),a.tgljual,112) = :transdate",
            [
                'transdate' => $transdate
            ]
        );

        $payment = DB::select(
            "SELECT a.paytype,CASE WHEN a.FgBayar='Y' THEN 
            (case when a.paytype=0 then 'QRIS' when a.paytype=1 then 'DEBIT' when a.paytype=2 then 'CREDIT' else 'CASH' end)
            ELSE 'BELUM BAYAR'
            end as payment_type_name,
            isnull(sum(a.ttlpj),0) as total from TrJualHd a 
            where  a.FgBatal='T'
            and convert(varchar(10),a.tgljual,112) = :transdate
            group by a.paytype,a.fgbayar ",
            [
                'transdate' => $transdate
            ]
        );
        
        $result = [
            'per_group' => $per_group,
            'per_menu' => $per_menu,
            'count_transaksi' => $count_transaksi,
            'payment' => $payment
        ];

        return $result;
    }

}

?>
