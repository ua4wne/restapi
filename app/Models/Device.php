<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //указываем имя таблицы
    protected $table = 'devices';

    protected $fillable = ['uid','user_id','name','descr'];

    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
