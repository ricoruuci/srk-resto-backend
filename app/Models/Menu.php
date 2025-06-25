<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;
use function PHPUnit\Framework\isNull;

class Menu extends BaseModel
{
    use HasFactory;

    protected $table = 'msmenuhd';

    public $timestamps = false;

    function getDataById($id)
    {
        $result = DB::select(
            "SELECT a.kdmenu as menu_id,a.nmmenu as menu_name,a.harga as price,a.jenis as fg_item,
            case when a.jenis='a' then 'makanan' else 'minuman' end as fg_item_name,
            a.kdgroupmenu as group_menu_id,b.nmgroupmenu as group_menu_name,a.filecontent as item_picture
            from msmenuhd a
            left join msgroupmenu b on a.kdgroupmenu=b.kdgroupmenu
            where a.kdgroupmenu = :id
            order by a.kdmenu ",
            [
                'id' => $id
            ]
        );

        return $result;
    }

    function cekData($id)
    {

        $result = DB::selectOne(
            'SELECT * from msmenuhd WHERE kdmenu = :id',
            [
                'id' => $id
            ]
        );

        return $result;
    }

}

?>
