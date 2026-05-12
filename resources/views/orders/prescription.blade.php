@extends('layouts.app')
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
<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('orders.index.admin')}}" class="btn btn-rounded btn-info pull-right">{{__('Back')}}</a>
    </div>
</div>

<br>


<div class="photo-gallery">
    <div class="container">
        
        <div class="row photos">
            @foreach ($pimg as $item)
            <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="{{asset('uploads/prescription/'.$item->image)}}" data-lightbox="photos"><img class="img-fluid" src="{{asset('uploads/prescription/'.$item->image)}}"></a></div>
            @endforeach
            
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
@endsection
