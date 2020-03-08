<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Helpers\Konstanta;
use App\myModel\MasterMagazine;
use Illuminate\Support\Facades\Storage;

class MagazineController extends Controller{
    public function all(Request $request){
        $limit = $request->input('limit');
        if($limit==NULL){
            $limit = 1000;
        }
        $result = MasterMagazine::take($limit)->get();
        $code   =Konstanta::$success_code;
        $message=Konstanta::$success_message;
        $status = true;
        return responseResult($code,$message,$status,$result);
    }
    public function detail(Request $request){
        $id_magazine = $request->input('id_magazine');
        if($id_magazine==NULL){
            $code=Konstanta::$failed_code;
            $message=Konstanta::$failed_message;
            return responseNoresult($code,$message,false);
        }else{
            $result = MasterMagazine::where('id',$id_magazine)->first();
            $code   =Konstanta::$success_code;
            $message=Konstanta::$success_message;
            $status = true;
            return responseResult($code,$message,$status,$result);
        }
        
    }
}