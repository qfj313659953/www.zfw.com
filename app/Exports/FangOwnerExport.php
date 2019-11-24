<?php

namespace App\Exports;

use App\Model\FangOwner;
use Maatwebsite\Excel\Concerns\FromCollection;

class FangOwnerExport implements FromCollection
{
    protected $offset;

    public function __construct($offset = 0)
    {
        $this->offset = $offset;

    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //获取出需要导出的所有的数据
        return FangOwner::offset($this->offset)->limit(5)->get();
    }
}
