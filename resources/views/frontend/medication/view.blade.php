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
                <div class="dropdown">
                    <a class="btn dropdown-toggle profile-manage" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(!empty(Auth::user()->avatar_original))
                        <img src="{{asset(Auth::user()->avatar_original)}}" alt="">
                        @else
                            <img src="{{asset('uploads/1.jpg')}}" alt="">
                        @endif
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('profile') }}"><span class="iconify"
                                data-icon="carbon:user-avatar"></span> Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><span class="iconify"
                                data-icon="ion:log-out-outline"></span> Log Out</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-content">

            <section class="profile">
                <div class="title-section">
                    <span class="iconify mr-1" data-icon="fontisto:prescription"></span> View Medication
                </div>
                <div class="infoBox mt-3">
                    <div class="row col-lg-12 p-0 mx-auto">
                        <div class="col-lg-10 mx-auto">
                            <form class="form-custom" action="">
                                <div class="row shadow-sm">
                                    <div class="col-lg-6 col-md-6 bg-white border-right">
                                        <div class="form-container  pt-4">
                                            <div class="form-group mb-1">
                                                <label>User Name</label>
                                                <input type="text" class="form-control" placeholder="User name" readonly value="{{ json_decode($medication->shipping_address)->name }}">
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group mb-1">
                                                    <label>Email</label>
                                                    <input type="Email" class="form-control"
                                                        placeholder="User email" value="{{ json_decode($medication->shipping_address)->email }}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group mb-1">
                                                    <label>Phone No</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Phone number" readonly value="{{ json_decode($medication->shipping_address)->phone }}">
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label>Postal Code</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Postal code" readonly value="{{ json_decode($medication->shipping_address)->post_code }}">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group mb-1">
                                                    <label>Address</label>
                                                    <textarea class="form-control" rows="2" readonly
                                                        placeholder="Address here ...">{{ json_decode($medication->shipping_address)->address }}, {{ json_decode($medication->shipping_address)->area }}-{{ json_decode($medication->shipping_address)->city }}, {{ json_decode($medication->shipping_address)->region }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 bg-white">
                                        <div class="form-container pt-5">
                                            <table>
                                                <tr>
                                                    <td class="w-50"><small>Invoice #</small></td>
                                                    <td class="w-50">
                                                        <input type="text" class="px-1 py-1 mb-3 form-control"
                                                            value="{{ $medication->code }}" readonly />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50"><small>Delivery Date</small></td>
                                                    <td class="w-50"><input type="text" class="form-control mb-3"
                                                            id="" readonly value="{{ $medication->upcoming_date }}"></td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50"><small>Medication Period</small></td>
                                                    <td class="w-50">
                                                        @php
                                                            $preiod = App\Models\User::find($medication->user_id)->preiod;
                                                        @endphp
                                                        <input type="text" name=""  class="form-control mb-3" value="{{$preiod}} Days" readonly id="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50">
                                                        <small>Amount Due</small>
                                                    </td>
                                                    <td class="w-50 text-right">
                                                        <input type="text" class=" py-1 form-control mb-3"
                                                            value="{{ single_price($medication->medicationDetails->sum('price') + $medication->medicationDetails->sum('tax') + $medication->shipping_cost) }}" readonly />
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- <button type="submit"  class="text-white btn-theme float-right mb-3">Update Password
                                            </button> -->

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row col-lg-12 p-0 mx-auto">
                        <div class="col-lg-10 mx-auto">
                            <form class="form-custom " action="">
                                <div class="row shadow-sm">
                                    <div class=" col-md-12 bg-white p-0">
                                        <div class="form-container">
                                            <div class="overflow mx-auto" >
                                                <table class="table table-custom shadow-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Item</th>
                                                            <th>Quantity </th>
                                                            <th>Unit Cost</th>
                                                            <th>Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="inner">
                                                        @foreach ($medication->medicationDetails as $key => $medicationDetail)
                                                        <tr>
                                                            <td width="200px">
                                                                <strong><a href="{{ route('product', $medicationDetail->product->slug) }}" target="_blank">{{ \App\Models\Product::where('id', '=', $medicationDetail->product_id )->first()->name }}</a></strong>
                                                        <!--<small>{{ $medicationDetail->variation }}</small>-->
                                                        <!--<small>{{ \App\Models\Product::where('id', '=', $medicationDetail->product_id )->first()->name }}</small>-->
                                                            </td>
                                                            <td>
                                                                {{ $medicationDetail->quantity }}
                                                            </td>
                                                            <td>
                                                                {{ single_price($medicationDetail->price/$medicationDetail->quantity) }}
                                                            </td>
                                                            <td style="width:85px;">
                                                                <span>{{ single_price($medicationDetail->price) }}</span>
                                                            </td>
                                                        </tr>
                                                        @endforeach

                                                        {{-- <tr>
                                                            <td colspan="4">
                                                                <span type="submit"
                                                                    class="text-white btn-theme add-row"> + Medicine
                                                                </span>
                                                            </td>
                                                        </tr> --}}

                                                        <tr>
                                                            <td></td>
                                                            <td colspan="3" class="text-right">
                                                                <strong> Subtotal : </strong>
                                                                {{ single_price($medication->medicationDetails->sum('price')) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td colspan="3" class="text-right">
                                                                <strong> Shipping Cost : </strong>
                                                                <span>{{ single_price($medication->shipping_cost) }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td colspan="3" class="text-right">
                                                                <strong>Total : </strong>
                                                                {{ single_price($medication->medicationDetails->sum('price') + $medication->medicationDetails->sum('tax') + $medication->shipping_cost) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                        
                                                 <a class="text-white btn-theme float-right mb-3" href="{{route('usermedication.edit', encrypt($medication->user_id))}}">{{__('Edit Medication')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </div>
</div>

@endsection

