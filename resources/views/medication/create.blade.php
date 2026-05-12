@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
     {{-- <a href="{{ route('sellers.create')}}" class="btn btn-info pull-right">{{__('add_new')}}</a> --}}
    </div>
</div>
<br>
{{-- start --}}
<div id="page-wrap">
    {{-- <textarea id="header">INVOICE</textarea> --}}
    <form action="{{ route('medication.order') }}" method="post">
@csrf
    <div id="" style="margin-bottom: 20px;">
        <div style="width:50%; float:left;">
            <input type="hidden" class="form-control" name="id" value="{{$users->id}}">
            <div class="form-group">
                <label class="col-lg-4 control-label">{{__('User Name')}}</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="name" value="{{$users->name}}">
                    {{-- : {{$users->name}} --}}
                </div>
            </div><br>
            <div class="form-group">
                <label class="col-lg-4 control-label">{{__('Email')}}</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="email" value="{{$users->email}}">
                    {{-- : {{$users->email}} --}}
                </div>
            </div><br>
            <div class="form-group">
                <label class="col-lg-4 control-label">{{__('Phone No')}}</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="phone" value="{{$users->phone}}">
                    {{-- : {{$users->phone}} --}}
                </div>
            </div><br>
            <div class="form-group">
                <label class="col-lg-4 control-label">{{__('Address')}}</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="address" value="{{$users->address}}">
                    {{-- : {{$users->address}} --}}
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">{{__('Region')}}</label>
                <div class="col-lg-8">
                    <select class="form-control mb-3" data-placeholder="Select your region" id="division" name="region" required>
                      <option value="">---select Region---</option>
                      @foreach ($region as $division)
                          <option value="{{ $division->id }}" @if($users->region==$division->id) selected @endif >{{ $division->name }}</option>
                      @endforeach
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">{{__('City')}}</label>
                <div class="col-lg-8">
                    <select class="form-control mb-3" data-placeholder="Select your City" id="district" name="city" required>
                      @foreach ($districts as $districts)
                          <option value="{{ $districts->id }}" @if($districts->id==$users->city) selected @endif>{{ $districts->name }}</option>
                      @endforeach
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">{{__('Area')}}</label>
                <div class="col-lg-8">
                    <select class="form-control mb-3" data-placeholder="Select your Area" id="upazila" name="area" required>
                      @foreach ($upazilas as $upazilas)
                      <option value="{{ $upazilas->id }}" @if($upazilas->id==$users->area) selected @endif>{{ $upazilas->name }}</option>
                  @endforeach
                  </select>
                </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">{{__('shipping cost')}}</label>
              <div class="col-lg-8">
                <select class="form-control mb-3" data-placeholder="Select shipping Cost " id="paid" name="shipping_cost" required>
                  <option value="{{ $users->shipping_cost }}">{{ $users->shipping_cost }}</option>
              </select>
              </div>
          </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">{{__('Post Code')}}</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="post_code" value="{{$users->postal_code}}">
                </div>
            </div>
        </div>

        <div style="width: 25%; float:right; margin-top:9%">
            <table id="meta">
                <tr hidden>
                    <td class="meta-head">Payment Type </td>
                    <td><select name="payment_option" id="">
                    <option value="Cash On Delivery">Cash On Delivery</option>
                    </select></td>
                </tr>
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><textarea name="order_id" readonly>{{$order_id}}</textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Date</td>
                    <td><input type="date" name="date" id="date" required></td>
                    {{-- <td><textarea id="date">December 15, 2009</textarea></td> --}}
                </tr>
                <tr>
                    <td class="meta-head">Medication Preiod</td>
                    <td><select name="preiod" id="" required class="form-control medication">
                    <option value="">Select Preiod</option>
                    <option value="7">7 Days</option>
                    <option value="10">10 Days</option>
                    <option value="15">15 Days</option>
                    <option value="30">30 Days</option>
                    </select></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due">00</div></td>
                </tr>

            </table>
        </div>
    </div>
    <div style="clear:both;"></div>
    <input type="text" name="user_id" value="{{$users->id}}" hidden>
    <input type="text" name="medication" value="{{$users->medication}}" hidden>
    
    <table id="items" style="margin-top: 20px">

      <tr>
          <th colspan="2">Item</th>
          <th colspan="1">Unit Cost</th>
          <th colspan="1">Quantity</th>
          <th colspan="1">Price</th>
      </tr>
          <input type="text" name="user_id" value="{{Auth::user()->id}}" hidden>
      <tr class="item-row">
          <td colspan="2" class="item-name vehicle-type"><div class="delete-wpr">
              <select class="form-control" name="product_id[]" id="select_car">
                  <option>-Select Medicine-</option>
                  @foreach ($peoducts as $peoduct)
                      <option  data-id="{{$peoduct->id}}" data-price="{{$peoduct->unit_price}}" value="{{$peoduct->id}}">{{$peoduct->name}}</option>
                  @endforeach
              </select><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
              <td colspan="1"><input type="text" name="price[]" id="" class="cost price-input form-control" readonly></td>
              <td colspan="1"><input type="number" required name="qty[]" min="1" value="1" class="form-control qty" id=""></td>
              <td colspan="1"><span class="price">00</span></td>
      </tr>

      <tr id="hiderows">
          <td colspan="5"><a id="addrow" href="javascript:;" title="Add a Medicine">Add a Medicine</a></td>
      </tr>

      {{-- <tr>
          <td colspan="2" class="blank"> </td>
          <td colspan="2" class="total-line">Subtotal</td>
          <td class="total-value"><textarea name="subtotal" id="subtotal" readonly>00</textarea></td>
      </tr> --}}
      <textarea name="subtotal" id="grantotal" readonly hidden></textarea>
      <tr>

          <td colspan="2" class="blank"> </td>
          <td colspan="2" class="total-line">Total</td>
          <td class="total-value"><div id="total">00</div></td>
      </tr>
      {{-- <tr>
          <td colspan="2" class="blank"> </td>
          <td colspan="2" class="total-line">Shipping Cost</td>

          <td class="total-value"><textarea id="paid" name="shipping" readonly>৳{{$users->shipping_cost}}.00</textarea></td>
          <input type="hidden" readonly name="shipping_cost" value="{{$users->shipping_cost}}">
      </tr>
       <tr>
          <td colspan="2" class="blank"> </td>
          <td colspan="2" class="total-line balance">Total</td>
          <td class="total-value balance"><div class="due">00</div></td>
      </tr> --}}

      </table>

    <input type="submit" value="confirm" class="btn btn-success">
</form>
</div>


{{-- end --}}

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

        $('#subtotal').html(total);
        $('#total').html("৳"+total);

        update_balance();
      }

      function update_balance() {
        var due = $("#total").html().replace("৳","");
        var paid = $("#paid").val();
        var amount = Number(due) + Number(paid);
        due = roundNumber(amount,2);

        $('.due').html("৳"+due);
        $('#grantotal').html(due);
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
            $(".item-row:last").after(`<tr class="item-row"><td colspan="2" class="item-name vehicle-type"><div class="delete-wpr"><select class="form-control medication" name="product_id[]" id="">
                <option>-Select Medicine-</option>
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

  $(function () {
    $("select").select2();
  });

  });
    </script>

<script>
  $("#division").on('change',function(e){
    e.preventDefault();
    var ddlDistrict=$("#district");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "{{url('/admin/district-by-division')}}",
      data:{_token:$('input[name=_token]').val(),division:$(this).val()},
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', ddlDistrict).remove();
          $('#district').append('<option value="">---Select City---</option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.name
            }).appendTo('#district');
          });
        }

    });
  });

  $("#district").on('change',function(e){
    e.preventDefault();
    var ddlthana=$("#upazila");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "{{url('/admin/thana-by-district')}}",
      data:{_token:$('input[name=_token]').val(),districts:$(this).val()},
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', ddlthana).remove();
          $('#upazila').append('<option value="">---Select Area---</option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.name
            }).appendTo('#upazila');
          });
        }
      });
  });
  $("body").delegate("#upazila","change",function(e){
  // $("#upazila").on('change',function(e){
    e.preventDefault();
    var ddlship=$("#paid");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "{{url('/admin/ship-by-thana')}}",
      data:{_token:$('input[name=_token]').val(),upazilas:$(this).val()},
      success:function(response){
          $('option', ddlship).remove();
          $.each(response, function(){
            $('<option/>', {
              'value': this.shipping_cost,
              'text': this.shipping_cost
            }).appendTo('#paid');
            
          });
        update_balance();
          
        }

      });
  });

</script>


@endsection


