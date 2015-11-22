@extends('layouts.master')

@section('content')

	<style type="text/css">
	.prdcts { 
		-webkit-appearance: menulist-button;
		width: 390px; height: 200pt; 
	}
	.cstmrs { 
		-webkit-appearance: menulist-button;
		width: 390px; 
	}
	</style>	

	<br><br><br>
	<section id="ordersnew">
	    <div class="container">
	        <h2>Create Order</h2>
	        
		    @include ('errors.list')

		    {!! Form::open(['action'=>'OrderController@store']) !!}
		    	<div class="form-group">
		    	{!! Form::label('customers', 'Select Customer') !!}<br>
			    	{!! Form::select('customers',$customers, null, array('class'=>'cstmrs') ) !!}
			    </div>

			    <div class="form-group">
			    {!! Form::label('products', 'Select Product') !!}<br>
			    	{!! Form::select('products', $products, null, array('size'=>'20', 'multiple'=>'multiple','name'=>'products[]','class'=>'prdcts')) !!}
				</div>

			    <div class="form-group">
			    {!! Form::submit('Submit Order') !!}
			    </div>
			{!! Form::close() !!}
			<br><br>
	    </div>
	</section>

@endsection