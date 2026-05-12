@extends('frontend.layouts.app')

@section('title')
    All Doctor
@stop
@section('css')
    <link type="text/css" href="{{ asset('frontend/css/extra.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('frontend/css/doctor.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('frontend/css/doctor2.css') }}" rel="stylesheet">
@endsection
@section('content')
<div style="background-color: #f1f7fa">
    <div class="container">
        <div class="row featuredContainer" id="no-equal-gallery">
            @foreach ($drdtl as $item)
            <section class="pt-5 pb-5 bg-light-accent100">
                <div class="row">
                    <div class="order-xl-2 order-lg-2 col-xl-9 col-lg-8 col-md-12 col-12">
                        <div class="team-detail-box-layout1">
                            <div class="single-item">
                                <h3 class="section-title title-bar-primary2">About Me:</h3>
                                <p>{{$item->about}}</p>
                            </div>
                            <div class="single-item">
                                <div class="table-responsive">
                                    <h3 class="section-title title-bar-primary2">Education:</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Year</th>
                                                <th>Degree</th>
                                                <th>Institute</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (\App\Models\DoctorEducation::where('user_id', $item->id)->where('status', 1)->get() as $key => $education)
                                            <tr>
                                                <td>{{$education->year}}</td>
                                                <td>{{$education->degree}}</td>
                                                <td>{{$education->institute}}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="single-item">
                                <div class="table-responsive">
                                    <h3 class="section-title title-bar-primary2">Experienced:</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Year</th>
                                                <th>Department</th>
                                                <th>Position</th>
                                                <th>Hospital</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (\App\Models\DoctorExperienced::where('user_id', $item->id)->where('status', 1)->get() as $key => $exp)
                                            <tr>
                                                <td>{{$exp->year}}</td>
                                                <td>{{$exp->department}}</td>
                                                <td>{{$exp->position}}</td>
                                                <td>{{$exp->hospital}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="single-item">
                                <div class="table-responsive">
                                    <h3 class="section-title title-bar-primary2">Appointmnet Schedules:</h3>
                                    <table class="table schedule-table">
                                        <thead>
                                            <tr>
                                                <th>Day</th>
                                                <th>Time</th>
                                                <th style="text-align: center">Patient</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (\App\Models\DoctorAppointmnet::where('user_id', $item->id)->where('status', 1)->get() as $key => $education)
                                            <tr>
                                                <td>{{$education->day}}</td>
                                                <td>{{$education->time_start}}</td>
                                                <td style="text-align: center">{{$education->patient_count}}</td>
                                                <td class="schedule-btn"><a href="{{route('front.appointment', encrypt($item->id))}}" class="item-btn">Appointment</a></td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-xl-1 order-lg-1 sidebar-widget-area sidebar-break-md col-xl-3 col-lg-4 col-md-12 col-12">
                        <div class="widget widget-about-team">
                            <img src="{{$item->avatar_original ? asset($item->avatar_original) : asset('frontend/images/doctor/team8.png')}}" class="img-fluid" alt="team">
                            <div class="item-content">
                                <h3 class="item-title">{{$item->name}}</h3>
                                <p class="item-ctg">{{$item->education}}</p>
                                <span class="item-designation">{{$item->designation}}</span>

                                {{-- <a href="" class="btn btn-success">Rating</a> --}}
                                @if (!empty(Auth::user()))
                                <div class="ml-4"><button class="btn btn-base-1" onclick="show_rating_modal()">{{__('Rating')}}</button></div>
                                @else
                                @endif

                            </div>
                        </div>
                        <div class="widget widget-team-contact">
                            <h3 class="section-title title-bar-primary2">Personal Info</h3>
                            <ul>
                                <li>Phone:<span>{{$item->phone}}</span></li>
                                {{-- <li>Office:<span>+ 88500-567</span></li> --}}
                                <li>E-mail:<span>{{$item->email}}</span></li>
                                <li class="d-flex">Social:
                                    <ul class="widget-social">
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="#"><i class="fab fa-skype"></i></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget-call-to-action">
                            <div class="media">
                                <img src="{{asset('frontend/images/doctor/1.png')}}" width="52px" height="57px" alt="figure">
                                <div class="media-body space-sm">
                                    <h4>Emergency Cases</h4>
                                    <span>2-800-700-6200</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
            @endforeach

            <div class="modal fade" id="rating_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
                    <div class="modal-content position-relative">
                        <div class="modal-header">
                            <h5 class="modal-title strong-600 heading-5">{{__('Rating')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="" action="{{ route('doctor.rating') }}" method="post">
                            @csrf
                            <div class="modal-body gry-bg px-3 pt-3">



                                {{-- <input hidden id="userid" value="@if(!empty(Auth::user()->id)){{Auth::user()->id}}@endif" class="form-control"> --}}

                                <input type="hidden" value="{{ $drid->id }}" name="dr_id">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>{{__('Select a rating')}}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <select class="form-control star-rating" name="rating" id="rating">
                                                <option value="">{{__('Select a rating')}}</option>
                                                <option value="5">{{__('Excellent')}}</option>
                                                <option value="4">{{__('Very Good')}}</option>
                                                <option value="3">{{__('Average')}}</option>
                                                <option value="2">{{__('Poor')}}</option>
                                                <option value="1">{{__('Terrible')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>{{__('Comment')}} <span class="required-star">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea name="comment" id="comment" cols="30" rows="10" required></textarea>
                                    </div>
                                </div>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('cancel')}}</button>
                                <button type="submit" class="btn btn-base-1">{{__('Confirm')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function show_rating_modal(){
        $('#rating_modal').modal('show');
    }
</script>
{{-- rating  --}}
<script src="{{ asset('js/star-rating.js') }}"></script>
<script>
    var stars = new StarRating('.star-rating');
</script>
@endsection
