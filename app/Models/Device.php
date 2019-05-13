<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //указываем имя таблицы
    protected $table = 'devices';

    protected $fillable = ['uid','user_id','name','descr'];

}
