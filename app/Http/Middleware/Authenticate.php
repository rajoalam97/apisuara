<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Helpers\Konstanta;
use App\myModel\App_token;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $path = $request->getPathInfo();
        $method = $request->method();
        $token=$request->bearerToken();
        if(!$token){
            $code = Konstanta::$tokenfailed;
            $message =Konstanta::$tokenfailed_message;
            return responseNoresult($code,$message,false);
        }else{
            $cekMe = Self::checkActiveToken($token,$path,$method);
            if(!$cekMe){
                $code=Konstanta::$tokeninvalid;
                $message=Konstanta::$tokeninvalid_message;
                return responseNoresult($code,$message,false);
            }
        }

        return $next($request);
    }
    private function checkActiveToken($token,$route,$type){
        $cek_db = App_token::where('token',$token)
                    ->where('status','Y')
                    ->first();
        if(!$cek_db){
            return null;
        }else{
            $now = date('Y-m-d H:i:s');
            $updateInactive=["status"=>"N"];
            $inactive = App_token::where("token",'=', $token)
                        ->where("expired",'<=', $now)
                        ->update($updateInactive);
            if($inactive){
                return null;
            }else{
                insert_history($cek_db['user_id'],$route,$type);
                return 'ok';
            }
        }
    }
}
