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

                        <div class="row">
                            {{-- <div class="col-md-5">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        {{__('Saved Shipping Info')}}
                                        <div class="float-right">
                                            <a href="{{ route('profile') }}" class="btn btn-link btn-sm">{{__('Edit')}}</a>
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">
                                        <table>
                                            <tr>
                                                <td>{{__('Address')}}:</td>
                                                <td class="p-2">{{ Auth::user()->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Country')}}:</td>
                                                <td class="p-2">
                                                    @if (Auth::user()->country != null)
                                                        {{ \App\Models\Country::where('code', Auth::user()->country)->first()->name }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{__('City')}}:</td>
                                                <td class="p-2">{{ Auth::user()->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Postal Code')}}:</td>
                                                <td class="p-2">{{ Auth::user()->postal_code }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Phone')}}:</td>
                                                <td class="p-2">{{ Auth::user()->phone }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}


                            <div class="order-xl-2 order-lg-2 col-xl-12 col-lg-8 col-md-12 col-12">
                                <div class="team-detail-box-layout1">
                                    <div class="single-item">
                                        <h3 class="section-title title-bar-primary2">About Me: @if(empty(Auth::user()->about))<button class="btn btn-base-1 float-md-right"><a href="{{ route('doctor.about')}}" style="color: white">Add New</a></button> @else <button class="btn btn-base-1 float-md-right"><a href="{{ route('doctor.about')}}" style="color: white">Edit</a></button> @endif</h3>
                                        <p>{{Auth::user()->about}}</p>
                                    </div>
                                    <div class="single-item">
                                        <div class="table-responsive">
                                            <h3 class="section-title title-bar-primary2">Education: <button class="btn btn-base-1 float-md-right"><a href="{{ route('doctor.addeducation')}}" style="color: white">Add New Education</a></button></h3>

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Year</th>
                                                        <th>Degree</th>
                                                        <th>Institute</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (\App\Models\DoctorEducation::where('user_id', Auth::user()->id)->where('status', 1)->get() as $key => $education)
                                                    <tr>
                                                        <td>{{$education->year}}</td>
                                                        <td>{{$education->degree}}</td>
                                                        <td>{{$education->institute}}</td>
                                                        <td>
                                                            <a href="{{ route('doctor.education.edit', encrypt($education->id))}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            <a href="{{ route('education.delete', encrypt($education->id))}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="single-item">
                                        <div class="table-responsive">
                                            <h3 class="section-title title-bar-primary2">Experienced: <button class="btn btn-base-1 float-md-right"><a href="{{ route('doctor.addexperience')}}" style="color: white">Add New Experienced</a></button></h3>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Year</th>
                                                        <th>Department</th>
                                                        <th>Position</th>
                                                        <th>Hospital</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (\App\Models\DoctorExperienced::where('user_id', Auth::user()->id)->where('status', 1)->get() as $key => $exp)
                                                    <tr>
                                                        <td>{{$exp->year}}</td>
                                                        <td>{{$exp->department}}</td>
                                                        <td>{{$exp->position}}</td>
                                                        <td>{{$exp->hospital}}</td>
                                                        <td><a href="{{ route('doctor.experience.edit', encrypt($exp->id))}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            <a href="{{ route('experience.delete', $exp->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="single-item">
                                        <div class="table-responsive">
                                            <h3 class="section-title title-bar-primary2">Appointmnet Schedules: <button class="btn btn-base-1 float-md-right"><a href="{{ route('doctor.addappointment')}}" style="color: white">Add New Appointmnet</a></button></h3>
                                            <table class="table schedule-table">
                                                <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>Time</th>
                                                        <th style="text-align: center">Patient Count</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (\App\Models\DoctorAppointmnet::where('user_id', Auth::user()->id)->where('status', 1)->get() as $key => $app)
                                                    <tr>
                                                        <td>{{$app->day}}</td>
                                                        <td>{{$app->time_start}}</td>
                                                        <td style="text-align: center">{{$app->patient_count}}</td>
                                                        <td>
                                                            <a href="{{ route('doctor.appointment.edit', encrypt($app->id))}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            <a href="{{ route('appointment.delete', $app->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
