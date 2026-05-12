@extends('frontend.layouts.app')
@section('title')
    Wallet
@stop
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
            <section class="profile">
                <div class="title-section">
                    <span class="iconify mr-1" data-icon="et:wallet"></span> My Wallet
                </div>
                <div class="infoBox mt-3">
                    <div class="row col-lg-12 mx-auto">
                        <div class="col-lg-11 mx-auto">
                            {{-- <form class="form-custom mt-4" action=""> --}}
                            <div class="row shadow-sm">
                                <div class="col-lg-4 col-md-6 bg-white border-right">
                                    <div class="form-container text-center wallet-status">
                                        <img class="img-fluid mt-5 " src="{{asset('frontend/images/images/wallet.svg')}}" alt="">
                                        <div class="amount">{{ single_price(Auth::user()->balance) }} <br> <span>In your wallet</span></div>

                                    <!-- <button class=" rechrg-wallet wow pulse" data-wow-duration="1s" data-wow-iteration="100" onclick="show_wallet_modal()">-->
                                    <!--    <span class="iconify" data-icon="tabler:currency-taka"></span>-->
                                    <!--    Recharge Wallet-->
                                    <!--</button>-->
                                    {{-- <div class="ml-4"><button class="btn btn-base-1" onclick="show_wallet_modal()">{{__('Recharge Wallet')}}</button></div> --}}

                                    </div>

                                </div>
                                <div class="col-lg-8 col-md-6 bg-white">
                                       <div class="form-container pt-5">
                                           <div style="overflow-x: auto;">
                                        <table class="table table-custom shadow-sm">
                                            <thead>
                                                <tr>
                                                    <th>#Sl</th>
                                                    <th>date</th>
                                                    <th>amount</th>
                                                    <th>Payment method</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($wallets as $key => $wallet)
                                       <tr>
                                           <td>{{ $key+1 }}</td>
                                           <td>{{ date('d-m-Y', strtotime($wallet->created_at)) }}</td>
                                           <td>{{ single_price($wallet->amount) }}</td>
                                           <td>{{ ucfirst(str_replace('_', ' ', $wallet ->payment_method)) }}</td>
                                       </tr>
                                   @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="pagination-wrapper py-4">
                                            <ul class="pagination justify-content-end">
                                                {{ $wallets->links() }}
                                            </ul>
                                        </div>
                                       </div>
                                </div>
                            </div>
                        {{-- </form> --}}
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
</div>

    <div class="modal fade" id="wallet_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title strong-600 heading-5">{{__('Recharge Wallet')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('wallet.recharge') }}" method="post">
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
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{__('Payment Method')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <select class="form-control selectpicker" style="width: 100%" data-minimum-results-for-search="Infinity" name="payment_option">
                                        <option value="sslcommerz">{{__('SSLCommerz')}}</option>
                                    </select>
                                </div>
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
        function show_wallet_modal(){
            $('#wallet_modal').modal('show');
        }
    </script>
@endsection
