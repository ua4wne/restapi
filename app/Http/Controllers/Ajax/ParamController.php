<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Device;
use App\Models\Param;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\AddEventLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParamController extends Controller
{
    public function create(Request $request){
        if($request->isMethod('post')){
            $input = $request->except('_token'); //параметр _token нам не нужен
            $dbl = Param::where(['device_id'=>$input['device_id'],'name'=>$input['name']])->get()->count();
            if($dbl > 0) return 'DBL';
            $device = Device::find($input['device_id']);
            $param = new Param();
            $param->fill($input);
            if($param->save()){
                $msg = 'Добавлен новый параметр '.$param->name.' для устройства '.$device->name;
                $ip = $request->getClientIp();
                event(new AddEventLogs('info',Auth::id(),$msg,$ip));
                return $device->params->count();
            }
            else
                return 'ERR';
        }
    }
}
