@extends('layouts.main')

@section('search-keyword')

	<hr>
	<section id="search-keyword">
        <h1>Search Results for <span>{{ $keyword }}</span></h1>
    </section><!-- end search-keyword -->

@stop

@section('content')

	<div id="search-results">
        
        @if(count($products) > 0)
    		@foreach($products as $product)
            <div class="product">
                <a href="/store/view/{{ $product->id }}">
                	{{ HTML::image($product->image, $product->title, array('class'=>'feature', 'width'=>'240', 'height'=>'127')) }}
                </a>

                <h3><a href="/store/view/{{ $product->id }}">{{ $product->title }}</a></h3>

                <p>{{ $product->description }}</p>

                <h5>
                	Availability: 
                	<span class="{{ Availability::displayClass($product->availability) }}">
                		{{ Availability::display($product->availability) }}
                	</span>
                </h5>

                <p>
                    {{ Form::open(array('url'=>'cart/create')) }}
                    {{ Form::hidden('quantity', 1) }}
                    {{ Form::hidden('id', $product->id) }}
                    {{ Form::hidden('price', $product->price) }}
                    
                    @if($product->availability == 0)
                        <button type="submit" class="cart-btn" style="cursor:not-allowed;" disabled>
                            <span class="price">{{ $product->price }}</span> 
                            {{ HTML::image('img/white-cart.gif', 'Add to Cart') }} 
                            ADD TO CART
                        </button>
                    @else
                        <button type="submit" class="cart-btn">
                            <span class="price">{{ $product->price }}</span> 
                            {{ HTML::image('img/white-cart.gif', 'Add to Cart') }} 
                            ADD TO CART
                        </button>
                    @endif

                    {{ Form::close() }}
                </p>
            </div>
            @endforeach
        @else
            <b class="empty-result">No available product to display!</b>
        @endif

	</div><!-- end search-results -->

@stop