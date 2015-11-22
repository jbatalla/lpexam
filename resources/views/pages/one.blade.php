@extends('layouts.master')

@section('content')


<section id="home">
    <div class="container">
        <h3>About</h3>
            <p>The system is a basic setup of a warehouse. Validation and security measures are still needed to the forms used. Basic dropdown input are used when creating orders. Framework used is Laravel 5. Datase used is an sqlite which can be found in /database folder (lpexam.sqlite). Migration is also used to create database specially the basic table. but for more complex table and from time to time update I directly created using an sqlite GUI. Several classes were also used that is found in the composer file.</p>
        <h3>System scalability for much larger warehouse</h3>
            <p>For more scalability of the database it needs a different database like MySql, MSSQL or any other database that can handle large volume. For speed proper indexing and optimizing of table are also required. Relational data model is also important to provide method for specific queries. </p>
    </div>
</section>    


@endsection