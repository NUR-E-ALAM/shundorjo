@extends('frontend.layouts.app')
@section('title')
   Track Your Shundorjo Order | Explore Premium Products Online Shop in Bangladesh
@stop
@section('content')

    <section class="gry-bg py-4">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <style>


.searchButton {
  width: 40px;
  height: 40px;
  border: 1px solid #00B4CC;
  background: #00B4CC;
  text-align: center;
  color: #fff;
  border-radius: 0 5px 5px 0;
  cursor: pointer;
  font-size: 20px;
}

/*Resize the wrap to see the search bar change!*/

        </style>
        

<div class="dashbaord-main">
    @if(Auth::user()->user_type == 'seller')
        @include('frontend.inc.seller_side_nav')
    @elseif(Auth::user()->user_type == 'customer')
        @include('frontend.inc.customer_side_nav')
    @elseif(Auth::user()->user_type == 'doctor')
        @include('frontend.inc.doctor_side_nav')
    @endif
    <div class="rightSection">
        <div class="topbar">
            <div class="fold" onclick='foldSidebar();'>
                <span class="iconify" data-icon="eva:menu-fill"></span>
            </div>
           

        </div>
        <div class="container">
            <div class="row">


                        <div class="col-md-12 col-xs-6">

                                <div class="card-header">
                                    <h4>Track Order</h4>
                                </div>

                                             {{-- search strt  --}}
                                            <form  action="{{route('product_truck.show')}}" method ="POST">
                                                @csrf
                                                <br>
                                                <div class="container-fluid" >
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <input type="text" class="form-control" style="margin-top: 2px;" id="code" name="code" required  placeholder="Track Order looking for Products?">
                                                        </div>
                                                        <div class="col-2">
                                                            <button type="submit" class="searchButton" name="search" title="Search">   <i class="fa fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </form>
                                            {{-- search end  --}}

                        </div>

            </div>

        </div>

    </section>

@endsection
