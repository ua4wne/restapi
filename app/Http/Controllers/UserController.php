<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        if(!User::hasRole('admin')){
            abort(503);
        }
        if(view()->exists('users')){
            $title='Учетные записи';
            //$users = User::all();
            $users = User::paginate(env('PAGINATION_SIZE')); //all();
            $roles = Role::all();
            $data = [
                'title' => $title,
                'head' => 'Учетные записи пользователей',
                'users' => $users,
                'roles' => $roles,
            ];
            return view('users',$data);
        }
        abort(404);
    }
}
