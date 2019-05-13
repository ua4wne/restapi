<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Cache;
use App\Events\AddEventLogs;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'login';
    }

    /**
     * Обработка попытки аутентификации.
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $data = $request->all();
        //есть записи в
        if (Auth::attempt(['login' => $data['login'], 'password' => $data['password'], 'active' => 1])) {
            // Аутентификация успешна...
            //вызываем event
            $msg = 'Пользователь '.Auth::user()->login.' вошел в систему '.date('Y-m-d H:i:s');
            $ip = $request->getClientIp();
            event(new AddEventLogs('logon',Auth::id(),$msg,$ip));
            return redirect()->intended($this->redirectTo);
        }
        else{
            //вызываем event
            $msg = 'Не удачная попытка входа в систему '.date('Y-m-d H:i:s').' логин - '.$request->input('login');
            $ip = $request->getClientIp();
            event(new AddEventLogs('logon',1,$msg,$ip));
            return redirect('/login');
        }
    }

    public function logout(){
        Cache::forget('user-is-online-' . Auth::user()->id);
        //вызываем event
        $msg = 'Пользователь '.Auth::user()->login.' вышел из системы '.date('Y-m-d H:i:s');
        event(new AddEventLogs('logoff',Auth::id(),$msg));
        Auth::logout();
        return redirect('/login');
    }

    public function activate(Request $request){
        $user = User::where(array('id'=>$request->id,'auth_code'=>$request->code))->first();
        if($user){
            $user->active = 1;
            $user->auth_code = NULL;
            if($user->save()){
                $msg = 'Учетная запись активирована!';
                //вызываем event
                $text = 'Учетная запись '.$user->login.' была активирована '.date('Y-m-d H:i:s');
                $ip = $request->getClientIp();
                event(new AddEventLogs('system',$user->id,$text,$ip));
                return redirect('/login')->with('status',$msg);
            }
        }
        abort(404);
    }
}
