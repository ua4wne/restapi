<?php

namespace App\Http\Controllers\Ajax;

use App\Events\AddEventLogs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function switchLogin(Request $request){
        if($request->isMethod('post')){
            $id = $request->input('id');
            $active = $request->input('active');
            if($id==1)
                return 'NOT';
            $user = User::find($id);
            $user->active = $active;
            if(!Auth::user()->isAdmin()){//вызываем event
                $msg = 'Попытка изменения учетной записи '.$user->login;
                $ip = $request->getClientIp();
                event(new AddEventLogs('access',Auth::id(),$msg,$ip));
                return 'NO';
            }
            if($user->update()){
                if($active)
                    $msg = 'Учетная запись '.$user->login.' была включена';
                else
                    $msg = 'Учетная запись '.$user->login.' была выключена';
                $ip = $request->getClientIp();
                event(new AddEventLogs('access',Auth::id(),$msg,$ip));
                return 'OK';
            }
            else
                return 'ERR';
        }
    }

    public function editLogin(Request $request){
        if($request->isMethod('post')){
            $input = $request->except('_token'); //параметр _token нам не нужен
            $user = User::find($input['id']);
            $user->fill($input);
            if($input['id']==1)
                $user->active = 1; //первый админ всегда активен!!!
            if(!Auth::user()->isAdmin()){//вызываем event
                $msg = 'Попытка изменения учетной записи '.$user->login;
                $ip = $request->getClientIp();
                event(new AddEventLogs('access',Auth::id(),$msg,$ip));
                return 'NO';
            }
            if($user->update()){
                $msg = 'Учетная запись '.$user->login.' была изменена!';
                $ip = $request->getClientIp();
                event(new AddEventLogs('access',Auth::id(),$msg,$ip));
                return 'OK';
            }
            else
                return 'ERR';
        }
    }

    public function delete(Request $request){
        if($request->isMethod('post')){
            $id = $request->input('id');
            $model = User::find($id);
            if(!Auth::user()->isAdmin()){//вызываем event
                $msg = 'Попытка удаления учетной записи '.$model->login;
                $ip = $request->getClientIp();
                event(new AddEventLogs('access',Auth::id(),$msg,$ip));
                return 'NO';
            }

            if($model->delete()) {
                $msg = 'Учетная запись '.$model->login.' была удалена!';
                $ip = $request->getClientIp();
                event(new AddEventLogs('access',Auth::id(),$msg,$ip));
                return 'OK';
            }
            else{
                return 'ERR';
            }
        }
    }
}
