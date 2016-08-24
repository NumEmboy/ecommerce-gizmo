@extends('layouts.main')

@section('content')
	<aside id="my-account-menu">
        <h3>ACCOUNT</h3>
        <ul>
            <li>{{ HTML::link('users/accountinfo/'. $user->id, 'My Account') }}</li>
            <li>{{ HTML::link('', 'Order History') }}</li>
            <li>{{ HTML::link('users/signout', 'Sign Out') }}</li>
        </ul>
    </aside><!-- end my-account-menu -->

    <div id="personal-details">
        <h1>Personal Details</h1>

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

		{{ Form::open(array('url'=>'users/update')) }}

			{{ Form::hidden('id', $user->id) }}
			<p>
				{{  Form::label('firstname', '* FIRST NAME:') }}
				{{  Form::text('firstname', $user->firstname) }}
			</p>

			<p>
				{{  Form::label('lastname', '* LAST NAME:') }}
				{{  Form::text('lastname', $user->lastname) }}
			</p>

			<p>
				{{  Form::label('email', '* EMAIL ADDRESS:') }}
				{{  Form::text('email', $user->email) }}
			</p>

			<p>
				{{  Form::label('telephone', '* TELEPHONE:') }}
				{{  Form::text('telephone', $user->telephone) }}
			</p>

			<p>Fields marked with <span class="required-field">*</span> are required.</p>

			<hr>
		{{ Form::submit('UPDATE ACCOUNT', array('class'=>'secondary-cart-btn')) }}
		{{ Form::close() }}

    </div><!-- end personal-details -->
@stop