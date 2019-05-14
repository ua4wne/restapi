<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Eventlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventlogController extends Controller
{
    public function delone(Request $request){
        if($request->isMethod('post')){
            $id = $request->input('id');
            $model = Eventlog::find($id);
            if(Auth::user()->isAdmin()){//может удалять только админ
                if($model->delete()) {
                    return 'OK';
                }
                else{
                    return 'ERR';
                }
            }
            return 'NO';
        }
    }

    public function delete(Request $request){
        if($request->isMethod('post')){
            if(Auth::user()->isAdmin()){//может удалять только админ
                //удаляем все записи журнала
                DB::table('logs')->delete();
                return 'OK';
            }
            return 'NO';
        }
    }
}
