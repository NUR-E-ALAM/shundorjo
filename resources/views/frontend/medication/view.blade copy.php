@extends('frontend.layouts.app')
@section('css')
<link rel='stylesheet' type='text/css' href="{{ asset('invoice/css/style.css')}}" />
<link href="{{ asset('css/active-shop.min.css')}}" rel="stylesheet">
<style>
.invoice-total {
	max-width:320px;
	float:right
}
.invoice-total>tbody>tr td {
	border:0 !important;
	text-align:right
}
.invoice-total>tbody>tr td:first-child {
	color:#4d627b
}
.invoice-total>tbody>tr td:last-child {
	width:200px
}
.invoice-total {
		width:auto
	}
</style>
@endsection
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
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 d-flex align-items-center">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        <a class="btn btn-success" href="{{route('usermedication.edit', encrypt($medication->user_id))}}">{{__('Edit')}}</a>
                                        {{-- <a class="btn btn-base-1 btn-danger" href="{{ url()->previous() }}">{{__('Back')}}</a> --}}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        {{-- start --}}
                        <div class="panel">
                            <div class="panel-body">

                                <div class="invoice-masthead">
                                    <div class="invoice-text">
                                        <h3 class="h1 text-thin mar-no text-primary">{{ __('medication Details') }}</h3>
                                    </div>
                                </div>

                                <div class="invoice-bill row">
                                    <div class="col-lg-6 text-xs-center">
                                        <address>
                                            <strong class="text-main">{{ json_decode($medication->shipping_address)->name }}</strong><br>
                                             {{ json_decode($medication->shipping_address)->email }}<br>
                                             {{ json_decode($medication->shipping_address)->phone }}<br>
                                             {{ json_decode($medication->shipping_address)->address }}, {{ json_decode($medication->shipping_address)->area }}-{{ json_decode($medication->shipping_address)->city }}-{{ json_decode($medication->shipping_address)->post_code }}, {{ json_decode($medication->shipping_address)->region }}
                                        </address>
                                    </div>
                                    <div class="col-lg-6 text-xs-center">
                                        <table class="invoice-details float-right">
                                        <tbody>
                                        <tr>
                                            <td class="text-main text-bold">
                                                {{__('medication #')}}
                                            </td>
                                            <td class="text-right text-info text-bold">
                                                {{ $medication->code }}

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-main text-bold">
                                                {{__('medication Preiod')}}
                                            </td>
                                            @php
                                                $preiod = App\Models\User::find($medication->user_id)->preiod;
                                            @endphp
                                            <td class="text-right">
                                                {{$preiod}} Days
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-main text-bold">
                                                {{__('medication Date')}}
                                            </td>
                                            <td class="text-right">
                                                {{ $medication->upcoming_date }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-main text-bold">
                                                {{__('Total amount')}}
                                            </td>
                                            <td class="text-right">
                                                {{ single_price($medication->medicationDetails->sum('price') + $medication->medicationDetails->sum('tax') + $medication->shipping_cost) }}
                                            </td>
                                        </tr>
                                        {{--  <tr>
                                            <td class="text-main text-bold">
                                                {{__('Payment method')}}
                                            </td>
                                            <td class="text-right">
                                                {{ ucfirst(str_replace('_', ' ', $medication->payment_type)) }}
                                            </td>
                                        </tr>  --}}
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr class="new-section-sm bord-no">
                                <div class="row">
                                    <div class="col-lg-12 table-responsive">
                                        <table class="table table-bmedicationed invoice-summary table-bordered">
                                            <thead>
                                                <tr class="bg-trans-dark">
                                                    <th class="min-col">#</th>
                                                    <th class="text-uppercase">
                                                        {{__('Description')}}
                                                    </th>
                                                    <th class="min-col text-center text-uppercase">
                                                        {{__('Qty')}}
                                                    </th>
                                                    <th class="min-col text-center text-uppercase">
                                                        {{__('Price')}}
                                                    </th>
                                                    <th class="min-col text-right text-uppercase">
                                                        {{__('Total')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($medication->medicationDetails as $key => $medicationDetail)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>
                                                            <strong><a href="{{ route('product', $medicationDetail->product->slug) }}" target="_blank">{{ $medicationDetail->product->name }}</a></strong>
                                                            <small>{{ $medicationDetail->variation }}</small>
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $medicationDetail->quantity }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ single_price($medicationDetail->price/$medicationDetail->quantity) }}

                                                        </td>
                                                        <td class="text-right">
                                                            {{ single_price($medicationDetail->price) }}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <div class="clearfix">
                                <table class="table borless invoice-total">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <strong>{{__('Sub Total')}} :</strong>
                                        </td>
                                        <td>
                                            {{ single_price($medication->medicationDetails->sum('price')) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>{{__('Tax')}} :</strong>
                                        </td>
                                        <td>
                                            {{ single_price($medication->medicationDetails->sum('tax')) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>{{__('Shipping')}} :</strong>
                                        </td>
                                        <td>
                                            {{ single_price($medication->shipping_cost) }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>{{__('TOTAL')}} :</strong>
                                        </td>
                                        <td class="text-bold h4">
                                            {{ single_price($medication->medicationDetails->sum('price') + $medication->medicationDetails->sum('tax') + $medication->shipping_cost) }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            </div>
                        </div>

                        {{-- end --}}

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

