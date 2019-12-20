<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Remitance extends Model
{
    protected $fillable = [
        'remit_type', 'exchange_house', 'reference', 'payment_date', 'sending_country', 'sender', 'amount', 'incentive_amount', 'incentive_date', 'payment_type', 'payment_by', 'note', 'customer_id', 'user_id', 'voucher_reference', 'incentive_voucher',
    ];

    public function User()
    {
        return $this->belongsTo('App\User')->withDefault();
    }

    public function Customer()
    {
        return $this->belongsTo('App\Customer')->withDefault();
    }

    public function getCreateDateAttribute()
    {
        return $this->payment_date->diffForHumans();
    }
    

    public function VoucherReferenceAttribute($type, $date)
    {
        // if ($type === 'cash') {
        //     $inc = $this->get_voucher($type, $date) + 1;
        //     $number = str_pad($inc, 4, '0', STR_PAD_LEFT);
        //     $this->attributes['voucher_reference'] = 'RM-' . date('Ymd') . '-' . $number;
        // } else {
        //     $inc = $this->get_voucher($type, $date) + 1;
        //     $number = str_pad($inc, 3, '0', STR_PAD_LEFT);
        //     $this->attributes['voucher_reference'] = 'RM-' . date('Ymd') . '-1' . $number;
        // }

    }

}
