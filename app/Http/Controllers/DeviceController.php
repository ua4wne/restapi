<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\AddEventLogs;
use Validator;

class DeviceController extends Controller
{
    public function index(){
        if(view()->exists('devices')){
            $title='Подключенное оборудование';
            //$users = User::all();
            $devices = Device::where('user_id', '=', Auth::id())->paginate(env('PAGINATION_SIZE')); //all();
            $data = [
                'title' => $title,
                'head' => 'Оборудование',
                'devices' => $devices,
            ];
            return view('devices',$data);
        }
        abort(404);
    }

    public function create(Request $request){

        if($request->isMethod('post')){
            $input = $request->except('_token'); //параметр _token нам не нужен

            $messages = [
                'required' => 'Поле обязательно к заполнению!',
                'string' => 'Значение поля должно быть строковым!',
                'max' => 'Значение поля должно быть не более :max символов!',
                'unique' => 'Значение поля должно быть уникальным!',

            ];
            $validator = Validator::make($input,[
                'uid' => 'required|string|min:12|max:16|unique:devices',
                'name' => 'required|string|max:70',
                'descr' => 'string|max:255',
            ],$messages);
            if($validator->fails()){
                return redirect()->route('deviceAdd')->withErrors($validator)->withInput();
            }

            $device = new Device();
            $device->fill($input);
            $device->user_id = Auth::id();
            $device->created_at = date('Y-m-d H:m:i');
            if($device->save()){
                $msg = 'Новое устройство '. $input['name'] .' было успешно добавлено!';
                //вызываем event
                if(Auth::check())
                    event(new AddEventLogs('info',Auth::id(),$msg));
                else
                    event(new AddEventLogs('info',1,$msg));
                return redirect('/devices')->with('status',$msg);
            }
        }
        if(view()->exists('new_device')){
            $data = [
                'title' => 'Новое устройство',
            ];
            return view('new_device', $data);
        }
        abort(404);
    }
}
