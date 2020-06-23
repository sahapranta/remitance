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
<<<<<<< HEAD
    }
  
=======
    }    
>>>>>>> 93b9275a36a46f7782aa5f17d74596b7c55570dd
}
