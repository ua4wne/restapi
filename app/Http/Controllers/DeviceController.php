<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\AddEventLogs;

class DeviceController extends Controller
{
    public function index(){
        if(view()->exists('devices')){
            $title='Подключенное оборудование';
            //$users = User::all();
            $devices = Device::paginate(env('PAGINATION_SIZE'))->where(['user_id'=>Auth::user()->id]); //all();
            $data = [
                'title' => $title,
                'head' => 'Оборудование',
                'devices' => $devices,
            ];
            return view('devises',$data);
        }
        abort(404);
    }
}
