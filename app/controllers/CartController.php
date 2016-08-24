<?php

class CartController extends \BaseController {

	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', ['only'=>['create','update','destroy']]);
	}
	
	private function isAuthenticated() {
		if(Auth::check()) {
			return true;
		}
		return false;
	}

	private function isOnCart($uId, $pId) {
		if( count(Cart::where('user_id','=', $uId)
			->where('product_id','=', $pId)->get()) === 0 ) {
			return false;
		}
		return true;
	}

	private function isAvailable($id) {
		$product = Product::find($id);
		if($product->availability == 1) {
			return true;
		}
		return false;
	}

	public function getIndex() {
		if( ! $this->isAuthenticated() ) {
			return Redirect::to('users/signin');
		}
		$user_id = Auth::user()->id;
		$cart = Cart::where('user_id', '=', $user_id)->get();

		$product = array();
		foreach($cart as $item) {
			$product[] = Product::find($item->product_id);
		}
		return View::make('store/cart')
			->with('cart', $cart)
			->with('products', $product);
	}

	public function postCreate() {
		if( ! $this->isAuthenticated() ) {
			return Redirect::to('users/signin');
		}

		$validator = Validator::make(Input::all(), Cart::$rules);

		$user_id = Auth::user()->id;
		$product_id = Input::get('id');
		$product_price = Input::get('price');
		$quantity = Input::get('quantity');
		$total = $quantity * $product_price;

		if ( ! $this->isAvailable($product_id) ){
			return Redirect::to('/')
				->with('message', 'You cannot add a product w/c is out of stock or currently unavailable');
		}

		if ( ! $this->isOnCart($user_id, $product_id) ) {
			if ($validator->passes()) {
				$cart = new Cart;
				$cart->user_id = $user_id;
				$cart->product_id = $product_id;
				$cart->quantity = $quantity;
				$cart->total = $total;
				$cart->save();
				return Redirect::to('cart/index')->with('message', 'Successfully added to cart');
			}
			return Redirect::to('cart/index')->with('message', 'Something went wrong');
		} else {
			
			$cart_id = 0;
			$cart = Cart::where('user_id','=', $user_id)
			->where('product_id','=', $product_id)->get();

			foreach ($cart as $item) {
				$cart_id = $item->id;
			}

			$get_cart = Cart::find($cart_id);
			$get_cart->quantity += $quantity;
			$get_cart->total = $get_cart->quantity * $product_price;
			$get_cart->save();
			return Redirect::to('cart/index')->with('message', 'Successfully added to cart');

		}

		// return Redirect::to('cart/index')->with('message', 'Already added on cart');

	}

	public function getDestroy($id) {
		$cart = Cart::find($id);

		if ($cart) {
			$cart->delete();
			return Redirect::to('cart/index')->with('message', 'Successfully removed from cart');
		}

		return Redirect::to('cart/index')->with('message', 'Something went wrong');
	}

	public function postUpdate() {
		if( ! $this->isAuthenticated() ) {
			return Redirect::to('users/signin');
		}

		$validator = Validator::make(Input::all(), [
			'id' => 'integer',
			'quantity'=> 'integer|min:1',
			'total' => 'integer'
		]);

		if ($validator->passes()) {
			$id = Input::get('id');
			$quantity = Input::get('quantity');
			$price = Input::get('price');
			$ttl = $quantity * $price;
			
			$cart = Cart::find($id);
			$cart->quantity = $quantity;
			$cart->total = $ttl;
			$cart->save();

			return Redirect::to('cart/index')->with('message', 'Successfully updated the products quantity');
		}

		return Redirect::to('cart/index')->withErrors($validator);
	}
}