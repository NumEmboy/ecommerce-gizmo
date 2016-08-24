@extends('layouts.main')

@section('content')

	<div id="admin">

		<h1>Categories Admin Panel</h1><hr>

		<p>Here you can view, update, delete, and create new categories.</p>

		<hr>

		<h2>Update Category</h2><hr>

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

		{{ Form::open(array('url'=>'admin/categories/update')) }}
		<p>
			{{ Form::hidden('id', $category->id) }}
			{{ Form::label('name') }}
			{{ Form::text('name', $category->name) }}
		</p>
		{{ Form::submit('Update Category', array('class'=>'secondary-cart-btn')) }}
		{{ Form::close() }}

	</div>	<!-- end admin -->

@stop