<?php

namespace App\myModel;

use Illuminate\Database\Eloquent\Model;

class MasterUser extends Model{
	public $incrementing = false;
	public $timestamps = false;
	protected $table = 'master_user';
	protected $primaryKey = 'user_id';

}