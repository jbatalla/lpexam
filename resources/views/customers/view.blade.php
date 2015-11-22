@extends('layouts.master')

@section('content')
	<section id="customers">
	    <div class="container">
	        <h2>Customers List</h2>
	        <br><br>
	        <div class="container-fluid table-striped" style="border: solid 1px #f0f0f0; border-radius: 10px; ">
	        	<div class="row" style="background-color: #f0f0f0; border-top-left-radius: 10px; border-top-right-radius: 10px;">
	        		<div class="col-xs-6 col-sm-3"><b>First Name</b></div>
	        		<div class="col-xs-6 col-sm-3"><b>Last Name</b></div>
	        		<div class="col-xs-6 col-sm-3"><b>Email</b></div>
	        		<div class="col-xs-6 col-sm-3"><b>Address</b></div>
	        	</div>
        		@if($customers)
				    @foreach ($customers as $customer)
				    	<div class="row">
				            <div class="col-xs-6 col-sm-3">{{ $customer->first_name }}</div>
				            <div class="col-xs-6 col-sm-3">{{ $customer->last_name }}</div>
				            <div class="col-xs-6 col-sm-3">{{ $customer->email }}</div>
				            <div class="col-xs-6 col-sm-3">{{ $customer->address }}</div>
			            </div>
				    @endforeach
			    @endif			
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-8"></div>
				<div class="col-xs-6 col-sm-4" style="text-align:right;">{!! $customers->render() !!}</div>
			</div>
	    </div>
	</section>
@endsection