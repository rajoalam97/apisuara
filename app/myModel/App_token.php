<?php

namespace App\myModel;

use Illuminate\Database\Eloquent\Model;

class App_token extends Model{
	public $incrementing = false;
	public $timestamps = false;
	protected $table = 'token_access';
	protected $primaryKey = 'id';

}