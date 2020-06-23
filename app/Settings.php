<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = ['data', 'name'];
    protected $casts = ['data' => 'array'];

    public function setDataAttribute($value)
    {
        $data = [];
        foreach ($value as $key => $arr) {
            if (!is_null($arr)) {
                $data[] = $arr;
            }
        }
        $this->attributes['data'] = json_encode($data);
    }

    public function getMoreThanOneAttribute()
    {
        return count($this->data) > 1 ? true : false;
    }
}
