@extends('layouts.main')

@section('content')
        
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

	<div id="shopping-cart">
    <h1>Shopping Cart & Checkout</h1>

    <!-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post"> -->
        <table border="1">
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php $ttl = 0 ?>
            <?php $data = []; $i = 1; $j = 1; $x = 1; ?>
            <?php
                foreach($products as $product) {
                    $data['title'][$i++] = $product->title;
                    $data['price'][$j++] = $product->price;
                    $data['img'][$x++] = $product->image;
                }
            ?>
            <?php $i = 1; $j = 1; $x = 1; $y = 1; ?>
            @foreach($cart as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    {{ HTML::image($data['img'][$x++], $data['title'][$y++], array('width'=>'50'))}}
                    {{ $data['title'][$i++] }}
                    
                </td>
                <td>
                    ${{ $price = $data['price'][$j++] }}
                </td>
                <td>
                    {{ Form::open(array('url'=>'cart/update')) }}
                    {{ Form::text('quantity', $item->quantity, array('maxlength'=>'2','class'=>'qty')) }}
                    {{ Form::hidden('id', $item->id) }}
                    {{ Form::hidden('price', $price) }}
                    <button style="border: 0px;background-color: transparent;">
                    {{ HTML::image('img/refresh.gif', 'Update', array('id'=>'update')) }}
                    </button>
                    {{ Form::close() }}

                </td>
                <td>
                    <?php $ttl += $item->total; ?>
                    ${{ $item->total }}
                    <a href="{{ url('cart/destroy', $item->id) }}">
                        {{ HTML::image('img/remove.gif', 'Remove') }}
                    </a>
                </td>
            </tr>
            @endforeach
            
            <tr class="total">
                <td colspan="5">
                    Subtotal: ${{ $ttl }}<br />
                    <span>TOTAL: ${{ $ttl }}</span><br />

                    {{ HTML::link('/', 'Continue Shopping', array('class'=>'tertiary-btn')) }}
                    <input type="submit" value="CHECKOUT WITH PAYPAL" class="secondary-cart-btn">
                </td>
            </tr>
        </table>
        <!-- </form> -->
    </div><!-- end shopping-cart -->

@stop