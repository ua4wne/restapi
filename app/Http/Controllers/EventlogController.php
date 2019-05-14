<?php

namespace App\Http\Controllers;

use App\Models\Eventlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventlogController extends Controller
{
    public function index(){
        if(!Auth::user()->isAdmin()){
            abort(503);
        }
        if(view()->exists('logs')){
            $title='Журнал событий';
            //$users = User::all();
            $logs = Eventlog::paginate(env('PAGINATION_SIZE')); //all();
            $data = [
                'title' => $title,
                'head' => 'Журнал событий',
                'logs' => $logs,
            ];
            return view('logs',$data);
        }
        abort(404);
    }
}
