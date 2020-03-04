<?php

namespace App\myModel;

use Illuminate\Database\Eloquent\Model;

class MasterNews extends Model{
	public $incrementing = false;
	public $timestamps = false;
	protected $table = 'news';
	protected $primaryKey = null;

}