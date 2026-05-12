@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                    @include('frontend.inc.seller_side_nav')
                @elseif(Auth::user()->user_type == 'customer')
                    @include('frontend.inc.customer_side_nav')
                @elseif(Auth::user()->user_type == 'doctor')
                    @include('frontend.inc.doctor_side_nav')
                @endif
                </div>

                <div class="col-lg-9">
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

                        <div class="card no-border mt-4">
                            <form action="{{route('prescription.insert')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-box bg-white mt-4">
                                    <div class="ermsg">
                                    </div>
                                    <div class="form-box-title px-3 py-2">
                                        {{__('Add Prescription')}}
                                    </div>
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Message')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea class="form-control mb-3" name="message" id="message" value="" required></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Photo')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="file" class="form-control" id="uploadPrescriptionField"  multiple accept="image/*" max="5" capture="camera" name="image[]" required>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{-- <button type="submit" class="btn btn-info mt-3">Upload Prescription</button> --}}
                                    <button type="submit" class="btn btn-base-1">{{__('Upload')}}</button>
                                </div>
                            </form>
                        </div>


                        <div class="card no-border mt-4">
                            <table class="table table-sm table-hover table-responsive-md">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{__('Message')}}</th>
                                        <th>{{__('Prescription Image')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($prescriptions as $key => $data)
                                       <tr>
                                           <td>{{ $key+1 }}</td>
                                           <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                                           <td>{{ $data->patient_name }}</td>
                                           <td><img src="{{asset('uploads/prescription/'.$data->image)}}" height="50px" width="50px" alt=""></td>
                                           <td>
                                                <div class="btn-group dropdown">
                                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-left">
                                                        <li><a class="btn btn-base-1" href="{{ route('user.prescription.view', encrypt($data->id)) }}">{{__('View')}}</a></li>
                                                        {{-- <li><button class="btn btn-base-1 editBtn" id="editBtn" mid="{{ $data->id }}">{{__('Edit')}}</button></li> --}}

                                                        <li><a class="btn btn-base-1" onclick="confirm_modal('{{route('userprescription.destroy', $data->id)}}');">{{__('Delete')}}</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                       </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>


                        <div class="pagination-wrapper py-4">
                            <ul class="pagination justify-content-end">
                                {{-- {{ $wallets->links() }} --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('script')

    <script type="text/javascript">
        function show_prescription_modal(){
            $('#prescription_modal').modal('show');
        }
    </script>
@endsection
