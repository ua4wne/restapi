<?php

namespace App\Http\Controllers;

use App\Models\Param;
use Illuminate\Http\Request;

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
}
