<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    //указываем имя таблицы
    protected $table = 'params';

    protected $fillable = ['device_id','name','val'];

    public function devices()
    {
        return $this->belongsTo('App\Models\Device','device_id','id');
    }
}
