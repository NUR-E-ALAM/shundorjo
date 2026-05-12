@extends('frontend.layouts.app')
@section('title')
    Become an agent
@stop
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
            <div class="right-element">
                <!--<div class="dropdown">-->
                <!--    <a class="btn dropdown-toggle profile-manage" href="#" role="button" id="dropdownMenuLink"-->
                <!--        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                <!--        @if(!empty(Auth::user()->avatar_original))-->
                <!--        <img src="{{asset(Auth::user()->avatar_original)}}" alt="">-->
                <!--        @else-->
                <!--            <img src="{{asset('uploads/1.jpg')}}" alt="">-->
                <!--        @endif-->
                <!--    </a>-->

                <!--    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">-->
                <!--        <a class="dropdown-item" href="{{ route('profile') }}"><span class="iconify"-->
                <!--                data-icon="carbon:user-avatar"></span> Profile</a>-->
                <!--        <a class="dropdown-item" href="{{ route('logout') }}"><span class="iconify"-->
                <!--                data-icon="ion:log-out-outline"></span> Log Out</a>-->
                <!--    </div>-->
                <!--</div>-->
            </div>

        </div>
        <div class="dashboard-content">
            <section class="profile">
                <div class="title-section">
                    <span class="iconify mr-1" data-icon="et:wallet"></span> My Affiliate
                </div>
                <div class="row align-items-center">
                    <div class="col-md-12 d-flex align-items-center">
                            <div class="col-md-2">
                                <label>{{__('Your reference link')}}</label>
                            </div>
                            <div class="col-md-7">
                            <input type="text" class="form-control mb-3" placeholder="@if (Auth::user()->ref_id) {{url('users/registration?affiliate_id='.encrypt(Auth::user()->ref_id))}} @else @endif" name="ref_link" id="ref_link" value="@if (Auth::user()->ref_id) {{url('users/registration?affiliate_id='.encrypt(Auth::user()->ref_id))}} @else @endif" readonly>
                            </div>
                            <div class="col-md-2">
                                
                                 {{-- new code  --}}

                                 @if (Auth::user()->ref_id == NULL)

                                    @if (empty(\App\Models\AgentRequest::where('user_id', '=', Auth::user()->id )->first()->id))
                                    <form action="{{route('affiliate.request')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" id="affreq"  name="affreq" >
                                            
                                        <button type="submit" class="btn btn-styled btn-base-1" data-wow-duration="1s" data-wow-iteration="100">
                                            Request for agent
                                        </button>       
                                    </form>

                                    @else

                                    

                                    <button type="button" class=" btn btn-styled btn-base-1" data-wow-duration="1s" data-wow-iteration="100">
                                        Request Pending
                                    </button> 
                                        
                                    @endif
                                    

                                 @else
                                 <button onclick="copyToClipboard()" class="btn btn-styled btn-base-1">{{__('Copy')}}</button>
                                 @endif
                                 {{-- new code end  --}}

                            </div>
                            
                    </div>
                </div>
                <div class="infoBox mt-3">
                    <div class="row col-lg-12 mx-auto">
                        <div class="col-lg-11 mx-auto">
                            <div class="row shadow-sm">
                                
                                <div class="col-lg-12 col-md-6 bg-white">
                                       <div class="form-container pt-5">
                                           <div style="overflow-x: auto;">
                                        <table class="table table-custom shadow-sm">
                                            <thead>
                                                <tr>
                                                    <th>#Sl</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($affiliate as $key => $data)
                                       <tr>
                                           <td>{{ $key+1 }}</td>
                                           <td>{{ $data->name }}</td>
                                           <td>{{ $data->email }}</td>
                                           <td>{{ $data->phone}}</td>
                                       </tr>
                                   @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="pagination-wrapper py-4">
                                            <ul class="pagination justify-content-end">

                                            </ul>
                                        </div>
                                       </div>
                                </div>
                            </div>
                        {{-- </form> --}}
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
</div>

 
@endsection

@section('script')
    <script type="text/javascript">
        function copyToClipboard() {
            document.getElementById("ref_link").select();
            document.execCommand('copy');
        }
    </script>
@endsection
