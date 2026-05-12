@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
     {{-- <a href="{{ route('patient.create') }}" class="btn btn-info pull-right">{{__('Add New Patient')}}</a> --}}
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Regular Medication Form Data')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Address')}}</th>
                    <th>{{__('Mobile')}}</th>
                    <th>{{__('Message')}}</th>
                    <th width="10%">{{__('Remark')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($rmed as $key => $data)

                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->address }}</td>
                        <td>{{ $data->mobile }}</td>
                        <td>{{ $data->message }}</td>
                        <td><button type="button" class="btn btn-sm btn-purple" data-toggle="modal" data-target="#{{$data->id}}"> Add </button>
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#view{{$data->id}}"> View </button>
                        </td>
                        {{-- <td><a href="{{ route('madication.regular', encrypt($data->id))}}"><i class="fa fa-plus" aria-hidden="true"></i></a></td> --}}
                        <td>
                            <form action="{{route('madication.regular')}}" method="post">
                                @csrf
                                <input type="hidden" name="rmid" value="{{$data->id}}">
                                <input type="hidden" name="rmmobile" value="{{$data->mobile}}">
                                <input type="submit" class="btn btn-primary" value="Add Medication user">
                            </form>
                        </td>

                    </tr>


                    <!-- Add Modal start -->
                    <div class="modal fade" id="{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="{{route('rmhistory.store')}}" method="post">
                                @csrf
                            <div class="modal-body">

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="hidden" name="id" value="{{$data->id}}">
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
                    <div class="modal fade" id="view{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    @foreach (\App\Models\History::where('rm_id', '=', $data->id)->get() as $his)
                                    <div class="column">
                                        <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); padding: 16px; background-color: #f1f1f1">
                                          <h5>Remark : {{$his->remark}}</h5>
                                          <p> {{$his->discription}}</p>
                                          <p><b>Next Calling Date: {{$his->remark_date}}</b></p>
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

                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
