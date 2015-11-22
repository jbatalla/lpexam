@extends('layouts.master')

@section('content')

<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Lato:400,900);  /* <-- Just for the demo, Yes I like pretty fonts... */

.square {
    float:left;
    position: relative;
    width: 7%;
    padding-bottom : 6%; /* = width for a 1:1 aspect ratio */
    margin:1.5%;
    background-position:top left;
    background-repeat:no-repeat;
    background-size:cover; /* you change this to "contain" if you don't want the images to be cropped */

}

.y1-x12,
.y2-x12,
.y3-x12,
.y4-x12,
.y5-x12,
.y6-x12,
.y7-x12,
.y8-x12,
.y9-x12,
.y10-x12,

.y1-x11,
.y4-x11,
.y7-x11,
.y10-x11

,.y1-x10
,.y4-x10
,.y7-x10
,.y10-x10

,.y1-x9
,.y4-x9
,.y7-x9
,.y10-x9

,.y1-x8
,.y4-x8
,.y7-x8
,.y10-x8
,.y1-x7
,.y4-x7
,.y7-x7
,.y10-x7
,.y1-x6
,.y4-x6
,.y7-x6
,.y10-x6
,.y1-x5
,.y4-x5
,.y7-x5
,.y10-x5
,.y1-x4
,.y4-x4
,.y7-x4
,.y10-x4
,.y1-x3
,.y4-x3
,.y7-x3
,.y10-x3
,.y1-x2
,.y4-x2
,.y7-x2
,.y10-x2
,.y1-x1
,.y4-x1
,.y7-x1
,.y10-x1


,.y1-x0
,.y3-x0
,.y4-x0
,.y6-x0
,.y7-x0
,.y9-x0
,.y10-x0
{background-color:#F3F3F3;}

.y2-x0
,.y5-x0
,.y8-x0
{background-color:blue;}

.y2-x11
,.y3-x11
,.y5-x11
,.y6-x11
,.y8-x11
,.y9-x11

,.y2-x10
,.y3-x10
,.y5-x10
,.y6-x10
,.y8-x10
,.y9-x10

,.y2-x9
,.y3-x9
,.y5-x9
,.y6-x9
,.y8-x9
,.y9-x9
,.y2-x8
,.y3-x8
,.y5-x8
,.y6-x8
,.y8-x8
,.y9-x8
,.y2-x7
,.y3-x7
,.y5-x7
,.y6-x7
,.y8-x7
,.y9-x7
,.y2-x6
,.y3-x6
,.y5-x6
,.y6-x6
,.y8-x6
,.y9-x6
,.y2-x5
,.y3-x5
,.y5-x5
,.y6-x5
,.y8-x5
,.y9-x5
,.y2-x4
,.y3-x4
,.y5-x4
,.y6-x4
,.y8-x4
,.y9-x4
,.y2-x3
,.y3-x3
,.y5-x3
,.y6-x3
,.y8-x3
,.y9-x3
,.y2-x2
,.y3-x2
,.y5-x2
,.y6-x2
,.y8-x2
,.y9-x2
,.y2-x1
,.y3-x1
,.y5-x1
,.y6-x1
,.y8-x1
,.y9-x1
{background-color:yellow;}


/*  following just for the demo */




</style>

<section id="home">
    <div class="container">
        <h2>Warehouse</h2>

            <div class="square y1-x12">
            </div>
            <div class="square y2-x12">
            </div>
            <div class="square y3-x12">
            </div>
            <div class="square y4-x12">
            </div>
            <div class="square y5-x12">
            </div>
            <div class="square y6-x12">
            </div>
            <div class="square y7-x12">
            </div>
            <div class="square y8-x12">
            </div>
            <div class="square y9-x12">
            </div>
            <div class="square y10-x12">
            </div>


            <div class="square y1-x11">
            </div>
            <div class="square y2-x11">
            </div>
            <div class="square y3-x11">
            </div>
            <div class="square y4-x11">
            </div>
            <div class="square y5-x11">
            </div>
            <div class="square y6-x11">
            </div>
            <div class="square y7-x11">
            </div>
            <div class="square y8-x11">
            </div>
            <div class="square y9-x11">
            </div>
            <div class="square y10-x11">
            </div>

            <div class="square y1-x10">
            </div>
            <div class="square y2-x10">
            </div>
            <div class="square y3-x10">
            </div>
            <div class="square y4-x10">
            </div>
            <div class="square y5-x10">
            </div>
            <div class="square y6-x10">
            </div>
            <div class="square y7-x10">
            </div>
            <div class="square y8-x10">
            </div>
            <div class="square y9-x10">
            </div>
            <div class="square y10-x10">
            </div>            

            <div class="square y1-x9">
            </div>
            <div class="square y2-x9">
            </div>
            <div class="square y3-x9">
            </div>
            <div class="square y4-x9">
            </div>
            <div class="square y5-x9">
            </div>
            <div class="square y6-x9">
            </div>
            <div class="square y7-x9">
            </div>
            <div class="square y8-x9">
            </div>
            <div class="square y9-x9">
            </div>
            <div class="square y10-x9">
            </div>  

            <!--7-->
            <div class="square y1-x8">
            </div>
            <div class="square y2-x8">
            </div>
            <div class="square y3-x8">
            </div>
            <div class="square y4-x8">
            </div>
            <div class="square y5-x8">
            </div>
            <div class="square y6-x8">
            </div>
            <div class="square y7-x8">
            </div>
            <div class="square y8-x8">
            </div>
            <div class="square y9-x8">
            </div>
            <div class="square y10-x8">
            </div>  

            <!--6-->
            <div class="square y1-x7">
            </div>
            <div class="square y2-x7">
            </div>
            <div class="square y3-x7">
            </div>
            <div class="square y4-x7">
            </div>
            <div class="square y5-x7">
            </div>
            <div class="square y6-x7">
            </div>
            <div class="square y7-x7">
            </div>
            <div class="square y8-x7">
            </div>
            <div class="square y9-x7">
            </div>
            <div class="square y10-x7">
            </div>  

            <!--5-->
            <div class="square y1-x6">
            </div>
            <div class="square y2-x6">
            </div>
            <div class="square y3-x6">
            </div>
            <div class="square y4-x6">
            </div>
            <div class="square y5-x6">
            </div>
            <div class="square y6-x6">
            </div>
            <div class="square y7-x6">
            </div>
            <div class="square y8-x6">
            </div>
            <div class="square y9-x6">
            </div>
            <div class="square y10-x6">
            </div>  

            <!--4-->
            <div class="square y1-x5">
            </div>
            <div class="square y2-x5">
            </div>
            <div class="square y3-x5">
            </div>
            <div class="square y4-x5">
            </div>
            <div class="square y5-x5">
            </div>
            <div class="square y6-x5">
            </div>
            <div class="square y7-x5">
            </div>
            <div class="square y8-x5">
            </div>
            <div class="square y9-x5">
            </div>
            <div class="square y10-x5">
            </div>  

            <!--3-->
            <div class="square y1-x4">
            </div>
            <div class="square y2-x4">
            </div>
            <div class="square y3-x4">
            </div>
            <div class="square y4-x4">
            </div>
            <div class="square y5-x4">
            </div>
            <div class="square y6-x4">
            </div>
            <div class="square y7-x4">
            </div>
            <div class="square y8-x4">
            </div>
            <div class="square y9-x4">
            </div>
            <div class="square y10-x4">
            </div>                                      

            <!--2-->
            <div class="square y1-x3">
            </div>
            <div class="square y2-x3">
            </div>
            <div class="square y3-x3">
            </div>
            <div class="square y4-x3">
            </div>
            <div class="square y5-x3">
            </div>
            <div class="square y6-x3">
            </div>
            <div class="square y7-x3">
            </div>
            <div class="square y8-x3">
            </div>
            <div class="square y9-x3">
            </div>
            <div class="square y10-x3">
            </div>  

            <!--1-->
            <div class="square y1-x2">
            </div>
            <div class="square y2-x2">
            </div>
            <div class="square y3-x2">
            </div>
            <div class="square y4-x2">
            </div>
            <div class="square y5-x2">
            </div>
            <div class="square y6-x2">
            </div>
            <div class="square y7-x2">
            </div>
            <div class="square y8-x2">
            </div>
            <div class="square y9-x2">
            </div>
            <div class="square y10-x9">
            </div>  

            <!--0-->
            <div class="square y1-x1">
            </div>
            <div class="square y2-x1">
            </div>
            <div class="square y3-x1">
            </div>
            <div class="square y4-x1">
            </div>
            <div class="square y5-x1">
            </div>
            <div class="square y6-x1">
            </div>
            <div class="square y7-x1">
            </div>
            <div class="square y8-x1">
            </div>
            <div class="square y9-x1">
            </div>
            <div class="square y10-x1">
            </div>                          

            <!--0-->
            <div class="square y1-x0">
            </div>
            <div class="square y2-x0">
            </div>
            <div class="square y3-x0">
            </div>
            <div class="square y4-x0">
            </div>
            <div class="square y5-x0">
            </div>
            <div class="square y6-x0">
            </div>
            <div class="square y7-x0">
            </div>
            <div class="square y8-x0">
            </div>
            <div class="square y9-x0">
            </div>
            <div class="square y10-x0">
            </div>

    </div>
</section>    

@endsection