@extends('frontend.layouts.app')
@section('title')
    Checkout
@stop
@section('content')
    <div id="page-content">
        <section class="slice-xs sct-color-2 border-bottom">
            <div class="container container-sm">
                <div class="row cols-delimited">
                    <div class="col-4">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon mb-0">
                                <i class="icon-hotel-restaurant-105"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">1. {{__('My Cart')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="icon-block icon-block--style-1-v5 text-center active">
                            <div class="block-icon mb-0">
                                <i class="icon-finance-067"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">2. {{__('Shipping info')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon c-gray-light mb-0">
                                <i class="icon-finance-059"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">3. {{__('Payment')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-4 gry-bg">
            <div class="container">
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-8">
                    <form action="{{ route('default.shipping.update') }}" method="POST">
                        @csrf
                        <div class="card no-border">

                            <table class="table table-sm table-hover table-responsive-md">
                                <thead>
                                    <tr>
                                        <th>{{ __('Full Name') }}</th>
                                        <th>{{ __('Address') }}</th>
                                        <th>{{ __('Region') }}</th>
                                        <th>{{__('Phone')}}</th>
                                        <th>{{__('Action')}}</th>
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
                                           <td>{{ $data->address }}</td>
                                           <td>{{ $region }},{{ $city }},{{ $area }}-{{$data->post_code}}</td>
                                           <td>{{ $data->phone }}</td>
                                           <td>
                                            <input type="radio" name="default" value="{{$data->id}}" @if(Auth::user()->shipping_address==$data->id) checked @endif>
                                           </td>
                                       </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                        <input type="text" name="exchange" value="exchange" readonly hidden>

                        <div class="text-right mt-4">
                            <input type="submit" value="Save" class="btn btn-styled btn-base-1">
                        </div>
                    </form>
                </div>


                <div class="col-lg-4 ml-lg-auto">
                    @include('frontend.partials.cart_summary')
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')
    <script type="text/javascript">
    function getPaymentInfo(){
        var isValid = true;
        $('.card-body input').each(function() {
            if ( this.value == '' ){
                isValid = false;
            }
        });

        if(isValid){
            //console.log($('#shipping_form').serialize());
             $.ajax({
                type:"POST",
                url:'{{ route('checkout.payment_info') }}',
                data: $('#shipping_form').serialize(),
                success: function(data){
                    $('#page-content').html(data);
                }
            });
        }
        else{
            alert('Please fill all the fileds');
        }
    }
    </script>


@endsection
