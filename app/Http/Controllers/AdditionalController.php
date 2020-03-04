<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Helpers\Konstanta;
use App\myModel\MasterAdditional;
use Illuminate\Support\Facades\Storage;

class AdditionalController extends Controller{
    public function index(Request $request){
        $type = $request->input('type');
        $result = MasterAdditional::where('type',$type)->first();
        $code   =Konstanta::$success_code;
        $message=Konstanta::$success_message;
        $status = true;
        return responseResult($code,$message,$status,$result);
    }
}