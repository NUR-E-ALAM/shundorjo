@extends('layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Withdraw')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('User Name')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('Withdraw Type')}}</th>
                    <th>{{__('Payment Status')}}</th>
                    <th>{{__('Process by')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($withdraws as $withdraw)
                {{-- @foreach ($withdraws as $key => $withdraw_id)
                    @php
                        $withdraw = \App\Models\Withdraw::find($withdraw_id->id);
                    @endphp
                    @if($withdraw != null) --}}
                        <tr>
                            <td>
                                {{ $withdraw->id }}
                            </td>
                            <td>
                                {{-- @if ($withdraw->user_id != null)
                                    {{ $withdraw->user->name }}
                                @else
                                    Guest ({{ $withdraw->guest_id }})
                                @endif --}}
                                {{ $withdraw->user_name }}
                                @if($withdraw->viewed == 0) <span class="pull-right badge badge-info">{{ __('New') }}</span> @endif
                            </td>
                            {{-- <td>
                                @if ($order->user_id != null)
                                    {{ $order->user->name }}
                                @else
                                    Guest ({{ $order->guest_id }})
                                @endif
                            </td> --}}
                            <td>
                                {{ $withdraw->amount }}
                            </td>
                            <td>
                                {{ $withdraw->withdraw_type }}
                            </td>
                            <td>
                                {{ $withdraw->payment_status }}
                            </td>
                            <td>
                                {{-- @if ($withdraw->process_by != null)
                                    {{ $withdraw->user->name }}
                                @else
                                    Guest ({{ $withdraw->guest_id }})
                                @endif --}}
                                {{ $withdraw->process_name }}
                            </td>

                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('withdraw.show', encrypt($withdraw->id)) }}">{{__('View')}}</a></li>
                                        <li><a onclick="confirm_modal('{{route('withdraw.destroy', $withdraw->id)}}');">{{__('Delete')}}</a></li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                    {{-- @endif --}}
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection


@section('script')
    <script type="text/javascript">

    </script>
@endsection
