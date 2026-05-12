@extends('layouts.app')
@section('css')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
@endsection
@section('content')

{{-- css  --}}
<style>
    .photo-gallery {
      color:#313437;
      background-color:#fff;
    }
    
    .photo-gallery p {
      color:#7d8285;
    }
    
    .photo-gallery h2 {
      font-weight:bold;
      margin-bottom:40px;
      padding-top:40px;
      color:inherit;
    }
    
    @media (max-width:767px) {
      .photo-gallery h2 {
        margin-bottom:25px;
        padding-top:25px;
        font-size:24px;
      }
    }
    
    .photo-gallery .intro {
      font-size:16px;
      max-width:500px;
      margin:0 auto 40px;
    }
    
    .photo-gallery .intro p {
      margin-bottom:0;
    }
    
    .photo-gallery .photos {
      padding-bottom:20px;
    }
    
    .photo-gallery .item {
      padding-bottom:30px;
    }
    
    </style>
    
{{-- css end  --}}


<hr>
<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10"><h1>User Profile</h1></div>
    	{{-- <div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class="img-circle img-responsive" src="http://www.gravatar.com/avatar/28fd20ccec6865e2d5f0e1f4446eb7bf?s=100"></a></div> --}}
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->
              

      <div class="text-center">
        @if(!empty($user->avatar_original))
        <img src="{{asset($user->avatar_original)}}" class="image" alt="" style="height: 250px; width:auto;">
        @else
        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">
        @endif
        
      </div></hr><br>

           
          
          
          <ul class="list-group">
            <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Number of purchase</strong></span>{{$purchase}}</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Amount of Expense</strong></span> {{$amount}}</li>
            
          </ul>
          
        </div>
        <!--/col-3-->
    	<div class="col-sm-8">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home" style="color: black !important;">Home</a></li>
                <li><a data-toggle="tab" href="#messages" style="color: black !important;">Purchase History</a></li>
                <li><a data-toggle="tab" href="#prescription" style="color: black !important;">Prescription</a></li>
            </ul>

              
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  <form class="form" action="##" method="post" id="registrationForm">
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="first_name"><h4>Name</h4></label>
                              <input type="text" class="form-control" value="{{$user->name}}" readonly>
                          </div>
                      </div>
                      
          
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="phone"><h4>Phone</h4></label>
                              <input type="text" class="form-control" value="{{$user->phone}}" readonly>
                          </div>
                      </div>
          
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="email"><h4>Email</h4></label>
                              <input type="email" class="form-control" value="{{$user->email}}" readonly>
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="email"><h4>Location</h4></label>
                              <input type="email" class="form-control" value="{{$user->address}}" readonly>
                          </div>
                      </div>
                      <div class="form-group">
                          
                        <div class="col-xs-6">
                            <label for="email"><h4>Medication</h4></label>
                            <input type="email" class="form-control" value="{{$user->medication}}" readonly>
                        </div>
                    </div>
              	</form>
              
              <hr>
              
             </div><!--/tab-pane-->
             <div class="tab-pane" id="messages">
               
               <h2></h2>
               
               <hr>
                  {{-- tab 2 --}}
                  @if (count($orders) > 0)
                            <!-- Order history table -->
                            <div class="card no-border mt-4">
                                <div>
                                    <table class="table table-sm table-hover table-responsive-md no-border">
                                        <thead>
                                            <tr>
                                                <th>{{__('Code')}}</th>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Amount')}}</th>
                                                <th>{{__('Delivery Status')}}</th>
                                                <th>{{__('Payment Status')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $order)
                                                <tr>
                                                    <td style="border: none">
                                                        {{ $order->code }}
                                                    </td>
                                                    <td style="border: none">{{ date('d-m-Y', $order->date) }}</td>
                                                    <td style="border: none">
                                                        {{ single_price($order->grand_total) }}
                                                    </td>
                                                    <td style="border: none">
                                                        @php
                                                            $status = $order->orderDetails->first()->delivery_status;
                                                        @endphp
                                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                    </td>
                                                    <td style="border: none">
                                                        <span class="badge badge--2 mr-4">
                                                            @if ($order->payment_status == 'paid')
                                                                <i class="bg-green"></i> {{__('Paid')}}
                                                            @else
                                                                <i class="bg-red"></i> {{__('Unpaid')}}
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="pagination-wrapper py-4">
                            <ul class="pagination justify-content-end">
                                {{ $orders->links() }}
                            </ul>
                        </div>
                  {{-- tab 2 --}}
               
             </div>

             <!--/tab-pane-->
                    <div class="tab-pane" id="prescription">
                    
                        <hr>
                        <div class="photo-gallery">
                            <div class="container">
                                
                                {{-- <div class="row photos">
                                    @foreach ($pimg as $item)
                                    <div class="col-sm-6 col-sm-4 col-sm-3 item"><a href="{{asset('uploads/prescription/'.$item->image)}}" data-lightbox="photos"><img class="img-fluid" src="{{asset('uploads/prescription/'.$item->image)}}"></a></div>
                                    @endforeach
                                    
                                </div> --}}


                                <table style="border: none">
                                    <thead>
                                        <tr>
                                            <th style="border: none">{{__('Image')}}</th>
                                            <th style="border: none">{{__('Date')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pimg as $item)
                                            <tr>
                                                <td style="border: none">
                                                    <a href="{{asset('uploads/prescription/'.$item->image)}}" data-lightbox="photos"><img class="img-fluid" src="{{asset('uploads/prescription/'.$item->image)}}" height="300px" width="300px"></a>
                                                </td>
                                                <td  style="border: none">
                                                    {{ $item->created_at}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>







                            </div>
                        </div>
                        
                    </div>
               
              </div><!--/tab-pane-->
          </div><!--/tab-content-->

        </div><!--/col-9-->
    </div><!--/row-->





@endsection

@section('script')

<script>
    $(document).ready(function() {
    
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.avatar').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $(".file-upload").on('change', function(){
            readURL(this);
        });
    });
</script>
    
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
@endsection
