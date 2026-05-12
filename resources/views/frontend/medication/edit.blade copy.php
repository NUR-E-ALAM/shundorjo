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
                                        <a class="btn btn-base-1 btn-danger" href="{{ route('usermedication.view')}}">Back</a>
                                    </h2>
                                </div>
                            </div>
                        </div>

                        {{-- start --}}
                        <div class="panel">
                            <div class="panel-body">
                                <form action="{{ route('usermedication.edit.update') }}" method="post">
                                    @csrf
                                <div class="invoice-masthead">
                                    <div class="invoice-text">
                                        <h3 class="h1 text-thin mar-no text-primary">{{ __('Medication Details') }}</h3>
                                    </div>
                                </div>

                                <div class="invoice-bill row">
                                    <div class="col-sm-6 text-xs-center">
                                        <address>
                                            <strong class="text-main">{{ json_decode($medication->shipping_address)->name }}</strong><br>
                                             {{ json_decode($medication->shipping_address)->email }}<br>
                                             {{ json_decode($medication->shipping_address)->phone }}<br>
                                             {{ json_decode($medication->shipping_address)->address }}, {{ json_decode($medication->shipping_address)->area }}-{{ json_decode($medication->shipping_address)->city }}-{{ json_decode($medication->shipping_address)->post_code }}, {{ json_decode($medication->shipping_address)->region }}
                                        </address>
                                    </div>
                                <div class="col-sm-6 text-xs-center">
                                        <input type="text" name="medication_id" id="" value="{{$medication->id}}" hidden>
                                        <input type="text" name="city" id="" value="{{ json_decode($medication->shipping_address)->city }}" hidden>
                                        <input type="text" name="user_id" id="" value="{{$medication->user_id}}" hidden>
                                        <table class="invoice-details">
                                            <tbody>
                                            <tr>
                                                <td class="text-main text-bold">
                                                    {{__('Invoice #')}}
                                                </td>
                                                <td class="text-right text-info text-bold">
                                                    {{ $medication->code }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-main text-bold">
                                                    {{__('medication Date')}}
                                                </td>
                                                <td><input type="date" name="date" value="{{Carbon\Carbon::parse($medication->upcoming_date)->format('Y-m-d')}}"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-main text-bold">
                                                    {{__('Medication Preiod')}}
                                                </td>
                                                <td><select name="preiod" id="">
                                                <option value="">Select Preiod</option>
                                                <option @if($user->preiod==7) selected @endif value="7">7 Days</option>
                                                <option @if($user->preiod==10) selected @endif value="10">10 Days</option>
                                                <option @if($user->preiod==15) selected @endif value="15">15 Days</option>
                                                <option @if($user->preiod==30) selected @endif value="30">30 Days</option>
                                                </select></td>
                                            </tr>

                                            {{-- <tr>
                                                <td class="text-main text-bold">
                                                    {{__('Payment method')}}
                                                </td>
                                                <td class="text-right">
                                                    {{ ucfirst(str_replace('_', ' ', $medication->payment_type)) }}
                                                </td>
                                            </tr> --}}
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                                <hr class="new-section-sm bord-no">
                                <div class="row">
                                    <div class="col-lg-12 table-responsive">
                                        <table class="table table-bmedicationed invoice-summary">
                                            <thead style="border-top: 1px solid;">
                                                <tr class="bg-trans-dark">

                                                    <th colspan="3" class="text-uppercase">
                                                        {{__('Description')}}
                                                    </th>
                                                    <th colspan="1" class="min-col text-center text-uppercase">
                                                        {{__('Price')}}
                                                    </th>
                                                    <th colspan="1" class="min-col text-center text-uppercase">
                                                        {{__('Qty')}}
                                                    </th>
                                                    <th colspan="1" class="min-col text-right text-uppercase">
                                                        {{__('Total')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($medication->medicationDetails as $key => $medicationDetail)
                                                <tr class="item-row">
                                                    <td colspan="3" class="item-name vehicle-type"><div class="delete-wpr">
                                                        <strong><a href="{{ route('product', $medicationDetail->product->slug) }}" target="_blank">{{ $medicationDetail->product->name }}</a></strong>
                                                        <small>{{ $medicationDetail->variation }}</small><input type="text" name="product_id[]" id="" value="{{$medicationDetail->product->id}}" hidden>
                                                        <a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
                                                    <td colspan="1"><input type="text" name="price[]" id="" class="cost price-input form-control" readonly value="{{ $medicationDetail->price/$medicationDetail->quantity }}"></td>
                                                    <td colspan="1"><input type="number" required name="qty[]" min="1" class="form-control qty" value="{{ $medicationDetail->quantity }}" id=""></td>
                                                    <td colspan="1"><span class="price">{{ single_price($medicationDetail->price) }}</span></td>
                                                </tr>
                                                @endforeach

                                                <tr id="hiderow">
                                                    <td colspan="6"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="text-right no-print">
                                    {{-- <a href="{{ route('medication.invoice.download', $medication->id) }}" class="btn btn-default"><i class="demo-pli-printer icon-lg"></i></a> --}}
                                    <input type="submit" value="Update" class="btn btn-success">
                                </div>
                            </form>

                            </div>
                        </div>

                        {{-- end --}}

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
<script>
    $(document).ready(function(){
    function print_today() {
        var now = new Date();
        var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
        var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
        function fourdigits(number) {
          return (number < 1000) ? number + 1900 : number;
        }
        var today =  months[now.getMonth()] + " " + date + ", " + (fourdigits(now.getYear()));
        return today;
      }

    //   from
      function roundNumber(number,decimals) {
        var newString;// The new rounded number
        decimals = Number(decimals);
        if (decimals < 1) {
          newString = (Math.round(number)).toString();
        } else {
          var numString = number.toString();
          if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
            numString += ".";// give it one at the end
          }
          var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
          var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
          var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
          if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
            if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
              while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
                if (d1 != ".") {
                  cutoff -= 1;
                  d1 = Number(numString.substring(cutoff,cutoff+1));
                } else {
                  cutoff -= 1;
                }
              }
            }
            d1 += 1;
          }
          if (d1 == 10) {
            numString = numString.substring(0, numString.lastIndexOf("."));
            var roundedNum = Number(numString) + 1;
            newString = roundedNum.toString() + '.';
          } else {
            newString = numString.substring(0,cutoff) + d1.toString();
          }
        }
        if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
          newString += ".";
        }
        var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
        for(var i=0;i<decimals-decs;i++) newString += "0";
        //  newNumber = Number(newString);// make it a number if you like
        return newString; // Output the result to the form field (change for your purposes)
      }

      function update_total() {
        var total = 0;
        $('.price').each(function(i){
          price = $(this).html().replace("৳","");
          if (!isNaN(price)) total += Number(price);
        });

        total = roundNumber(total,2);

        $('#subtotal').html("৳"+total);
        $('#total').html("৳"+total);

        update_balance();
      }

      function update_balance() {
        var due = $("#total").html().replace("৳","") - $("#paid").val().replace("৳","");
        due = roundNumber(due,2);

        $('.due').html("৳"+due);
      }

      function update_price() {
        var row = $(this).parents('.item-row');
        var price = row.find('.cost').val().replace("৳","") * row.find('.qty').val();
        price = roundNumber(price,2);
        isNaN(price) ? row.find('.price').html("N/A") : row.find('.price').html("৳"+price);

        update_total();
      }

      function bind() {
        $(".cost").click(update_price);
        $(".qty").click(update_price);
      }

      $(document).ready(function() {

        $('input').click(function(){
          $(this).select();
        });

        $("#paid").blur(update_balance);
        $("#addrow").click(function(){
            $(".item-row:last").after(`<tr class="item-row"><td colspan="3" class="item-name vehicle-type"><div class="delete-wpr"><select class="form-control medication" name="product_id[]" id="">
                @foreach ($peoducts as $peoduct)
                <option data-price="{{$peoduct->unit_price}}" value="{{$peoduct->id}}">{{$peoduct->name}}</option>
                @endforeach
            </select><a class="delete" href="javascript:;" title="Remove row">X</a></div></td><td colspan="1"><input type="text" name="price[]" id="" class="cost price-input form-control" readonly></td><td colspan="1"><input type="number" required name="qty[]" value="1" class="form-control qty" min="1" id=""></td><td colspan="1"><span class="price">00</span></td></tr>`);
            $(".medication").select2();
          if ($(".delete").length > 0) $(".delete").show();
          bind();
        });

        bind();

        // $(".delete").on('click',function(){
    $("body").delegate(".delete","click",function(event){
          $(this).parents('.item-row').remove();
          update_total();
          if ($(".delete").length < 2) $(".delete").hide();
        });
        $("#date").val(print_today());
      });
 $("body").delegate(".vehicle-type","change",function(event){
    var row = $(this).parent();
    row.find('.price-input').val($(this).find(':selected').data('price'));
    // $('.price').html("৳"+$(this).find(':selected').data('price'));
    // update_price();
    var row = $(this).parents('.item-row');
    var price = row.find('.cost').val().replace("৳","") * row.find('.qty').val();
    price = roundNumber(price,2);
    isNaN(price) ? row.find('.price').html("N/A") : row.find('.price').html("৳"+price);
    update_total();
});
});



    </script>

@endsection





