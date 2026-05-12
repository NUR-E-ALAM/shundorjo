@extends('frontend.layouts.app')

@section('title')
    All Doctor
@stop
@section('css')
    <link type="text/css" href="{{ asset('frontend/css/extra.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('frontend/css/doctor.css') }}" rel="stylesheet">
@endsection
@section('content')
<div style="background-color: #f1f7fa">
    <div class="container-custom" >
        <div class="row featuredContainer pt-5" id="no-equal-gallery">

            @foreach ($doctors as $data)
                <div class="no-equal-item col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="team-box-layout2">
                        <div class="item-img">
                            <img src="{{ $data->avatar_original ? asset($data->avatar_original) : asset('frontend/images/doctor/team8.png') }}" class="img-fluid" alt="">
                            {{-- <img src="{{ asset('frontend/images/doctor/team8.png') }}" alt="Team1"
                                class="img-fluid rounded-circle"> --}}
                            <ul class="item-icon">
                                <li><a href="{{ route('front.singledoctor', encrypt($data->id)) }}"><i class="fas fa-plus"></i></a></li>
                            </ul>
                        </div>
                        <div class="item-content">
                            <h3 class="item-title"><a href="{{route('front.singledoctor', encrypt($data->id))}}">{{ $data->name }}</a></h3>
                            <p>{{ $data->designation }}</p>
                        </div>
                        <div class="item-schedule">
                            <p><i class="fa fa-phone">{{ $data->phone }}</i></p>
                            <p><i class="fa fa-briefcase">
                                    @foreach ($data->doctordepartment as $item)
                                        {{ \App\Models\DocDepartment::where('id', '=', $item->dep_id)->first()->dep_name }}|
                                    @endforeach
                                </i></p>
                            <p><i class="fa fa-map-marker"> {{ $data->address }}</i></p>
                            <a href="{{route('front.singledoctor', encrypt($data->id))}}" class="item-btn">Doctor Details</a>
                        </div>
                    </div>
                </div>
            @endforeach





        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
