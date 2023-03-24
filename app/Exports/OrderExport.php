<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection
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
        $orders = Order::orderBy('updated_at', 'desc');
        if ($this->filter) {
            foreach ($this->filter as $key => $filter) {
                if (in_array($key, ["created_at"]))
                {
                    $date = toGregorian($filter, "Y-m-d");
                    $orders->whereDate($key, $date);
                }
                elseif (in_array($key, ["price"]))
                    $orders->where($key, ">=", $filter);
                elseif($filter)
                    $orders->where($key, $filter);
            }
        }
        $orders = $orders->get();
        $return = $orders->map(function ($order){
            return [
                $order->number_factor,
                number_format($order->price, 0),
                $order->customer?$order->customer->full_name:"",
                Order::getStatus($order->status),
                toJalali($order->created_at,"Y//m/d H:i"),
                $order->pack?$order->pack->full_name:"",
                Order::getTypes($order->type_pay),
                $order->pos ?$order->pos->title:"",
                $order->pos_code
            ];
        });
        $return->prepend( [
            "شماره فاکتور",
            "مبلغ",
            "مشتری",
            "وضعیت",
            "تاریخ سفارش",
            "پیک",
            "نوع پرداخت",
            "دستگاه Pos",
            __("message.Code POS")
        ]);
        return $return;
    }
}
