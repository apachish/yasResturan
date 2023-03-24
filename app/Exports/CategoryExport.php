<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoryExport implements FromCollection
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
        $categories =   Category::orderBy('updated_at', 'desc');
        foreach ($this->filter as $key => $filter) {
            if (in_array($key, ["status"]) && $filter>=0) {
                $categories->where($key, $filter);
            }
            elseif (in_array($key, ["title"]))
                $categories->where($key, "like", "%" . $filter . "%");
        }
        $this->count_items = $categories->count();
        $categories  = $categories->get();
        $return = $categories->map(function ($category){
            return [
                $category->id,
                $category->title,
                $category->status?"فعال":"غیر فعال",
            ];
        });
        $return->prepend( [
            "شناسه",
            "عنوان ",
            "وضعیت",
        ]);
        return $return;
    }
}
