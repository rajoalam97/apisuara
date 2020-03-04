<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('additional', 'AdditionalController@index');
$router->group(['prefix' => 'user'], function($router) {
	$router->post('login', 'UserController@login');
});
$router->group(['middleware' => 'auth'], function($router) {
	$router->group(['prefix' => 'magazine'], function($router) {
		$router->get('all', 'MagazineController@all');
	});
	$router->group(['prefix' => 'news'], function($router) {
		$router->get('all', 'NewsController@all');
	});
});