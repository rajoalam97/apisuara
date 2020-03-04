<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Helpers\Konstanta;
use App\myModel\MasterUser;

class UserController extends Controller{
    public function login(Request $request){
        $id=getToken(6);
        $email = $request->input('email');
        $sign_by = $request->input('sign_by');
        $name = $request->input('name');
        $token_firebase = $request->input('token_firebase');
        $image_url = $request->input('imageUrl');
        $uid = $request->input('uid');
        if($email==NULL && $sign_by==NULL){
            $code = Konstanta::$failed_code; $message =Konstanta::$failed_message; $status=false;$result=null;
        }else{
            $result = MasterUser::where('email',$email)->first();
            if($result){
                $code = Konstanta::$success_code; $message =Konstanta::$success_message; $status=true;
                $result = MasterUser::where('email',$email)->first();
            }else{
                $data = array('user_id' => $id,'email' => $email,'name' => $name,'token_firebase'=>$token_firebase,'image_url'=>$image_url,'uid'=>$uid,'sign_by'=>$sign_by,'status'=>'Y','last_updated'=>date('Y-m-d H:i:s'),'created_at'=>date('Y-m-d H:i:s'));
                MasterUser::insert($data);
                $code = Konstanta::$success_code; $message =Konstanta::$success_message; $status=true;
                $result = MasterUser::where('email',$email)->first();
            }
        }
        return responseResult($code,$message,$status,$result);
    }
}