<?php

class CategoriesController extends BaseController {

	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('admin');
	}

	public function getIndex() {
		return View::make('categories.index')
			->with('categories', Category::all());
	}

	public function postCreate() {
		$validator = Validator::make(Input::all(), Category::$rules);

		if ($validator->passes()) {
			$category = new Category;
			$category->name = Input::get('name');
			$category->save();

			return Redirect::to('admin/categories/index')
				->with('message', 'Category Created');
		}

		return Redirect::to('admin/categories/index')
			->with('message', 'Something went wrong')
			->withErrors($validator)
			->withInput();
	}

	public function postDestroy() {
		$category = Category::find(Input::get('id'));

		if ($category) {
			$category->delete();
			return Redirect::to('admin/categories/index')
				->with('message', 'Category Deleted');
		}

		return Redirect::to('admin/categories/index')
			->with('message', 'Something went wrong, please try again');
	}

	private function isCategoryIdExist($id) {
		$category = Category::find($id);
		if ($category) return true;
		return false;	
	}

	public function getShow() {
		$id = Input::get('id');
		if ( ! $this->isCategoryIdExist($id) ) {
			return Redirect::to('admin/categories');
		}

		$category = Category::find($id);
		return View::make('categories/show')->with('category', $category);
	}

	public function postUpdate() {
		$id = Input::get('id');

		$validator = Validator::make(Input::only('name'), Category::$rules);

		if ($validator->passes()) {
			$category = Category::find($id);
			$category->name = Input::get('name');
			$category->save();

			return Redirect::to('admin/categories')
				->with('message', 'Category updated');
		}

		return Redirect::to('admin/categories/show/'.$id)
				->with('message', 'Something went wrong')
				->withErrors($validator)
				->withInput();
	}
}