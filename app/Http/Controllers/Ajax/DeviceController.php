<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\AddEventLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function edit(Request $request){
        if($request->isMethod('post')){
            $input = $request->except('_token'); //параметр _token нам не нужен
            $device = Device::find($input['id']);
            $device->fill($input);

            if($device->update()){
                $msg = 'Данные устройства '.$device->name.' были изменены!';
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
            $model = Device::find($id);
            if(Auth::user()->isAdmin() || Auth::id()==$model->user_id){//может удалять только админ и владелец устройства
                //удаляем записи всех связанных переменных, если есть
                DB::table('params')->where('device_id', '=', $id)->delete();

                if($model->delete()) {
                    $msg = 'Устройство '.$model->name.' было удалено!';
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
