<?php

namespace App\Helpers;

class Konstanta{

	public static $app_name = "API Felisa";
	public static $version_number = "0.1.1";
	public static $version_name = "Release Version";
	public static $version_update = "23 Juli 2019";
	public static $version_desc = "";
	public static $success_code = 200;
	public static $success_message = 'Success';
	public static $failed_code = 200;
	public static $failed_message = 'Bad request';
	public static $failed_query_message = 'There was an error in the query';
	public static $unauthorized_code = 401;
	public static $unauthorized_message = 'User unauthorized, please insert your token';
	public static $unauthorized_nik_message = 'User unauthorized, please insert your NIK';
	public static $notfound_code = 404;
	public static $notfound_message = 'Not found';
	public static $methodnotallowed_code = 405;
	public static $methodnotallowed_message = 'Your method HTTP is not allowed';
	public static $servererror_code = 500;
	public static $servererror_message = 'Server get some trouble';
	public static $expired_long_time_token = 7200; // 2 jam di detik
	public static $tokeninvalid = 202;
	public static $tokeninvalid_message = 'token_invalid';
	public static $tokenfailed = 201;
	public static $tokenfailed_message = 'token_failed';
	public static $url_checkTokenCharity = 'http://10.54.36.50/api-charity/check_token?token=';

	//Postel
	public static $url_postel = 'https://m2m.postel.go.id/m2mws/serviceList?WSDL';
	public static $api_client_id = 8071;
	public static $username = 'tsel';
	public static $password = 'tsel4321';
}