<?php

namespace App\myModel;

use Illuminate\Database\Eloquent\Model;

class MasterRating extends Model{
	public $incrementing = false;
	public $timestamps = false;
	protected $table = 'rating';
	protected $primaryKey = 'id';

	public function data_magazine(){
        return $this->belongsTo('App\myModel\MasterMagazine', 'id_magazine', 'id');
    }
    public function data_user(){
        return $this->belongsTo('App\myModel\MasterUser', 'user_id', 'user_id');
    }

}