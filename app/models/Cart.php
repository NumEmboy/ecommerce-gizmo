<?php

class Cart extends Eloquent {

	protected $table = 'cart';

	protected $fillable = array('user_id','product_id','quantity','total');

	protected  $hidden = array('created_at','updated_at');

	public static $rules = array(
		'user_id'=>'integer',
		'product_id'=>'integer',
		'quantity'=>'integer',
		'total'=>'integer',
	);

	protected $dates = ['deleted_at'];
}