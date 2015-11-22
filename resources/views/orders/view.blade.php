@extends('layouts.master')

@section('content')
	<section id="orders">
	    <div class="container">
	        <h2>Orders List</h2>
	        
	        <div class="row"><div class="col-xs-6 col-sm-10"></div><div class="col-xs-6 col-sm-2" style="text-align:right;"><a class="btn btn-primary" href="orders/create" role="button">New Order</a></div></div>
	        <br>
	        <div class="container-fluid table-striped " style="border: solid 1px #f0f0f0; border-radius: 10px; ">
	        	<div class="row" style="background-color: #f0f0f0; border-top-left-radius: 10px; border-top-right-radius: 10px;">
	        		<div class="col-xs-6 col-sm-1"><b>Order ID</b></div>
	        		<div class="col-xs-6 col-sm-2"><b>Total Amount</b></div>
	        		<div class="col-xs-6 col-sm-2"><b>Name</b></div>
	        		<div class="col-xs-6 col-sm-3"><b>Email</b></div>
	        		<div class="col-xs-6 col-sm-4"><b>Address</b></div>

	        	</div>
	        		@if($orders)
					    @foreach ($orders as $order)
					    	<div class="row">
				            <div class="col-xs-6 col-sm-1"><a href="{{ url('/orders',$order->order_id) }}"> {{ $order->order_id }} </a></div>
				            <div class="col-xs-6 col-sm-2">{{ $order->totalAmount }}</div>
				            <div class="col-xs-6 col-sm-2">{{ $order->first_name }} {{ $order->last_name }}</div>
				            <div class="col-xs-6 col-sm-3">{{ $order->email }}</div>
				            <div class="col-xs-6 col-sm-4">{{ $order->address }}</div>
				            </div>
					    @endforeach						    
				    @endif
			</div>
			<div class="row"><div class="col-xs-6 col-sm-8"></div><div class="col-xs-6 col-sm-4" style="text-align:right;">{!! $orders->render() !!}</div></div>
		
		<br>
		<pre>
			Order No: {{ $order_no }} 
			<?php var_dump($xyValue) ?>
		</pre>

		</div>		
	</section>
@endsection