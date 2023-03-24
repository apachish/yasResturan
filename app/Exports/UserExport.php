<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
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
        $users = User::orderBy('updated_at', 'desc')->where("national_code", "!=", "11111111111");
        foreach ($this->filter as $key => $filter) {
            if (in_array($key, ["created_at"])) {
                $date = toGregorian($filter, "Y-m-d");
                $users->whereDate($key, $date);
            } elseif (in_array($key, ["role"]))
                $users->whereHas("roles", function ($query) use ($filter) {
                    $query->where("name", $filter);
                });
            elseif (in_array($key, ["full_name", "mobile", "national_code"]))
                $users->where($key, "like", "%" . $filter . "%");
        }
        $users  = $users->get();
        $return = $users->map(function ($user){
            return [
                $user->id,
                $user->full_name,
                $user->mobile,
                $user->national_code,
                implode("|",$user->roles->pluck("display_name")->toArray()),
                toJalali($user->created_at,"Y/m/d")
            ];
        });

        $return->prepend( [
            "شناسه",
            "نام و نام خانوادگی",
            "شماره همراه",
            "کدملی",
            "نقش",
            "تاریخ ثبت نام",
        ]);
        return $return;

    }
}
