@extends('layouts.main')

@section('content')

	<div id="admin">

		<h1>Products Admin Panel</h1><hr>

		<p>Here you can view, update, delete, and create new products.</p>

		<h2>Products</h2><hr>

		<ul>
			@if(count($products) > 0)
				@foreach($products as $product)
					<li>
						{{ HTML::image($product->image, $product->title, array('width'=>'50')) }} 
						{{ $product->title }} - 
						{{ Form::open(array('url'=>'admin/products/show', 'method'=>'get', 'class'=>'form-inline'))}}
						{{ Form::hidden('id', $product->id) }}
						<!-- {{ Form::select('availability', array('1'=>'In Stock', '0'=>'Out of Stock'), $product->availability) }} -->
						{{ Form::submit('update') }}
						{{ Form::close() }}

						|

						{{ Form::open(array('url'=>'admin/products/destroy', 'class'=>'form-inline')) }}
						{{ Form::hidden('id', $product->id) }}
						{{ Form::submit('delete') }}
						{{ Form::close() }}

					</li>
				@endforeach
			@else
				<b class="empty-result">Empty Product Results</b>
			@endif
		</ul>

		<h2>Create New Product</h2><hr>

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

		{{ Form::open(array('url'=>'admin/products/create', 'files'=>true)) }}
		<p>
			{{ Form::label('category_id', 'Category') }}
			@if(count($categories) > 0)
			{{ Form::select('category_id', $categories) }}
			@else
			<b style="color:red">*No Category Results</b>
			@endif
		</p>
		<p>
			{{ Form::label('title') }}
			{{ Form::text('title') }}
		</p>
		<p>
			{{ Form::label('description') }}
			{{ Form::textarea('description') }}
		</p>
		<p>
			{{ Form::label('price') }}
			{{ Form::text('price', null, array('class'=>'form-price')) }}
		</p>
		<p>
			{{ Form::label('image', 'Choose an image') }}
			{{ Form::file('image') }}
		</p>
		{{ Form::submit('Create Product', array('class'=>'secondary-cart-btn')) }}
		{{ Form::close() }}
	</div><!-- end admin -->

@stop