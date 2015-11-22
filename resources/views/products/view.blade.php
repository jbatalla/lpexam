@extends('layouts.master')

@section('content')

	<section id="products">
	    <div class="container">
	        <h2>ProductS</h2>

	        <br><br>
	        <div class="container-fluid table-striped " style="border: solid 1px #f0f0f0; border-radius: 10px; ">
	        	<div class="row" style="background-color: #f0f0f0; border-top-left-radius: 10px; border-top-right-radius: 10px;">
	        		<div class="col-xs-6 col-sm-3"><b>Product Name</b></div>
	        		<div class="col-xs-6 col-sm-6"><b>Product Description</b></div>
	        		<div class="col-xs-6 col-sm-1"><b>Product Price</b></div>
	        		<div class="col-xs-6 col-sm-1"><b>Stock Level</b></div>
	        		<div class="col-xs-6 col-sm-1"><b>Bin Location</b></div>
	        	</div>
				    @foreach ($products as $product)
				    	<div class="row">
			            <div class="col-xs-6 col-sm-3">{{ $product->product_name }}</div>
			            <div class="col-xs-6 col-sm-6">{{ $product->product_description }}</div>
			            <div class="col-xs-6 col-sm-1">{{ $product->price }}</div>
			            <div class="col-xs-6 col-sm-1">{{ $product->stock_level }}</div>
			            <div class="col-xs-6 col-sm-1">{{ $product->bin_location }}</div>
			            </div>
				    @endforeach	
			</div>
			<div class="row"><div class="col-xs-6 col-sm-8"></div><div class="col-xs-6 col-sm-4" style="text-align:right;">{!! $products->render() !!}</div></div>
	    </div>
	</section>

@endsection