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
            <div class="left-element">
                <div class="ml-4">
                    <button class="btn btn-base-1 dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                        {{__('Add Method')}} <i class="dropdown-caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><button class="btn btn-base-1" id="bankBtn">{{__('Add Bank')}}</button></li>
                        <li><button class="btn btn-base-1" id="mbankBtn">{{__('Add Mobile Banking')}}</button></li>
                    </ul>
                </div>
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
            {{-- <div class="row">
                <div class="col-4 mx-auto">
                    <div class="dashboard-widget text-center green-widget mt-4 c-pointer">
                        <a href="javascript:;" class="d-block">
                            <i class="fa fa-dollar"></i>
                            <span class="d-block title">{{ single_price(Auth::user()->balance) }}</span>
                            <span class="d-block sub-title">in your wallet</span>
                        </a>
                    </div>
                </div>
            </div> --}}

        
            <div id="bank">
                <form class="" action="{{ route('withdraw.method.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-box bg-white mt-4">
                        <div class="form-box-title px-3 py-2">
                            {{__('Bank info')}}
                        </div>
                        <div class="form-box-content p-3">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{__('Bank Name')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('Bank Name')}}" name="bank_name" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{__('Account Name')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('Account Name')}}" name="acc_name" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{__('Account Number')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('Account Number')}}" name="acc_number" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{__('Branch')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('Branch')}}" name="branch" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{__('Remark')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('Remark')}}" name="remark" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-styled btn-base-1">{{__('Save')}}</button>
                    </div>
                </form>
            </div>

            <div id="mbanking">
                <form class="" action="{{ route('withdraw.method.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-box bg-white mt-4">
                        <div class="form-box-title px-3 py-2">
                            {{__('Mobile Banking info')}}
                        </div>
                        <div class="form-box-content p-3">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{__('Mobile Banking Name')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <select class="form-control mb-3 selectpicker" data-placeholder="Select your Mobile Banking Name" name="bank_name">
                                            <option value="">Please Select</option>
                                            <option value="bKash">bKash</option>
                                            <option value="Nagad">Nagad</option>
                                            <option value="Rocket">Rocket</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{__('Account Name')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('Account Name')}}" name="acc_name" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{__('Account Number')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('Account Number')}}" name="acc_number" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{__('Mobile Banking type')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <select class="form-control mb-3 selectpicker" data-placeholder="Select your Mobile Banking type" name="mbanking_type">
                                            <option value="">Please Select</option>
                                            <option value="Agent">Agent</option>
                                            <option value="Personal">Personal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{__('Remark')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('Remark')}}" name="remark" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-styled btn-base-1">{{__('Save')}}</button>
                    </div>
                </form>
            </div>


            @foreach ($methods as $method)

                        <div id="updateForm">
                            
                            {{-- <form class="" action="#" method="POST" enctype="multipart/form-data">
                                @csrf --}}
                                
                            <form>
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2">
                                        {{$method->bank_name}} {{__('Information')}}
                                        <div class="ermsg"></div>
                                    </div>
                                    
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Bank Name')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control mb-3" placeholder="{{__('Bank Name')}}" name="bank_name" id="bank_name{{$method->id}}" value="{{$method->bank_name}}" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Account Name')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control mb-3" placeholder="{{__('Account Name')}}" name="acc_name" id="acc_name{{$method->id}}" value="{{$method->acc_name}}" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Account Number')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control mb-3" placeholder="{{__('Account Number')}}" name="acc_number" id="acc_number{{$method->id}}" value="{{$method->acc_number}}" readonly="readonly">
                                            </div>
                                        </div>
                                        @if ($method->branch)
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('Branch')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control mb-3" placeholder="{{__('Branch')}}" name="branch" id="branch{{$method->id}}" value="{{$method->branch}}" readonly="readonly">
                                                </div>
                                            </div>
                                            
                                        @else
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('Mobile Banking Type')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control mb-3" placeholder="{{__('Mobile Banking Type')}}" name="mbanking_type" id="mbanking_type{{$method->id}}" value="{{$method->mbanking_type}}" readonly="readonly">
                                                </div>
                                            </div>
                                        @endif
                                       

                                        

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Remark')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control mb-3" placeholder="{{__('Remark')}}" name="remark" id="remark{{$method->id}}" value="{{$method->remark}}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right mt-4">
                                    <button id="editBtn{{$method->id}}" eid="{{$method->id}}" class="btn btn-styled btn-base-1 editBtn">{{__('Edit')}}</button>
                                    <button id="deleteBtn{{$method->id}}" eid="{{$method->id}}" class="btn btn-styled btn-base-1 deleteBtn">{{__('Delete')}}</button>
                                </div>
    
                                <div class="text-right mt-4">
                                    <button type="submit" id="updateBtn{{$method->id}}"  uid="{{$method->id}}" class="btn btn-styled btn-base-1 updateBtn">{{__('Update')}}</button>
                                </div>
                            </form>
                        </div>
                        @endforeach


        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

    $(document).ready(function () {

        $(".updateBtn").hide();

        $("#bank").hide();
        $("#mbanking").hide();

        $("#bankBtn").click(function(){
            $("#mbanking").hide();
            $("#bank").show();
        });
        
        $("#mbankBtn").click(function(){
            $("#bank").hide();
            $("#mbanking").show();
        });



    $("body").delegate(".editBtn","click",function(event){
    event.preventDefault();
    eid = $(this).attr("eid");
    $("#bank_name" + eid + "" ).attr("readonly", false); 
    $("#acc_name" + eid + "" ).attr("readonly", false); 
    $("#acc_number" + eid + "" ).attr("readonly", false); 
    $("#branch" + eid + "" ).attr("readonly", false); 
    $("#mbanking_type" + eid + "" ).attr("readonly", false); 
    $("#remark" + eid + "" ).attr("readonly", false);
    $("#editBtn" + eid + "").hide(); 
    $("#deleteBtn" + eid + "").hide(); 
    $("#updateBtn" + eid + "").show(); 
});

    


    //header for csrf-token is must in laravel
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    //
    $("body").delegate(".updateBtn","click",function(event){
    event.preventDefault();
    
    url = "{{URL::to('/withdraw-method-update')}}";
    uid = $(this).attr('uid');
    //console.log(uid);
    mainurl = url + '/'+ uid;
         //alert('btn work');


        var bank_name= $("#bank_name" + uid + "").val();
        var acc_name= $("#acc_name" + uid + "").val();
        var acc_number= $("#acc_number" + uid + "").val();
        var branch= $("#branch" + uid + "").val();
        var mbanking_type= $("#mbanking_type" + uid + "").val();
        var remark= $("#remark" + uid + "").val();

        console.log(bank_name,acc_name,acc_number,branch,mbanking_type,remark);

        $.ajax({
                url:mainurl,
                method: "PUT",
                type: "PUT",
                data:{
                    bank_name:bank_name,acc_name:acc_name,acc_number:acc_number,branch:branch,mbanking_type:mbanking_type,remark:remark,
                },
                success: function(d){
                    if (d.status == 303) {
                        $(".ermsg").html(d.message);
                    }else if(d.status == 300){
                         $(".ermsg").html(d.message);
                         //flash(__('Withdraw Method Update successfully'))->success();
                        //success("Update Successfully!!");
                        window.setTimeout(function(){location.reload()},2000)
                    }
                },
                error:function(d){
                    console.log(d);
                }
            });
        });


                //Delete
                var deleteurl = "{{URL::to('/withdraw-method')}}";
                // console.log(url);

                $(".deleteBtn").click(function(){
                    //alert('btn work');
                    if(!confirm('Sure?')) return;
                    wid = $(this).attr('eid');
                    //  console.log(pid);
                    info_url = deleteurl + '/'+wid;
                    //console.log(info_url);
                    $.ajax({
                        url:info_url,
                        method: "GET",
                        type: "DELETE",
                        data:{
                        },
                        success: function(d){
                            // alert(d.message);
                            console.log(d);
                            if(d.success) {
                                alert(d.message);
                                location.reload();
                            }
                        },
                        error:function(d){
                            console.log(d);
                        }
                    });
                });
                //Delete




})

</script>
@endsection
