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
            

            <div class="card no-border mt-4">
                <table class="table table-sm table-hover table-responsive-md">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{__('Order No')}}</th>
                            <th>{{__('Earning Type')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Amount')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($trans as $key => $tran)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($tran->created_at)) }}</td>
                                <td>{{ $tran->order_id }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $tran ->earning_type)) }}</td>
                                <td>{{ $tran->status }}</td>
                                <td>{{ single_price($tran->amount) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
