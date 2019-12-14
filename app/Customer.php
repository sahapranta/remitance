<?php

namespace App;
use App\Remitance;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'birthdate', 'mobile', 'address', 'nid', 'passport_id', 'account_id', 'status', 'user_id'
    ];

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function Remitance()
    {
        return $this->HasMany('App\Remitance');
    }

    public function unpaid_remitances()
    {
        return $this->HasMany('App\Remitance')->where('incentive_amount', 0);
    }    

    public function getIdentificationAttribute()
    {
        return $this->account_id ?? $this->nid ?? $this->passport_id ?? '';
    }

    public function getCreateDateAttribute()
    {
        return  $this->created_at->diffForHumans();
    }
}
