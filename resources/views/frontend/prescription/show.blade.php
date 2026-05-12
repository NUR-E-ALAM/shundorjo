@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
@endsection

@section('content')

<style>
    .photo-gallery {
      color:#313437;
      background-color:#fff;
    }

    .photo-gallery p {
      color:#7d8285;
    }

    .photo-gallery h2 {
      font-weight:bold;
      margin-bottom:40px;
      padding-top:40px;
      color:inherit;
    }

    @media (max-width:767px) {
      .photo-gallery h2 {
        margin-bottom:25px;
        padding-top:25px;
        font-size:24px;
      }
    }

    .photo-gallery .intro {
      font-size:16px;
      max-width:500px;
      margin:0 auto 40px;
    }

    .photo-gallery .intro p {
      margin-bottom:0;
    }

    .photo-gallery .photos {
      padding-bottom:20px;
    }

    .photo-gallery .item {
      padding-bottom:30px;
    }

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
            <!-- <img src="images/logo.png" class="mobile-menu-logo"> -->
            <div class="right-element">
                <div class="dropdown">
                    <a class="btn dropdown-toggle profile-manage" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(!empty(Auth::user()->avatar_original))
                        <img src="{{asset(Auth::user()->avatar_original)}}" alt="">
                        @else
                            <img src="{{asset('uploads/1.jpg')}}" alt="">
                        @endif
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('profile') }}"><span class="iconify"
                                data-icon="carbon:user-avatar"></span> Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><span class="iconify"
                                data-icon="ion:log-out-outline"></span> Log Out</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-content">
            <div class="rows">

                <div class="main-content">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-12 d-flex align-items-center">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{__('Patient Prescription')}}
                                </h2>
                                {{-- <div class="ml-4"><button class="btn btn-base-1" onclick="show_prescription_modal()">{{__('Add Prescription')}}</button></div> --}}
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                        <li class="active"><a href="{{ route('prescription.index') }}">{{__('Patient Prescription')}}</a></li>
                                    </ul>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                         <a href="{{ route('prescription.index') }}" class="btn btn-info pull-right">{{__('Back')}}</a>
                        </div>
                    </div>



                    <div class="photo-gallery">
                        <div class="container">

                            <div class="row photos">
                                @foreach ($pimg as $item)
                                <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="{{asset('uploads/prescription/'.$item->image)}}" data-lightbox="photos"><img class="img-fluid" src="{{asset('uploads/prescription/'.$item->image)}}"></a></div>
                                @endforeach

                            </div>
                        </div>
                    </div>






                </div>

            </div>

        </div>
    </div>
</div>


@endsection

@section('script')


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
@endsection
