@extends('layouts.main')

@section('content')
	
	<div id="admin">

		<h1>Products Admin Panel</h1><hr>

		<p>Here you can view, update, delete, and create new products.</p>

		<h2>Update Product</h2><hr>

		@if($errors->has())
		<div id="form-errors">
			<p>The following errors have occurred:</p>

			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div><!-- end form-errors -->
		@endif

		{{ Form::open(array('url'=>'admin/products/update', 'files'=>true)) }}

			{{ Form::hidden('id', $product->id) }}
		<p>
			{{ Form::label('category_id', 'Category') }}
			@if(count($categories) > 0)
			{{ Form::select('category_id', $categories, array('selected'=>$product->category_id)) }}
			@else
			<b style="color:red">*No Category Results</b>
			@endif
		</p>
		<p>
			{{ Form::label('title') }}
			{{ Form::text('title', $product->title) }}
		</p>
		<p>
			{{ Form::label('description') }}
			{{ Form::textarea('description', $product->description) }}
		</p>
		<p>
			{{ Form::label('price') }}
			{{ Form::text('price', $product->price, array('class'=>'form-price')) }}
		</p>
		<p>
			{{ Form::label('image', 'Current Image') }}
			{{ HTML::image($product->image, $product->title, array('width'=>'150')) }} 
		</p>
		<p>
			{{ Form::label('image', 'Change the image') }}
			{{ Form::file('image') }}
		</p>
		<p>
			{{ Form::label('availability') }}
			{{ Form::select('availability', array('1'=>'In Stock', '0'=>'Out of Stock'), $product->availability) }}
		</p>
		{{ Form::submit('Update Product', array('class'=>'secondary-cart-btn')) }}
		{{ Form::close() }}

	</div> <!-- end admin -->

@stop