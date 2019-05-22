<?php

namespace App\Http\Controllers\Api;

use App\Models\Device;
use App\Models\Param;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ParamController extends Controller
{
    public function index()
    {
        $user_id = Auth::guard('api')->id(); // the id of the authenticated user $request->user();
        //выбираем все устройства пользователя
        $devices = Device::where(['user_id'=>$user_id])->pluck('id')->toArray();
        $params = Param::whereIn('device_id', $devices)->get();
        return $params;
    }

    public function show($id)
    {
        $param = Param::find($id);
        if(empty($param)) return Route::respondWithRoute('api.fallback.404'); //нет такого параметра!

        //проверяем что есть доступ к параметру
        if(Auth::user()->isAdmin() || Auth::id()==$param->devices->user_id) {//может удалять только админ и владелец устройства
            return $param;
        }
        else{
            return Route::respondWithRoute('api.fallback.404');
        }
    }

    public function store(Request $request)
    {
        //if(Auth::user()->isAdmin() || Auth::id()==$param->devices->user_id) {//может создавать только админ и владелец устройства
            $param = Param::create($request->all());
            return response()->json($param, 201);
        //}
    }

    public function update(Request $request, $id)
    {
        $param = Param::find($id);
        if(empty($param)) return Route::respondWithRoute('api.fallback.404'); //нет такого параметра!
        if($param->update($request->all()))
            return response()->json($param, 200);
    }

    public function delete($id)
    {
        $param = Param::find($id);
        if(empty($param)) return Route::respondWithRoute('api.fallback.404'); //нет такого параметра!
        $param->delete();
        return response()->json(null, 204);
    }
}
