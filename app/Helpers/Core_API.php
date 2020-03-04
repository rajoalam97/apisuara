<?php
use App\Helpers\Konstanta;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\myModel\App_token;
use App\myModel\MasterHistory;

function importXML($xmlRequest) {
    $ex = [];
    $content = NULL;

    $headers = array(
        "Content-type: text/xml"
    );

    try {
        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_PROXY, "10.73.99.142".':'."8080");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, Konstanta::$url_postel);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $xmlResponse = curl_exec($ch);

        if(curl_error($ch)) {
            $ex[] = [
                'code' => curl_errno($ch),
                'message' => curl_error($ch)
            ];
        } else {
            $content = xmlToObject($xmlResponse);
        }
    } catch (Exception $e) {
        $ex[] = [
            'code' => $e->getCode(),
            'message' => $e->getMessage()
        ];
    }
    curl_close($ch);

    return [
        'error' => $ex,
        'content' => $content
    ];
}
function xmlToObject($xmlResponse) {
    $contents = str_replace('<S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/"><S:Body><ns2:importXMLResponse xmlns:ns2="http://webservice.SPweb.Products.lsgermany.de/">', '', $xmlResponse);
    $content = str_replace('</ns2:importXMLResponse></S:Body></S:Envelope>', '', $contents);
    $object = new \SimpleXMLElement($content);

    return $object;
}
function post_content_url($url,$data){
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    
    try {
        $result = file_get_contents($url, false, $context);
    } catch (Exception $exc) {
        $exc->getTraceAsString();
        $result = [];
    }
    
    return $result;
}

function crypto_rand_secure($min, $max){
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}
function getToken($length){
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}
function downloadCSV($results,$nameFile){
    $headers = getFileResponseHeaders($nameFile);

    return streamFile(function () use ($results) {
        $output = fopen('php://output', 'w');
        foreach ($results as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
    }, $headers);
}
function streamFile($callback, $headers)
{
    $response = new StreamedResponse($callback, 200, $headers);
    $response->send();
}

function getFileResponseHeaders($filename)
{
    return [
        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        'Content-type'        => 'text/csv',
        'Content-Disposition' => 'attachment; filename='.$filename,
        'Expires'             => '0',
        'Pragma'              => 'public'
    ];
}
function check_token($nik){
    $token_result = App_token::where('user_nik',$nik)
            ->where('token_status','=','Active')
            ->first();
    return $token_result;
}
function update_token($tokenId){
    $update_exp = array('token_expired' => date('Y-m-d H:i:s', strtotime('+1 hour')),'token_updated'=>date('Y-m-d H:i:s'));
    App_token::where('token_id',$tokenId)->update($update_exp);
}
function insert_token($id,$token){
    $data_token = array('user_id' => $id,'token' => $token,'status'=>'Y','created_at' =>date('Y-m-d H:i:s'),'started' =>date('Y-m-d H:i:s'),'expired' => date('Y-m-d H:i:s', strtotime("+30 days")));
    App_token::insert($data_token);
}
function insert_history($id,$route,$type){
    $datas = array('user_id' => $id,'by' => 'mobile','type'=>$type,'action' =>$route,'history_on' =>date('Y-m-d H:i:s'));
    MasterHistory::insert($datas);
}
function responseNoresult($code,$message,$status){
    $response=[
        'code'=>$code,
        'message'=>$message,
        'status'=>$status,
        "data"=>null,
    ];
    return response()->json($response, $code)->setStatusCode($code, $message);
}
function responseResult($code,$message,$status,$result){
    $response=[
        'code'=>$code,
        'message'=>$message,
        'status'=>$status,
        "data"=>$result,
    ];
    return response()->json($response, $code)->setStatusCode($code, $message);
}
function responseResultJumlah($code,$message,$jumlah,$result){
    $response=[
        'meta'=>[
            'responseCode'=>$code,
            'responseStatus'=>$message,
            'jumlah'=>$jumlah
        ],
        'result'=>$result,

    ];
    return response()->json($response, $code)->setStatusCode($code, $message);
}
function check_token_charity($token){
    $url = Konstanta::$url_checkTokenCharity.$token;
    $respond = get_content_url($url);
    $responsecode = $respond->meta->responseCode;
    return $responsecode;
}
function get_content_url($url){
    $curlHandle = curl_init();
    curl_setopt($curlHandle, CURLOPT_URL, $url);
    curl_setopt($curlHandle, CURLOPT_HEADER, 0);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlHandle, CURLOPT_TIMEOUT, 60);
    $data = json_decode(curl_exec($curlHandle));
    if (curl_errno($curlHandle)){
      $message=curl_error($curlHandle);
      $data=[];
    }
    return $data;
    curl_close($curlHandle);
}