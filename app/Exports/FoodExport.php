<?php

namespace App\Exports;

use App\Models\Food;
use Maatwebsite\Excel\Concerns\FromCollection;

class FoodExport implements FromCollection
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
        $foods =   Food::orderBy('updated_at', 'desc');
        foreach ($this->filter as $key => $filter) {
            if (in_array($key, ["status","category_id"]) && $filter>=0) {
                $foods->where($key, $filter);
            }
            elseif (in_array($key, ["price"]))
                $foods->where($key, ">=", $filter);
            elseif (in_array($key, ["title"]))
                $foods->where($key, "like", "%" . $filter . "%");
        }
        $foods  = $foods->get();
        $return = $foods->map(function ($food){
            return [
                $food->id,
                $food->title,
                number_format($food->price, 0),
                $food->category?$food->category->title:"-",
                $food->status?"فعال":"غیر فعال",
            ];
        });
        $return->prepend( [
            "شناسه",
            "عنوان ",
            "قیمت",
            "دسته بندی",
            "وضعیت",
        ]);
        return $return;
    }
}
