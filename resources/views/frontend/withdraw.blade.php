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
            <div class="left-element">
                <div class="ml-4"><button class="btn btn-base-1" onclick="show_withdraw_modal()">{{__('Withdraw')}}</button></div>
            </div>
            <div class="row">
                <div class="col-4 mx-auto">
                    <div class="dashboard-widget text-center green-widget mt-4 c-pointer">
                        <a href="javascript:;" class="d-block">
                            <i class="fa fa-dollar"></i>
                            <span class="d-block title">{{ single_price(Auth::user()->balance) }}</span>
                            <span class="d-block sub-title">in your wallet</span>
                        </a>
                    </div>
                </div>
            </div>

        <div class="m-1">
           

            <div class="card no-border mt-4">
                <table class="table table-sm table-hover table-responsive-md">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{__('Amount')}}</th>
                            <th>{{__('Payment Status')}}</th>
                            <th>{{__('Delivery Status')}}</th>
                            <th>{{__('Withdraw Type')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($withdraws as $key => $withdraw)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($withdraw->created_at)) }}</td>
                                <td>{{ single_price($withdraw->amount) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $withdraw ->payment_status)) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $withdraw ->delivery_status)) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $withdraw ->withdraw_type)) }}</td>
                            </tr>
                        @endforeach
                       
                    </tbody>
                </table>
            </div>

        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="withdraw_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
        <div class="modal-content position-relative">
            <div class="modal-header">
                <h5 class="modal-title strong-600 heading-5">{{__('Withdraw')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="" action="{{ route('withdraw.cashout') }}" method="post">
                @csrf
                <div class="modal-body gry-bg px-3 pt-3">
                    <div class="row">
                        <div class="col-md-2">
                            <label>{{__('Amount')}} <span class="required-star">*</span></label>
                        </div>
                        <div class="col-md-10">
                            <input type="number" class="form-control mb-3" name="amount" placeholder="Amount" required>
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

@endsection

@section('script')
<script type="text/javascript">
    function show_withdraw_modal(){
        $('#withdraw_modal').modal('show');
    }
</script>
@endsection
