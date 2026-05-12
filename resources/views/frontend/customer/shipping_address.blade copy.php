@extends('frontend.layouts.app')

@section('content')
<style>

</style>

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                        @include('frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('frontend.inc.customer_side_nav')
                    @endif
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Address Book')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li class="active"><a href="{{ route('address.book') }}">{{__('Shipping Address')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

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
    </section>

@endsection

@section('script')

@endsection
