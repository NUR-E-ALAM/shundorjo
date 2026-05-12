@extends('frontend.layouts.app')
@section('css')
<link type="text/css" href="{{ asset('frontend/css/group.css') }}" rel="stylesheet">
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

                    <div class="bg-secondary">
                        <p style="color: white; padding:2px; font-size: 16px; font-weight: 600;">Your Identityfication Number > {{Auth::user()->cid}}  </p>
                    </div>
                        {{-- new section  --}}
                        {{-- design start  --}}
                       @if (!empty(Auth::user()->group_by))
                       <div class="row">
                        @foreach ($groupdlt as $group)
                           <div class="column">
                            <div class="card">
                            <img src="@if(!empty($group->avatar_original)){{$group->avatar_original}} @else {{asset('uploads/patient.png')}} @endif" alt="Jane" style="width:100%">
                            <div class="container">
                                <p><b>{{$group->name}}</b></p>
                                <p class="title">@if($group->cid==$group->group_by) Group Head @else Member @endif</p>
                                <p>{{$group->email}}</p>

                                @if($group->cid==Auth::user()->cid)
                                <p><a href="{{route('group.index')}}"><button class="button" >Back</button></a></p>

                                @elseif($group->group_by==Auth::user()->cid)
                                <p><a href="{{route('group.changeconfirm', $group->cid)}};"><button class="button">create group Head</button></a></p>
                                @endif
                            </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <form class="form-inline" action="{{route('group.store')}}" method="post">
                        @csrf
                        <div class="form-group mx-sm-3 mb-2">
                          <label for="inputPassword2" class="mr-2">Please Input Your Group Created ID</label>
                          <input type="text" class="form-control" name="gcid" placeholder="Example: {{Auth::user()->cid}}">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Confirm identity</button>
                    </form>
                       @endif
                        {{-- design stop  --}}

                        {{-- new section  --}}


                </div>
            </div>
        </div>
    </section>

@endsection
