@extends('frontend.layouts.app')

@section('content')
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
                <!--<div class="dropdown">-->
                <!--    <a class="btn dropdown-toggle profile-manage" href="#" role="button" id="dropdownMenuLink"-->
                <!--        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                <!--        @if(!empty(Auth::user()->avatar_original))-->
                <!--        <img src="{{asset(Auth::user()->avatar_original)}}" alt="">-->
                <!--        @else-->
                <!--            <img src="{{asset('uploads/1.jpg')}}" alt="">-->
                <!--        @endif-->
                <!--    </a>-->

                <!--    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">-->
                <!--        <a class="dropdown-item" href="{{ route('profile') }}"><span class="iconify"-->
                <!--                data-icon="carbon:user-avatar"></span> Profile</a>-->
                <!--        <a class="dropdown-item" href="{{ route('logout') }}"><span class="iconify"-->
                <!--                data-icon="ion:log-out-outline"></span> Log Out</a>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </div>
        <div class="dashboard-content">

        <div class="m-1">
            <div class="text-right mt-4">
                <a href="{{ route('default.shipping.address') }}"  class="btn btn-styled btn-base-1">{{__('Make default shipping address')}}</a>
                <a href="{{ route('default.billing.address') }}"  class="btn btn-styled btn-base-1">{{__('Make default billing address')}}</a>
            </div>

            <div class="card no-border mt-4">
                <table class="table table-sm table-hover table-responsive-md">
                    <thead>
                        <tr>
                            <th>{{ __('Full Name') }}</th>
                            <th>{{ __('Address') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{__('Phone')}}</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                       @foreach ($address as $key => $data)
                        @php
                        $region = \App\Models\Division::where('id', '=', $data->region)->first()->name;
                        $city = \App\Models\District::where('id', '=', $data->city)->first()->name;
                        $area = \App\Models\Upazila::where('id', '=', $data->area)->first()->name;
                        @endphp
                           <tr>
                               <td>{{ $data->name }}</td>
                               <td><span style="background-color: rgb(71, 196, 77); color:white">{{ $data->label }}</span> {{ $data->address }}, {{ $city }}-{{ $data->post_code }}, {{ $region }}</td>
                               <td>{{ $data->email }}</td>
                               <td>{{ $data->phone }}</td>
                               <td>
                                @if (($data->id == Auth::user()->billing_address) && ($data->id == Auth::user()->shipping_address))
                                Default Billing And Shipping Address
                                @elseif($data->id == Auth::user()->shipping_address)
                                     Default Shipping Address
                                @elseif($data->id == Auth::user()->billing_address)
                                Default Billing Address
                                @else

                                @endif
                            </td>
                               <td>
                                <a href="{{ route('address.edit', $data->id) }}" class="btn btn-base-1">{{__('edit')}}</a>
                                </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-4">
                <a href="{{ route('address.add') }}" class="btn btn-styled btn-base-1">{{__('Add Address')}}</a>
            </div>
        </div>




        </div>
    </div>
</div>

@endsection

@section('script')
<script>

  </script>
@endsection
