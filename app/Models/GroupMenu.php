<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;
use function PHPUnit\Framework\isNull;

class GroupMenu extends BaseModel
{
    use HasFactory;

    protected $table = 'msgroupmenu';

    public $timestamps = false;

    function getAllData()
    {
        $result = DB::select(
            "SELECT kdgroupmenu,nmgroupmenu from msgroupmenu order by kdgroupmenu "
        );

        return $result;
    }

}

?>
