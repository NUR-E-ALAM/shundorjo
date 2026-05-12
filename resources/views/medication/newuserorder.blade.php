@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="ermsg"></div>
        {{-- <a href="{{ route('medication.index')}}" class="btn btn-purple pull-left">{{__('back')}}</a>
        <a href="{{ route('medicationuser.create')}}" class="btn btn-info pull-right">{{__('add_new')}}</a> --}}

    </div>
</div>
<br>
<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Users')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email Address')}}</th>
                    <th>{{__('Medicine Details')}}</th>
                    <th>{{__('Pescription')}}</th>
                    <th>{{__('address')}}</th>
                    <th>{{__('Remark')}}</th>
                    <th>{{__('status')}}</th>
                    <th>{{__('history')}}</th>
                    {{-- <th width="10%">{{__('Action')}}</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $userdata)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ ($userdata->patient_name) }}</td>
                        <td>{{ ($userdata->phone) }}</td>
                        <td>{{ ($userdata->medicine_details)}}</td>
                        <td><img src="{{ asset($userdata->image) }}" height="100" width="100" alt=""></td>
                        <td>{{ ($userdata->address) }}</td>
                        <td>@if($userdata->remark=='positive') Positive @endif
                            @if($userdata->remark=='hpositive') Highly Positive @endif
                            @if($userdata->remark=='negative') Negative @endif
                            @if($userdata->remark=='hnegative') Highly Negative @endif
                            @if($userdata->remark=='dnc') DNC @endif
                            @if($userdata->remark=='alart') Alart @endif
                        </td>
                        <td>
                            @if($userdata->status==1) Active @endif
                            @if($userdata->status==0) Deactive @endif
                        </td>
                        <td><button type="button" class="btn btn-sm btn-purple" data-toggle="modal" data-target="#{{$userdata->id}}"> Add </button>
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#view{{$userdata->id}}"> View </button>
                        </td>
                        {{-- <td>
                            <a href="{{ route('madication.createreqorder', encrypt($userdata->id))}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a href="{{route('madication.prescriptions.show', encrypt($userdata->id))}}" target="blank" ><i class="fa fa-picture-o" aria-hidden="true"></i></a>
                            <a onclick="confirm_modal('{{route('medicationuser.destroy', $userdata->id)}}');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            @if($userdata->med_status==1)
                            <a href="{{route('meduser.view', encrypt($userdata->id))}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            @endif
                        </td> --}}
                        </td>
                    </tr>
                    <!-- Add Modal start -->
                        <div class="modal fade" id="{{$userdata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <form action="{{route('reorder.remark.add')}}" method="post">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="hidden" name="id" value="{{$userdata->id}}">
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
                        <div class="modal fade" id="view{{$userdata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                                        <div class="column">
                                            <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); padding: 16px; background-color: #f1f1f1">
                                              <h5>Remark : {{$userdata->remark}}</h5>
                                              <p> {{$userdata->comment}}</p>
                                              <p><b>Next Calling Date: {{$userdata->redate}}</b></p>
                                            </div>
                                          </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        {{-- view model end  --}}

                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection

@section('script')

@endsection
