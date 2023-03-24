<?php

namespace App\Exports;

use App\Models\Pos;
use Maatwebsite\Excel\Concerns\FromCollection;

class PosExport implements FromCollection
{

    private $filter = [];

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $poses =   Pos::orderBy('updated_at', 'desc');
        foreach ($this->filter as $key => $filter) {
            if (in_array($key, ["status","in_possession"]) && $filter>=0) {
                $poses->where($key, $filter);
            }
            elseif (in_array($key, ["title", "code"]))
                $poses->where($key, "like", "%" . $filter . "%");
        }
        $poses  = $poses->get();
        $return = $poses->map(function ($pos){
            return [
                $pos->id,
                $pos->title,
                $pos->code,
                $pos->status?"فعال":"غیر فعال",
                $pos->inPossession->full_name,
            ];
        });
        $return->prepend( [
            "شناسه",
            "عنوان دستگاه",
            "کد دستگاه",
            "وضعیت",
            "در اختیار	",
        ]);
        return $return;
    }
}
