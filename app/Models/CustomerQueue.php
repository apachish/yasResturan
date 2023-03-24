<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CustomerQueue extends Model
{
    use HasFactory;
    use LogsActivity;



    protected $fillable = ["date_login", "full_name", "mobile", "number", "status","pending_save","pending","user_id","created_by","updated_by","description"];


    protected static $logAttributes = [
        "date_login", "full_name", "mobile", "number", "status","pending_save","pending","user_id","created_by","updated_by","description"
    ];


    const STATUS_PENDING = "pending";
//    const STATUS_CALLING = "call";
    const STATUS_ACCEPT = "accept";
    const STATUS_REJECT = "reject";



    public static function getStatus($select = 'all')
    {
        $status = [
            self::STATUS_PENDING => 'در انتظار',
//            self::STATUS_CALLING => 'تماس گرفته شد',
            self::STATUS_ACCEPT => 'تایید شد',
            self::STATUS_REJECT => 'لغو شد',
        ];
        if ($select == 'all') return $status;
        if ($select && array_key_exists($select, $status)) return $status[$select];
        if ($select == 'key') return array_keys($status);
        return [];
    }

//    public function getActivitylogOptions(): LogOptions
//    {
//        // TODO: Implement getActivitylogOptions() method.
//    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(["date_login", "full_name", "mobile", "number", "status","pending_save","pending","created_by","updated_by"]);
        // Chain fluent methods for configuration options
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,"created_by");
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class,"updated_by");
    }
}
