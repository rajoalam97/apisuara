<?php

namespace App\myModel;

use Illuminate\Database\Eloquent\Model;

class MasterHistory extends Model{
	public $incrementing = true;
	public $timestamps = false;
	protected $table = 'history';
	protected $primaryKey = 'id';

}