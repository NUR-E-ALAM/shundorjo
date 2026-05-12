@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
     <a href="{{ route('patient.create') }}" class="btn btn-info pull-right">{{__('Add New Customer')}}</a>
    </div>
</div>

<br>

{{-- search strt  --}}
<form  action="{{route('customers_search.index')}}" method ="POST">
    @csrf
    <br>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-5">
                <label for="area" style="margin-top: 9px;" class="col-form-label col-md-3">Area</label>
                <div class="col-md-7">
                    {{-- <input type="text" class="form-control" id="area" name="area" required/> --}}
                    <select class="form-control mb-3" data-placeholder="Select your Area" id="upazila" name="area" required>
                        <option value="" ></option>
                        @foreach (\App\Models\Upazila::all() as $item)
                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                        @endforeach
                        @foreach (\App\Models\District::all() as $item)
                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                        @endforeach
                        @foreach (\App\Models\Division::all() as $item)
                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn" name="search" title="Search"><img src="https://img.icons8.com/android/24/000000/search.png"/>Search</button>
            </div>
        </div>
    </div>
    <br>
</form>
{{-- search end  --}}


<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Customers')}}</h3>

    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Date')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email Address')}}</th>
                    <th>{{__('Phone')}}</th>
                    <th>{{__('Message')}}</th>
                    <th>{{__('Status')}}</th>
                    <th width="10%">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $key => $customer)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td><button type="button" class="btn btn-sm btn-purple" data-toggle="modal" data-target="#{{$customer->id}}"> Add </button>
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#view{{$customer->id}}"> View </button>
                        </td>
                        <td>
                            <select class="form-control" data-minimum-results-for-search="Infinity" id="update_status{{$customer->id}}">
                                <option class="color-danger" value="1" @if ($customer->status==1) selected @endif>{{__('Active')}}</option>
                                <option value="0" @if ($customer->status==0) selected @endif>{{__('Deactive')}}</option>
                            </select>
                        </td>
                        {{-- <td>@if ($customer->status==1) Active @else Deactive @endif</td> --}}
                        <td>@if($customer->medication!='Yes')
                            <a href="{{ route('madication.newuserorder', encrypt($customer->id))}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            @endif
                            <a href="{{ route('user.profile', encrypt($customer->id))}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="{{ route('patient.edit', encrypt($customer->id))}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            {{-- <a onclick="confirm_modal('{{route('customers.destroy', $customer->id)}}');"><i class="fa fa-trash" aria-hidden="true"></i></a> --}}
                        </td>
                    </tr>
                    
                     <!-- Add Modal start -->
                    <div class="modal fade" id="{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="{{route('userhistory.store')}}" method="post">
                                @csrf
                            <div class="modal-body">

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="hidden" name="id" value="{{$customer->id}}">
                                        <textarea name="comment" id="" cols="76" rows="8" placeholder="Type your commnets" required></textarea>
                                    </div>

                                    <label class="col-sm-4 control-label" for="logo">{{__('Select Remark')}}</label>
                                    <div class="col-sm-8">
                                      <select class="form-control" name="remark" required>
                                          <option value="">Select Option</option>
                                          <option value="positive">Positive</option>
                                          <option value="hpositive">Highly Positive</option>
                                          <option value="negative">Negative</option>
                                          <option value="hnegative">Highly Negative</option>
                                          <option value="dnc">DNC</option>
                                          <option value="alart">Alart</option>
                                      </select>

                                    </div>
                                        <label class="col-sm-4 control-label" style="margin-top: 5px" for="logo">{{__('Select Next Meeting')}}</label>
                                        <div class="col-sm-8" style="margin-top: 5px">
                                          <input type="date" class="form-control" name="redate" placeholder="Last name">
                                        </div>
                                        <input type="hidden" name="redirect" value="user">
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save changes">
                            </div>
                        </form>
                        </div>
                        </div>
                    </div>
                    <!-- Add Modal end -->
                    {{-- view model start --}}
                    <div class="modal fade" id="view{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @foreach ($customer->history as $his)
                                    <div class="column">
                                        <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); padding: 16px; background-color: #f1f1f1">
                                          <h5>Remark : {{$his->remark}}</h5>
                                          <p> {{$his->discription}}</p>
                                          <p><b>Next Calling Date: {{$his->remark_date}}</b></p>
                                          <p><b>Source: {{$his->source}}</b></p>
                                        </div>
                                      </div>
                                      @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    {{-- view model end  --}}
                    <script>
                        $('#update_status{{$customer->id}}').on('change', function(){
                        var customerId = {{ $customer->id }};
                        var status = $('#update_status{{$customer->id}}').val();
                
                        $.post('{{ route('customers.update_status') }}', {_token:'{{ @csrf_token() }}',customerId:customerId,status:status}, function(data){
                            showAlert('success', 'Customer status has been updated');
                            //console.log(data);
                            // location.reload();
                        });
                    });
                    </script>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection

@section('script')
    <script>
        $(function () {
            $("select").select2();
        });
    </script>
    
@endsection
