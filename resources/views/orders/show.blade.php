@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css') }}">

	<br><br><br>
	<section id="ordersview">
	    <div class="container">
	        <h2>Order #: {{ $id }}</h2>

	        <div class="row"><div class="col-xs-6 col-sm-10"><a class="btn btn-primary" href="/orders" role="button">Back</a></div><div class="col-xs-6 col-sm-2" style="text-align:right;"></div></div>
	        <br>

	        @if($info)
		        <div class="container">
		        	<div class="row">
		        		<div class="col-xs-6 col-sm-1">Name:</div>
		        		<div class="col-xs-6 col-sm-11"><b>{{ $info['name'] }}</b></div>        	
		        	</div>
		        	<div class="row">
		        		<div class="col-xs-6 col-sm-1">Email:</div>
		        		<div class="col-xs-6 col-sm-11"><b>{{ $info['email'] }}</b></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-xs-6 col-sm-1">Address:</div>
		        		<div class="col-xs-6 col-sm-11"><b>{{ $info['address'] }}</b></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-xs-6 col-sm-1">Amount:</div>
		        		<div class="col-xs-6 col-sm-11"><b>{{ $info['total'] }}</b></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-xs-6 col-sm-1">Route:</div>
		        		<div class="col-xs-6 col-sm-11"><b>{!! $info['route'] !!}</b></div>
		        	</div>
		        </div><br>
	        @endif

	        <div class="container-fluid table-striped" style="border: solid 1px #f0f0f0; border-radius: 10px; ">
	        	<div class="row" style="background-color: #f0f0f0; border-top-left-radius: 10px; border-top-right-radius: 10px;">
	        		<div class="col-xs-6 col-sm-2"><b>Product SKU</b></div>
	        		<div class="col-xs-6 col-sm-4"><b>Product Name</b></div>
	        		<div class="col-xs-6 col-sm-2"><b>Product Price</b></div>
	        		<div class="col-xs-6 col-sm-2"><b>Picking Station</b></div>
	        		<div class="col-xs-6 col-sm-2"><b>Bin Location</b></div>

	        	</div>
	        		@if($order)
					    @foreach ($order as $prod)
					    	<div class="row">
				            <div class="col-xs-6 col-sm-2">{{ $prod->sku }}</div>
				            <div class="col-xs-6 col-sm-4">{{ $prod->product_name }}</div>
				            <div class="col-xs-6 col-sm-2">{{ $prod->product_price }}</div>
				            <div class="col-xs-6 col-sm-2">{{ $prod->picking_station }}</div>
				            <div class="col-xs-6 col-sm-2">{{ $prod->bin_location }}</div>

				            </div>
					    @endforeach						    
				    @endif					
			</div><br><br>
			
	        <pre>
	        <?php var_dump($pdi); ?>
	    	</pre>

		</div>
	</section>

@endsection