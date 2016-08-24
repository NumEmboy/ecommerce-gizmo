<?php

class Category extends Eloquent {

	protected $fillable = array('name');

	public static $rules = array('name'=>'required|min:3');

	protected $dates = ['deleted_at'];

	public function products() {
		return $this->hasMany('Product');
	}
}