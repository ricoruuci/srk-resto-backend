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

}

?>
