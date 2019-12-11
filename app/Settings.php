<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = ['data'];
    protected $casts = ['data' => 'array'];

    public function setDataAttributes($value)
    {
        $data = [];

        foreach ($value as $arr) {
            if (!is_null($arr['key'])) {
                $data[] = $arr;
            }
        }
        $this->attributes['data'] = json_encode($data);
    }
}
