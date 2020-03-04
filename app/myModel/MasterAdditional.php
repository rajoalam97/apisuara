<?php

namespace App\myModel;

use Illuminate\Database\Eloquent\Model;

class MasterAdditional extends Model{
	public $incrementing = false;
	public $timestamps = false;
	protected $table = 'additional';
	protected $primaryKey = null;

}