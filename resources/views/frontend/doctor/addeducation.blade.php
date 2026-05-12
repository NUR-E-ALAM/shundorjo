@extends('frontend.layouts.app')
@section('css')
    <link type="text/css" href="{{ asset('frontend/css/extra.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('frontend/css/doctor.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('frontend/css/doctor2.css') }}" rel="stylesheet">
@endsection
@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.doctor_side_nav')
                </div>
                <div class="col-lg-9">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            {{-- <div class="col-md-9 col-12">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{__('Dashboard ')}}{{__(' > Your Identityfication No : ')}}
                                    <input type="text" value="{{Auth::user()->cid}}" readonly id="myInput">
                                    <!-- The button used to copy the text -->
                                    <button onclick="myFunction()">Copy ID</button>
                                </h2>
                            </div> --}}
                            <div class="col-md-3 col-12">
                                <div class="float-md-left">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li class="active"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- dashboard content -->
                    {{-- education from show here  --}}
                        <div class="row">
                            <div class="order-xl-2 order-lg-2 col-xl-12 col-lg-8 col-md-12 col-12">
                                <div class="team-detail-box-layout1">

                                    @if($fromshow == 'About')
                                    <div class="single-item">
                                        <h3 class="section-title title-bar-primary2">About:</h3>
                                        <p></p>
                                    </div>
                                    <div class="single-item">
                                        <form action="{{ route('doctor.about.create') }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-box bg-white mt-4">
                                                <div class="form-box-content p-3">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('About')}}</label>
                                                            {{-- <input type="hidden" name="aboutid" value="{{ Auth::user()->id }}"> --}}
                                                        </div>
                                                        <div class="col-md-10">
                                                            <textarea class="form-control textarea-autogrow mb-3" placeholder="About" rows="5" name="about"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right mt-4">
                                                <button type="submit" class="btn btn-styled btn-base-1">{{__('Add')}}</button>
                                            </div>

                                        </form>
                                    </div>
                                    @endif

                                    @if($fromshow == 'Education')
                                    <div class="single-item">
                                        <h3 class="section-title title-bar-primary2">Add New Education:</h3>
                                        <p></p>
                                    </div>
                                    <div class="single-item">
                                        <form action="{{ route('doctor.education.create') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-box bg-white mt-4">
                                                <div class="form-box-content p-3">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Degree')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control mb-3" placeholder="{{__('Degree')}}" name="degree">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Institute')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control mb-3" placeholder="{{__('Institute')}}" name="institute">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Year')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="number" class="form-control mb-3" placeholder="{{__('Year')}}" name="year">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="text-right mt-4">
                                                <button type="submit" class="btn btn-styled btn-base-1">{{__('Add')}}</button>
                                            </div>

                                        </form>
                                    </div>
                                    @endif

                                    @if($fromshow == 'Experienced')
                                    <div class="single-item">
                                        <h3 class="section-title title-bar-primary2">Add New Experienced:</h3>
                                        <p></p>
                                    </div>
                                    <div class="single-item">
                                        <form action="{{ route('doctor.experience.create') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-box bg-white mt-4">
                                                <div class="form-box-content p-3">

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Year')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="number" class="form-control mb-3" placeholder="{{__('Year')}}" name="year">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Department')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control mb-3" placeholder="{{__('Department')}}" name="department">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Position')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control mb-3" placeholder="{{__('Position')}}" name="position">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Hospital')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control mb-3" placeholder="{{__('Hospital')}}" name="hospital">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="text-right mt-4">
                                                <button type="submit" class="btn btn-styled btn-base-1">{{__('Add')}}</button>
                                            </div>

                                        </form>
                                    </div>
                                    @endif


                                    @if($fromshow == 'Appointment')
                                    <div class="single-item">
                                        <h3 class="section-title title-bar-primary2">Add New Appointment:</h3>
                                        <p></p>
                                    </div>
                                    <div class="single-item">
                                        <form action="{{ route('doctor.appointment.create') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-box bg-white mt-4">
                                                <div class="form-box-content p-3">

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Day')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <select name="day" id="day" class="form-control mb-3" >
                                                                <option value="Saturday">Saturday</option>
                                                                <option value="Sunday">Sunday</option>
                                                                <option value="Monday">Monday</option>
                                                                <option value="Tuesday">Tuesday</option>
                                                                <option value="Wednesday">Wednesday</option>
                                                                <option value="Thusday">Thusday</option>
                                                                <option value="Friday">Friday</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Start Time')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <select name="time_start" id="time_start" class="form-control mb-3" required>
                                                                @foreach ($timeslot as $item)
                                                                <option value="{{ $item->slot}}">{{ $item->slot}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Patient Count')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="number" class="form-control mb-3" placeholder="{{__('Number of patient')}}" name="patient_count" required>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('Start Time')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="time" class="form-control mb-3" placeholder="{{__('Start Time')}}" name="time_start" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>{{__('End Time')}}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="time" class="form-control mb-3" placeholder="{{__('End Time')}}" name="time_end" required>
                                                        </div>
                                                    </div> --}}
                                                    
                                                </div>
                                            </div>
                                            <div class="text-right mt-4">
                                                <button type="submit" class="btn btn-styled btn-base-1">{{__('Add')}}</button>
                                            </div>

                                        </form>
                                    </div>
                                    @endif



                                </div>
                            </div>


                        </div>
                        {{-- end  --}}

                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
<script>
    function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the text: " + copyText.value);
}
</script>
@endsection
