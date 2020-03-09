<?php

namespace App\myModel;

use Illuminate\Database\Eloquent\Model;

class MasterMagazine extends Model{
	public $incrementing = false;
	public $timestamps = false;
	protected $table = 'magazine';
	protected $primaryKey = 'id';

	public function data_rating(){
        return $this->hasMany('App\myModel\MasterRating', 'id_magazine', 'id');
    }

}