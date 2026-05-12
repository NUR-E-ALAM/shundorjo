@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('special-offer.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Offer')}}</a>
        </div>
    </div>

    <br>

    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Special Offer')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th>{{__('Title')}}</th>
                        <th>{{__('Title Amount')}}</th>
                        <th>{{__('Upto')}}</th>
                        <th>{{__('Upto Amount')}}</th>
                        <th>{{__('status')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offers as $key => $link)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$link->title}}</td>
                            <td>{{$link->tamount}}</td>
                            <td>{{$link->upto}}</td>
                            <td>{{$link->uamount}}</td>
                            <td><label class="switch">
                                <input onchange="update_featured(this)" value="{{ $link->id }}" type="checkbox" <?php if($link->status == 1) echo "checked";?> >
                                <span class="slider round"></span></label>
                            </td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{route('special-offer.edit', encrypt($link->id))}}">{{__('Edit')}}</a></li>
                                        <li><a onclick="confirm_modal('{{route('special-offer.destroy', $link->id)}}');">{{__('Delete')}}</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('specialoffer.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Special offer status updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection