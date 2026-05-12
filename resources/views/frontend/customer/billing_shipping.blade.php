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
            <div class="rows">

                <form action="{{ route('default.billing.update') }}" method="POST">
                    @csrf
                    <div class="card no-border mt-4">

                        <table class="table table-sm table-hover table-responsive-md">
                            <thead>
                                <tr>
                                    <th>{{ __('Full Name') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('Region') }}</th>
                                    <th>{{__('Phone Number')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($address as $key => $data)
                                   <tr>
                                       <td>{{ $data->name }}</td>
                                       <td>{{ $data->address }}</td>
                                       <td>{{ $data->region }}-{{ $data->city }}-{{ $data->area }}</td>
                                       <td>{{ $data->phone }}</td>
                                       <td>
                                        <input type="radio" name="default" value="{{$data->id}}" @if(Auth::user()->shipping_address==$data->id) checked @endif required>
                                       </td>
                                   </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right mt-4">
                        <input type="submit" value="Save" class="btn btn-styled btn-base-1">
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

@endsection

@section('script')
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
        url: "{{url('/district-by-division')}}",
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
        url: "{{url('/thana-by-district')}}",
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

    $("#upazila").on('change',function(e){
      e.preventDefault();
      var ddlship=$("#shipping");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{url('/ship-by-thana')}}",
        data:{_token:$('input[name=_token]').val(),upazilas:$(this).val()},
        success:function(response){
            $('option', ddlship).remove();
            $.each(response, function(){
              $('<option/>', {
                'value': this.shipping_cost,
                'text': this.shipping_cost
              }).appendTo('#shipping');
            });
          }
        });
    });

  </script>
@endsection
