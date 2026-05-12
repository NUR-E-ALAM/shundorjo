@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="ermsg"></div>
        <a href="{{ route('emailtemplete.create')}}" class="btn btn-info pull-right">{{__('add_new')}}</a>
    </div>
</div>
{{-- test  --}}
<form action="{{route('test.route')}}" method="post">
    @csrf
<input type="text" name="mobile" id="">
<input type="submit" value="submit">

</form>
{{-- test end  --}}
<br>
{{-- add prescription --}}

{{-- add prescription --}}
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
                    <th>{{__('Description')}}</th>
                    <th>{{__('Footer Note')}}</th>
                    <th>{{__('Status')}}</th>
                    <th width="10%">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($email as $key => $emaildata)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ ($emaildata->templete) }}</td>
                        <td>{{ ($emaildata->description) }}</td>
                        <td>{{ ($emaildata->footer) }}</td>
                        <td></td>
                        <td>
                            <a href="{{route('emailtemplete.edit', encrypt($emaildata->id))}}"><i class="fa fa-edit" aria-hidden="true"></i>Edit</a>
                        </td>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection

@section('script')

@endsection
