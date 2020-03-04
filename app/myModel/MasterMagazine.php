<?php

namespace App\myModel;

use Illuminate\Database\Eloquent\Model;

class MasterMagazine extends Model{
	public $incrementing = false;
	public $timestamps = false;
	protected $table = 'magazine';
	protected $primaryKey = 'id';

}