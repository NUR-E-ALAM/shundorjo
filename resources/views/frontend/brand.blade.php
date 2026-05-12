@extends('frontend.layouts.app')

@section('title')
   All Authorized Brands
@stop
@section('css')
<style>
    .background-image{
    background-position: center center !important;
    background-attachment: fixed !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
}
</style>
    <link type="text/css" href="{{ asset('frontend/css/extra.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('frontend/css/doctor.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        {{-- brand start --}}
        <div class="row">
            <div class="single_section">
                <div class="col-md-12 col-sm-12 padding_3">
                    <div class="row">
                        <div class="col-md-12 background-image"  style="color:white; background-image: url('{{ asset('frontend/images/Banner-4.jpg') }}'); ">
                            <div class="" style="margin: 3%">
                                <h2 class="text-center">All Authorized Brands</h2>
                            </div>
                        </div>
                        @foreach ($brands as $brand)
                            <div class="col-lg-2 col-md-4 col-sm-6 brandmob p-1">
                                <a href="{{ route('search', ['slug' => Str::slug($brand->name),'brand_id' => $brand->id]) }}">
                                    <div class="single_item">
                                        <img data-src="{{ asset($brand->logo) }}" class="img-thumbnail lazyload" alt="{{$brand->name}}">

                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- brand end --}}



    </div>
@endsection
@section('script')

@endsection
