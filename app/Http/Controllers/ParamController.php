<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Param;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\AddEventLogs;
use Validator;

class ParamController extends Controller
{
    public function index(){
        if(view()->exists('params')){
            $title='Параметры';
            //$users = User::all();
            //$devices = Device::where('user_id', '=', Auth::id())->all();
            $params = Param::with('devices')->paginate(env('PAGINATION_SIZE'));
            $data = [
                'title' => $title,
                'head' => 'Параметры, контролируемые оборудованием',
                'params' => $params,
            ];
            return view('params',$data);
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
            ];
            $validator = Validator::make($input,[
                'name' => 'required|string|max:70',
                'val' => 'string|nullable',
            ],$messages);
            if($validator->fails()){
                return redirect()->route('paramAdd')->withErrors($validator)->withInput();
            }

            $param = new Param();
            $param->fill($input);
            $param->created_at = date('Y-m-d H:m:i');
            if($param->save()){
                $msg = 'Новый параметр '. $input['name'] .' был успешно добавлен!';
                //вызываем event
                if(Auth::check())
                    event(new AddEventLogs('info',Auth::id(),$msg));
                else
                    event(new AddEventLogs('info',1,$msg));
                return redirect('/params')->with('status',$msg);
            }
        }
        if(view()->exists('new_param')){
            $devices = Device::where('user_id', '=', Auth::id())->get();
            $devsel = array();
            foreach ($devices as $device){
                $devsel[$device->id] = $device->name;
            }
            $data = [
                'title' => 'Новый параметр',
                'devsel' => $devsel,
            ];
            return view('new_param', $data);
        }
        abort(404);
    }
}
