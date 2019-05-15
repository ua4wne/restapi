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

    public function edit(Request $request){
        if($request->isMethod('post')){
            $input = $request->except('_token'); //параметр _token нам не нужен
            $param = Param::find($input['id']);
            $param->fill($input);

            if($param->update()){
                $msg = 'Данные параметра '.$param->name.' были изменены!';
                $ip = $request->getClientIp();
                event(new AddEventLogs('info',Auth::id(),$msg,$ip));
                return 'OK';
            }
            else
                return 'ERR';
        }
    }

    public function delete(Request $request){
        if($request->isMethod('post')){
            $id = $request->input('id');
            $model = Param::find($id);
            if(Auth::user()->isAdmin() || Auth::id()==$model->devices->user_id){//может удалять только админ и владелец устройства
                if($model->delete()) {
                    $msg = 'Параметр '.$model->name.', контролируемый устройством '.$model->devices->name.' был удален!';
                    $ip = $request->getClientIp();
                    event(new AddEventLogs('info',Auth::id(),$msg,$ip));
                    return 'OK';
                }
                else{
                    return 'ERR';
                }
            }
            return 'NO';
        }
    }
}
