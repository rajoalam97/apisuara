<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Helpers\Konstanta;
use App\myModel\MasterNews;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller{
    public function all(Request $request){
        $limit = $request->input('limit');
        if($limit==NULL){
            $limit = 1000;
        }
        $result = MasterNews::take($limit)->get();
        $code   =Konstanta::$success_code;
        $message=Konstanta::$success_message;
        $status = true;
        return responseResult($code,$message,$status,$result);
    }
}