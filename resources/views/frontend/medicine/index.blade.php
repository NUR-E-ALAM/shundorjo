@extends('frontend.layouts.app')
@section('title')
    All Medicine-Apon Health-Online Drug House
@stop
@section('css')
<link type="text/css" href="{{ asset('frontend/css/extra.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="single_section popular_style">
            <div class="catagory_title">
                <div class="col-md-12">
                    <div class="section-title-1">
                        <h3 class="heading-5 strong-700 mb-0">
                            <span class="mr-4">{{__('Our Medicine')}}</span>
                            <a href="{{ route('products') }}" class="see_more pull-right">See More</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="products-box-bar bg-white">
                <div class="row product-list mb-1" id="results">
                    {{-- scroling product show here  --}}
                </div>
            </div>
        </div>
    </div>
    
    <div class="clear"></div>
</div>




@endsection

@section('script')
<script>
    var page = 1;
    load_more(page);
    $(window).scroll(function() { //detect page scroll
       if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
       page++; //page number increment
       load_more(page); //load content
       }
     });
     function load_more(page){
         $.ajax({
            url: '?page=' + page,
            type: "get",
            datatype: "html",
            beforeSend: function()
            {
               $('.ajax-loading').show();
             }
         })
         .done(function(data)
         {
             if(data.length == 0){
             console.log(data.length);
             //notify user if nothing to load
             $('.ajax-loading').html("No more records!");
             return;
           }
           $('.ajax-loading').hide(); //hide loading animation once data is received
           $("#results").append(data); //append data into #results element
            console.log('data.length');
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
           alert('No response from server');
        });
     }
 </script>
@endsection
