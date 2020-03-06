<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Helpers\Konstanta;
use App\myModel\MasterRating;
use Illuminate\Support\Facades\Storage;

class RateController extends Controller{
    public function all(Request $request){
        $userID = $request->input('userID');
        if($userID==NULL){
            $code=Konstanta::$failed_code;
            $message=Konstanta::$failed_message;
            return responseNoresult($code,$message,false);
        }else{
            $result = MasterRating::with('data_magazine')->with('data_user')->where('user_id',$userID)->orderBy('created_date', 'DESC')->get();
            $code   =Konstanta::$success_code;
            $message=Konstanta::$success_message;
            $status = true;
            return responseResult($code,$message,$status,$result);
        }
        
    }
    public function detail(Request $request){
        $id = $request->input('id');
        if($id==NULL){
            $user_id = $request->input('user_id');
            $id_magazine = $request->input('id_magazine');
            if($user_id==NULL || $id_magazine==NULL){
                $code=Konstanta::$failed_code;
                $message=Konstanta::$failed_message;
                return responseNoresult($code,$message,false);
            }else{
                $result = MasterRating::with('data_magazine')->with('data_user')->where('user_id',$user_id)->where('id_magazine',$id_magazine)->first();
                $code   =Konstanta::$success_code;
                $message=Konstanta::$success_message;
                $status = true;
                return responseResult($code,$message,$status,$result);
            }
        }else{
            $result = MasterRating::with('data_magazine')->with('data_user')->where('id',$id)->first();
            $code   =Konstanta::$success_code;
            $message=Konstanta::$success_message;
            $status = true;
            return responseResult($code,$message,$status,$result);
        }
        
    }
    public function insert(Request $request){
        $data = $request->except(['id','nota','status']);
        $update = MasterBahanTransIn::insert($data);
        $result = MasterBahanTransIn::with('data_bahan')->where('id_in',$id_in)->first();
        if (!$update OR $imageok=='no'){
            $code = Konstanta::$failed_code;
            $message = Konstanta::$failed_message;
            $status = false;
            $result=[];
        }
        return responseResult($code,$message,$status,$result);
    }
}