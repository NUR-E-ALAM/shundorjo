<!DOCTYPE html>
@if (\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <html dir="rtl">
@else
    <html lang="en">
@endif

<head>
    @php
        $seosetting = \App\Models\SeoSetting::first();
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {!! SEO::generate() !!}



    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if (!empty($seosetting->description))
        <meta name="description" content="{{ $seosetting->description }}">
    @endif

    @if (!empty($seosetting->keyword))
        <meta name="keywords" content="{{ $seosetting->keyword }}">
    @endif

    @if (!empty($seosetting->author))
        <meta name="author" content="{{ $seosetting->author }}">
    @endif

    @if (!empty($seosetting->sitemap_link))
        <meta name="sitemap_link" content="{{ $seosetting->sitemap_link }}">
        {{-- <meta name="sitemap_link" content="https://www.shundorjo.com/sitemap.xml"> --}}
        <meta name="sitemap_link" content="https://www.shundorjo.com/public/sitemap1.xml">
    @endif
    @laravelPWA
    @yield('meta')
    <!-- Favicon -->
  {{-- <link name="favicon" href="{{ asset(\App\Models\GeneralSetting::first()->favicon) }}" type="image/x-icon" rel="icon" sizes="16x16" /> --}}

  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('frontend/images/icon') }}/apple-icon-57x57.png">
  <link name="favicon" rel="apple-touch-icon" sizes="60x60" href="{{ asset('frontend/images/icon') }}/apple-icon-60x60.png">
  <link name="favicon" rel="apple-touch-icon" sizes="72x72" href="{{ asset('frontend/images/icon') }}/apple-icon-72x72.png">
  <link name="favicon" rel="apple-touch-icon" sizes="76x76" href="{{ asset('frontend/images/icon') }}/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('frontend/images/icon') }}/apple-icon-114x114.png">
  <link name="favicon" rel="apple-touch-icon" sizes="120x120" href="{{ asset('frontend/images/icon') }}/apple-icon-120x120.png">
  <link name="favicon" rel="apple-touch-icon" sizes="144x144" href="{{ asset('frontend/images/icon') }}/apple-icon-144x144.png">
  <link name="favicon" rel="apple-touch-icon" sizes="152x152" href="{{ asset('frontend/images/icon') }}/apple-icon-152x152.png">
  <link name="favicon" rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/images/icon') }}/apple-icon-180x180.png">
  <link name="favicon" rel="icon" type="image/png" sizes="192x192"  href="{{ asset('frontend/images/icon') }}/android-icon-192x192.png">
  <link name="favicon" rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/images/icon') }}/favicon-32x32.png">
  <link name="favicon" rel="icon" type="image/png" sizes="96x96" href="{{ asset('frontend/images/icon') }}/favicon-96x96.png">
  <link name="favicon" rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/images/icon') }}/favicon-16x16.png">

    <title>@yield('title')</title>
<!-- Google Fonts Preconnect for Faster Loading -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://platform-api.sharethis.com">
<!-- Combined & Optimized Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&family=Playfair+Display:wght@700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<!-- =========================
     Font Styling
========================= -->
<style>
  body {
    font-family: 'Roboto', sans-serif;
    font-weight: 400;
    color: #333;
  }
  h1, h2, h3 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    color: #111;
  }
  h4, h5, h6, .btn, .nav-link {
    font-family: 'Oswald', sans-serif;
    font-weight: 500;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: #222;
  }
</style>

<!-- =========================
     Essential Core CSS Only
========================= -->
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/line-awesome.min.css') }}">

<!-- =========================
     Feature CSS - Lazy/Async Loaded
========================= -->
<link rel="preload" as="style" href="{{ asset('frontend/css/bootstrap-tagsinput.min.css') }}" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-tagsinput.min.css') }}"></noscript>

<!-- Optional Plugin CSS - Load only if needed -->
<link rel="stylesheet" href="{{ asset('frontend/css/jodit.min.css') }}" media="print" onload="this.media='all'">
<link rel="stylesheet" href="{{ asset('frontend/css/sweetalert2.min.css') }}" media="print" onload="this.media='all'">
<link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}" media="print" onload="this.media='all'">
<link rel="stylesheet" href="{{ asset('frontend/css/xzoom.css') }}" media="print" onload="this.media='all'">
<link rel="stylesheet" href="{{ asset('frontend/css/jquery.share.css') }}" media="print" onload="this.media='all'">
<link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}" media="print" onload="this.media='all'">
<link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}" media="print" onload="this.media='all'">
<link rel="stylesheet" href="{{ asset('frontend/css/swiper-bundle.min.css') }}" media="print" onload="this.media='all'">
<link rel="stylesheet" href="{{ asset('css/spectrum.css') }}" media="print" onload="this.media='all'">

<!-- =========================
     Main Styles
========================= -->
<link rel="stylesheet" href="{{ asset('frontend/css/active-shop.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/custom-style.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/custom-nav.css') }}">

@stack('css')
@yield('css')

@if (\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
  <link rel="stylesheet" href="{{ asset('frontend/css/active.rtl.css') }}">
@endif

<!-- Theme Color -->
<link rel="stylesheet" href="{{ asset('frontend/css/colors/' . \App\Models\GeneralSetting::first()->frontend_color . '.css') }}">

<!-- BaguetteBox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css" media="print" onload="this.media='all'">


  <!-- Webmaster Verification Meta Tags -->
<meta name="yandex-verification" content="07cf49da867ac287" />
<meta name="google-site-verification" content="BTSEd36ssQsz7QRcGCC6VtMSPDJcbYKCRbg_4QmW_ME" />
<meta name="msvalidate.01" content="F888860122A1F1A14D5B15D13F223A55" />

<!-- Tracking & Third-Party Scripts -->
<script>
    window.addEventListener('load', function () {
        // Yandex Metrika
        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            k=e.createElement(t),a=e.getElementsByTagName(t)[0];
            k.async=1;k.src=r;a.parentNode.insertBefore(k,a);
        })(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(89171552, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true,
            ecommerce: "dataLayer"
        });

        // Microsoft Clarity
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments);
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i + "?ref=bwt";
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "bhir5ela5h");

        // Ahrefs Analytics
        var ahrefsScript = document.createElement('script');
        ahrefsScript.async = true;
        ahrefsScript.src = 'https://analytics.ahrefs.com/analytics.js';
        ahrefsScript.setAttribute('data-key', 'hFiv81G0LoHllRg8O+h8YQ');
        document.head.appendChild(ahrefsScript);

        // BaguetteBox (Image Lightbox)
        var baguetteScript = document.createElement('script');
        baguetteScript.async = true;
        baguetteScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js';
        baguetteScript.onload = function () {
            baguetteBox.run('.gallery'); // Replace `.gallery` if using a different class
        };
        document.head.appendChild(baguetteScript);
    });
</script>

<!-- Yandex noscript fallback -->
<noscript>
    <div>
        <img src="https://mc.yandex.ru/watch/89171552" style="position:absolute; left:-9999px;" alt="yandex" />
    </div>
</noscript>


         <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    #WAButton {
    background-color: #25D366; /* WhatsApp green */
    border-radius: 50px;
    padding: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    transition: transform 0.3s;
}
.product-font-size{
    font-size: 1.5rem;
}
.col-sm-6{
    width: 50%;
}
.category-box{
    align-items: center;
    justify-content: center;
}
.category-box > a > img{
width: 100%;
}
.category-banner-box{
    background: #6b21a8;
}
.category-banner-box .cat-left {
    /* align-items: center;
    justify-content: center; */

}
.category-banner-box .cat-left > a > img{width:70px;}
.category-banner-box .cat-left > a{color: #fff}
.category-banner-box .cat-right > ul > li > a{color: #fff;}

#WAButton:hover {
    transform: scale(1.1);
}

                .st-cart-wrapper {
    opacity: .7;
    cursor: pointer;
    position: fixed;
    width: 65px;
    min-height: 75px;
    background: #ff3d71;
    right: 0;
    z-index: 10;
    top: calc(100px + 30%);
    box-shadow: 0 0 16px -1px rgb(0 0 0 / 75%);
    transition: opacity 0.5s ease-in-out;}
    .st-cartitem-wrap {
    min-height: 50px;
    background: #192038;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.st-cartitem-wrap p {
    margin: 2px 2px;
    color: white;
    font-size: 11px;
    font-weight: 700;
    line-height: normal;
}

.st-cart-wrapper .st-total {
    min-height: 20px;
    width: 100%;
    font-weight: 600;
    text-align: center;
    font-size: 13px;
    padding-top: 5px;
    color: white;
}
.st-cartitem-wrap svg {
    fill: white;
    stroke: white;
    margin-top: 5px;
}
.text-pink{
   color:#ff3d71;
}

#load-more {
    margin: 20px 0;
}

.product-item {
    margin-bottom: 20px;
    /* Add more styles to match your product layout */
}

#message-menu a:hover {
    background: #f5f5f5;
}
/* Snowfall Start */
#snowfall-root {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 999999;
}

.snowflake {
    position: absolute;
    top: -10px;
    color: #fff;
    user-select: none;
    will-change: transform;
    animation: snow-fall linear infinite;
}

@keyframes snow-fall {
    to {
        transform: translateY(110vh);
    }
}

/* 🚑 FORCE SCROLL FIX */
html, body {
    height: auto !important;
    overflow-y: auto !important;
}
body.modal-open {
    overflow: auto !important;
    padding-right: 0 !important;
}
/* Snowfall end */


</style>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MDK9D01P38"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-MDK9D01P38');
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MQF6BDC3');</script>
<!-- End Google Tag Manager -->


<!-- Meta Pixel Code for shundorjjo & shundojocare -->
<script>
  !function(f,b,e,v,n,t,s){
    if(f.fbq)return; n=f.fbq=function(){n.callMethod ?
    n.callMethod.apply(n,arguments) : n.queue.push(arguments)};
    if(!f._fbq) f._fbq=n; n.push=n; n.loaded=!0; n.version='2.0';
    n.queue=[]; t=b.createElement(e); t.async=!0;
    t.src=v; s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s);
  }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

  fbq('init', '1333957321352437'); // shundorjjo
  fbq('init', '1262693781705847'); // shundojocare
  fbq('track', 'PageView');
</script>

<noscript>
  <img height="1" width="1" style="display:none"
       src="https://www.facebook.com/tr?id=1333957321352437&ev=PageView&noscript=1"/>
  <img height="1" width="1" style="display:none"
       src="https://www.facebook.com/tr?id=1262693781705847&ev=PageView&noscript=1"/>
</noscript>
<!-- End Meta Pixel Code -->
@section('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Shundorjo",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ url('/search?keyword={search_term_string}') }}",
    "query-input": "required name=search_term_string"
  }
}
</script>
@endsection
</head>

<body>
    <div id="snowfall-root"></div>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQF6BDC3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="message-button" style="position: fixed; z-index: 1000;">
        <button id="message-button" style="
            width: 50px;
            height: 50px;
            background-color: #0093F5;
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        ">
            <i class="fa fa-comments" style="font-size: 20px;"></i>
        </button>
        <div id="message-menu" style="
            display: none;
            position: absolute;
            bottom: 60px;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            z-index: 1000;
        ">
            <a href="fb-messenger://user-thread/622603187902855"
               onclick="return openFallback('https://www.messenger.com/t/622603187902855');"
               style="display: flex; align-items: center; padding: 10px 20px; text-decoration: none; color: black;">
                <img src="{{ asset('frontend/images/messenger.png') }}" alt="Messenger" style="width: 30px; height: 30px; margin-right: 10px;">
                Messenger
            </a>
            <a href="whatsapp://send?phone=+8801882542525"
               onclick="return openFallback('https://wa.me/+8801882542525');"
               style="display: flex; align-items: center; padding: 10px 20px; text-decoration: none; color: black;">
                <img src="{{ asset('frontend/images/whatsapp.png') }}" alt="WhatsApp" style="width: 30px; height: 30px; margin-right: 10px;">
                WhatsApp
            </a>
        </div>
    </div>

    <!-- MAIN WRAPPER -->
    {{-- <div class="body-wrap shop-default shop-cards shop-tech"> --}}

    <!-- Header -->
    @include('frontend.inc.nav')

    @yield('content')

    @include('frontend.inc.footer')


    @include('frontend.partials.modal')

    {{-- tag manager  body side --}}
    {{-- analysis --}}


    {{-- tag manager end --}}

    <div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size"
            role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <button type="button" class="close absolute-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div id="addToCart-modal-body">

                </div>
            </div>
        </div>
    </div>

    {{-- @if (\App\Models\BusinessSetting::where('type', 'facebook_chat')->first()->value == 1)
        <div class="fb-customerchat fb_invisible_flow"
            page_id="{{ env('FACEBOOK_PAGE_ID') }}"
            theme_color="#459645"
            logged_in_greeting="Hi! How can we help you?"
            logged_out_greeting="GoodBye!... Hope to see you soon."
            minimized="true">
        </div>
    @endif --}}

    {{-- </div><!-- END: body-wrap --> --}}
    <!-- SCRIPTS -->
    <a href="#" class="back-to-top btn-back-to-top"></a>






  <!-- Core JS (bootstrap.js depends on popper.js) -->
<script src="{{ asset('frontend/js/vendor/popper.min.js') }}" defer></script>
<script src="{{ asset('frontend/js/vendor/bootstrap.min.js') }}" defer></script>

<!-- Plugins (alphabetically ordered where possible) -->
<script src="{{ asset('frontend/js/app.js') }}" defer></script>
<script src="{{ asset('frontend/js/jquery.countdown.min.js') }}" defer></script>
<script src="{{ asset('frontend/js/jquery.share.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
<script src="{{ asset('frontend/js/nouislider.min.js') }}" defer></script>
<script src="{{ asset('frontend/js/owl.carousel.min.js') }}" defer></script>
<script src="{{ asset('frontend/js/select2.min.js') }}" defer></script>
<script src="{{ asset('frontend/js/slick.min.js') }}"></script> <!-- avoid defer if slider init issues -->
<script src="{{ asset('frontend/js/sweetalert2.min.js') }}" defer></script>
<script src="https://code.iconify.design/2/2.0.1/iconify.min.js" defer></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>
<script>
    $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    autoplay:true,
    autoplayTimeout:1500,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:3
        }
    }
})
</script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-142342900-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-142342900-1');
</script> --}}

    <script type="text/javascript">
        function showFrontendAlert(type, message) {
            swal({
                position: 'top-end',
                type: type,
                title: message,
                showConfirmButton: false,
                timer: 4000
            });
        }
    </script>

    @foreach (session('flash_notification', collect())->toArray() as $message)
        <script type="text/javascript">
            showFrontendAlert('{{ $message['level'] }}', '{{ $message['message'] }}');
        </script>
    @endforeach

    <script>
        $(document).ready(function() {
            if ($('#lang-change').length > 0) {
                $('#lang-change .dropdown-item a').each(function() {
                    $(this).on('click', function(e) {
                        e.preventDefault();
                        var $this = $(this);
                        var locale = $this.data('flag');
                        $.post('{{ route('language.change') }}', {
                            _token: '{{ csrf_token() }}',
                            locale: locale
                        }, function(data) {
                            location.reload();
                        });

                    });
                });
            }

            if ($('#currency-change').length > 0) {
                $('#currency-change .dropdown-item a').each(function() {
                    $(this).on('click', function(e) {
                        e.preventDefault();
                        var $this = $(this);
                        var currency_code = $this.data('currency');
                        $.post('{{ route('currency.change') }}', {
                            _token: '{{ csrf_token() }}',
                            currency_code: currency_code
                        }, function(data) {
                            location.reload();
                        });

                    });
                });
            }
        });

        $('#search').on('keyup', function() {
            search();
        });

        $('#search').on('focus', function() {
            search();
        });

        function search() {
            var search = $('#search').val();
            if (search.length > 0) {
                $('body').addClass("typed-search-box-shown");

                $('.typed-search-box').removeClass('d-none');
                $('.search-preloader').removeClass('d-none');
                $.post('{{ route('search.ajax') }}', {
                    _token: '{{ @csrf_token() }}',
                    search: search
                }, function(data) {
                    if (data == '0') {
                        // $('.typed-search-box').addClass('d-none');
                        $('#search-content').html(null);
                        $('.typed-search-box .search-nothing').removeClass('d-none').html(
                            'Sorry, nothing found for <strong>"' + search + '"</strong>');
                        $('.search-preloader').addClass('d-none');

                    } else {
                        $('.typed-search-box .search-nothing').addClass('d-none').html(null);
                        $('#search-content').html(data);
                        $('.search-preloader').addClass('d-none');
                    }
                });
            } else {
                $('.typed-search-box').addClass('d-none');
                $('body').removeClass("typed-search-box-shown");
            }
        }

        function updateNavCart() {
            $.post('{{ route('cart.nav_cart') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#cart_items').html(data);
            });
            $.post('{{ route('cart.nav_cartNumber') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#cartNumber').html(data);
                $('#cartNumberNav').html(data);
                $('#cartNumberTMobile').html(data);
                $('#cartNumberTaka').html(data);
            });
            $.post('{{ route('cart.nav_Taka') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#cartThakUpdate').html(data);
                $('#cartTakaUpdate').html(data);
            });
        }

        function removeFromCart(key) {
            $.post('{{ route('cart.removeFromCart') }}', {
                _token: '{{ csrf_token() }}',
                key: key
            }, function(data) {
                updateNavCart();
                $('#cart-summary').html(data);
                showFrontendAlert('success', 'Item has been removed from cart');
                $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) - 1);
            });
        }

        function addToCompare(id) {
            // @if (Auth::check())
            //     $.post('{{ route('compare.addToCompare') }}', {_token:'{{ csrf_token() }}', id:id}, function(data){
            //         $('#compare').html(data);
            //         showFrontendAlert('success', 'Item has been added to compare list');
            //         $('#compare_items_sidenav').html(parseInt($('#compare_items_sidenav').html())+1);
            //     });
            //
        @else
            //     showFrontendAlert('warning', 'Please login first');
            //
        @endif

        $.post('{{ route('compare.addToCompare') }}', {
            _token: '{{ csrf_token() }}',
            id: id
        }, function(data) {
            $('#compare').html(data);
            showFrontendAlert('success', 'Item has been added to compare list');
            $('#compare_items_sidenav').html(parseInt($('#compare_items_sidenav').html()) + 1);
        });
        }

        function addToWishList(id) {
            @if (Auth::check())
                $.post('{{ route('wishlists.store') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                }, function(data) {
                    if (data != 0) {
                        $('#wishlist').html(data);
                        showFrontendAlert('success', 'Item has been added to wishlist');
                    } else {
                        showFrontendAlert('warning', 'Please login first');
                    }
                });
            @else
                showFrontendAlert('warning', 'Please login first');
            @endif
        }

        function showAddToCartModal(id) {
            if (!$('#modal-size').hasClass('modal-lg')) {
                $('#modal-size').addClass('modal-lg');
            }
            $('#addToCart-modal-body').html(null);
            $('#addToCart').modal();
            $('.c-preloader').show();
            $.post('{{ route('cart.showCartModal') }}', {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(data) {
                $('.c-preloader').hide();
                $('#addToCart-modal-body').html(data);
                $('.xzoom, .xzoom-gallery').xzoom({
                    Xoffset: 20,
                    bg: true,
                    tint: '#000',
                    defaultScale: -1
                });
            });
        }

        function showAddToCartModalshop(id) {
            if (!$('#modal-size').hasClass('modal-md')) {
                $('#modal-size').addClass('modal-md');
            }
            $('#addToCart-modal-body').html(null);
            $('#addToCart').modal();
            $('.c-preloader').show();
            $.post('{{ route('cart.showCartModalshop') }}', {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(data) {
                $('.c-preloader').hide();
                $('#addToCart-modal-body').html(data);
                $('.xzoom, .xzoom-gallery').xzoom({
                    Xoffset: 20,
                    bg: true,
                    tint: '#000',
                    defaultScale: -1
                });
            });
        }

        $('#option-choice-form input').on('change', function() {
            getVariantPrice();
        });

        function getVariantPrice() {
            if ($('#option-choice-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('products.variant_price') }}',
                    data: $('#option-choice-form').serializeArray(),
                    success: function(data) {
                        $('#option-choice-form #chosen_price_div').removeClass('d-none');
                        $('#option-choice-form #chosen_price_div #chosen_price').html(data);
                    }
                });
            }
        }

        function checkAddToCartValidity() {
            var names = {};
            $('#option-choice-form input:radio').each(function() { // find unique names
                names[$(this).attr('name')] = true;
            });
            var count = 0;
            $.each(names, function() { // then count them
                count++;
            });
            if ($('input:radio:checked').length == count) {
                return true;
            }
            return false;
        }

        function addToCart() {
            if (checkAddToCartValidity()) {
                $('#addToCart').modal();
                $('.c-preloader').show();
                $.ajax({
                    type: "POST",
                    url: '{{ route('cart.addToCart') }}',
                    data: $('#option-choice-form').serializeArray(),

                    success: function(data) {
                        $('#addToCart-modal-body').html(null);
                        $('.c-preloader').hide();
                        $('#modal-size').removeClass('modal-lg');
                        $('#addToCart-modal-body').html(data);
                        updateNavCart();
                        //    updateNumber();
                        $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html()) + 1);
                    }
                });

            } else {
                showFrontendAlert('warning', 'Please choose all the options');
            }
            console.log("my data", data);
        }

        function buyNow(id) {
            if (checkAddToCartValidity()) {
                updateNavCart();
                window.location='{{ url('cart/buynow') }}'+'/'+id;

            } else {
                showFrontendAlert('warning', 'Please choose all the options');
            }
            console.log("my data", data);
        }

        function show_purchase_history_details(order_id) {
            $('#order-details-modal-body').html(null);

            if (!$('#modal-size').hasClass('modal-lg')) {
                $('#modal-size').addClass('modal-lg');
            }

            $.post('{{ route('purchase_history.details') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id
            }, function(data) {
                $('#order-details-modal-body').html(data);
                $('#order_details').modal();
                $('.c-preloader').hide();
            });
        }

        function show_order_details(order_id) {
            $('#order-details-modal-body').html(null);

            if (!$('#modal-size').hasClass('modal-lg')) {
                $('#modal-size').addClass('modal-lg');
            }

            $.post('{{ route('orders.details') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id
            }, function(data) {
                $('#order-details-modal-body').html(data);
                $('#order_details').modal();
                $('.c-preloader').hide();
            });
        }

        function cartQuantityInitialize() {
            $('.btn-number').click(function(e) {
                e.preventDefault();

                fieldName = $(this).attr('data-field');
                type = $(this).attr('data-type');
                var input = $("input[name='" + fieldName + "']");
                var currentVal = parseInt(input.val());

                if (!isNaN(currentVal)) {
                    if (type == 'minus') {

                        if (currentVal > input.attr('min')) {
                            input.val(currentVal - 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('min')) {
                            $(this).attr('disabled', true);
                        }

                    } else if (type == 'plus') {

                        if (currentVal < input.attr('max')) {
                            input.val(currentVal + 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('max')) {
                            $(this).attr('disabled', true);
                        }

                    }
                } else {
                    input.val(0);
                }
            });

            $('.input-number').focusin(function() {
                $(this).data('oldValue', $(this).val());
            });

            $('.input-number').change(function() {

                minValue = parseInt($(this).attr('min'));
                maxValue = parseInt($(this).attr('max'));
                valueCurrent = parseInt($(this).val());

                name = $(this).attr('name');
                if (valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));
                }
                if (valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
                }


            });
            $(".input-number").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        }

        function imageInputInitialize() {
            $('.custom-input-file').each(function() {
                var $input = $(this),
                    $label = $input.next('label'),
                    labelVal = $label.html();

                $input.on('change', function(e) {
                    var fileName = '';

                    if (this.files && this.files.length > 1)
                        fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}',
                            this.files.length);
                    else if (e.target.value)
                        fileName = e.target.value.split('\\').pop();

                    if (fileName)
                        $label.find('span').html(fileName);
                    else
                        $label.html(labelVal);
                });

                // Firefox bug fix
                $input
                    .on('focus', function() {
                        $input.addClass('has-focus');
                    })
                    .on('blur', function() {
                        $input.removeClass('has-focus');
                    });
            });
        }
    </script>
    <script>
        //Grid view system on product
        $(document).ready(function() {
            $('.grid-btn').on('click', function() {
                var columns = $(this).data('columns');
                var category = $(this).data('category');
                 console.log(columns);
                $('.product-column[data-category="' + category + '"]')
                    .removeClass('col-md-2 col-md-3 col-md-4 col-md-5 col-md-6')
                    .addClass('col-md-' + columns);

                $('.grid-btn[data-category="' + category + '"]').removeClass('active');
                $(this).addClass('active');
                // Apply fixed dimensions to images
                $('.productDesign[data-category="' + category + '"]')
                    .removeClass('product-box-col-2 product-box-col-3 product-box-col-4 product-box-col-6')
                    .addClass('product-box-col-' + columns);

                    $('.custom-height-img[data-category="' + category + '"]')
                    .removeClass(
                        'custom-height-img-6 custom-height-img-12 custom-height-img-3 custom-height-img-4 custom-height-img-2'
                    )
                    .addClass('custom-height-img-' + columns);
            });
        });
    </script>
    <script>
        //Grid view system on product in mobile responsive
        $(document).ready(function() {
            $('.grid-btn-mobile').on('click', function() {
                var columns = $(this).data('columns');
                var category = $(this).data('category');
                // console.log(columns);
                $('.product-column[data-category="' + category + '"]')
                    .removeClass('col-md-2 col-md-3 col-md-4 col-md-5 col-md-6 col-sm-12 col-sm-6')
                    .addClass('col-sm-' + columns);

                $('.grid-btn-mobile[data-category="' + category + '"]').removeClass('active');
                $(this).addClass('active');
                // Apply fixed dimensions to images
                $('.productDesign[data-category="' + category + '"]')
                    .removeClass(
                        'product-box-col-2 product-box-col-3 product-box-col-4 product-box-col-6 product-box-col-sm-12 product-box-col-sm-6'
                    )
                    .addClass('product-box-col-sm-' + columns);

                    $('.custom-height-img[data-category="' + category + '"]')
                    .removeClass(
                        'custom-height-img-6 custom-height-img-12 custom-height-img-3 custom-height-img-4 custom-height-img-2'
                    )
                    .addClass('custom-height-img-' + columns);
            });
        });
    </script>
    <script>
    $(document).ready(function () {
    let page = 1;

    $('#load-more-products').click(function() {
        page++;
        $.ajax({
            url: "?page=" + page,
            type: "GET",
            beforeSend: function() {
                $('#load-more-products').text('Loading...');
            }
        })
        .done(function(data) {
            if (data) {
                $('#product-list').append(data);
                if (!$('.pagination-links .pagination li.active').next('li').find('a').attr('href')) {
                    $('#load-more-products').remove();
                } else {
                    $('#load-more-products').text('Load More');
                }
            } else {
                $('#load-more-products').remove();
            }
        })
        .fail(function() {
            alert('Something went wrong.');
        });
    });

    $('#load-more').click(function () {
        page++;
        let category_id = $(this).data('category-id'); // Get category_id from data attribute

        $.ajax({
            url: "?page=" + page + "&category_id=" + category_id, // Append category_id
            type: "GET",
            beforeSend: function () {
                $('#load-more').text('Loading...');
            },
        })
        .done(function (data) {
            if (data.trim() !== "") {
                $('#product-list').append(data);

                // Check if pagination is finished
                if (!$('.pagination-links .pagination li.active').next('li').find('a').attr('href')) {
                    $('#load-more').remove();
                } else {
                    $('#load-more').text('Load More');
                }
            } else {
                $('#load-more').remove();
            }
        })
        .fail(function () {
            alert("Something went wrong.");
        });
    });

    $('#load-more-subcategory').click(function () {
        page++;
        let subcategory_id = $(this).data('subcategory-id'); // Get category_id from data attribute

        $.ajax({
            url: "?page=" + page + "&subcategory_id=" + subcategory_id, // Append category_id
            type: "GET",
            beforeSend: function () {
                $('#load-more-subcategory').text('Loading...');
            },
        })
        .done(function (data) {
            if (data.trim() !== "") {
                $('#product-list').append(data);

                // Check if pagination is finished
                if (!$('.pagination-links .pagination li.active').next('li').find('a').attr('href')) {
                    $('#load-more-subcategory').remove();
                } else {
                    $('#load-more-subcategory').text('Load More');
                }
            } else {
                $('#load-more-subcategory').remove();
            }
        })
        .fail(function () {
            alert("Something went wrong.");
        });
    });

    $('#load-more-subsubcategory').click(function () {
        page++;
        let subsubcategory_id = $(this).data('subsubcategory-id'); // Get category_id from data attribute

        $.ajax({
            url: "?page=" + page + "&subsubcategory_id=" + subsubcategory_id, // Append category_id
            type: "GET",
            beforeSend: function () {
                $('#load-more-subsubcategory').text('Loading...');
            },
        })
        .done(function (data) {
            if (data.trim() !== "") {
                $('#product-list').append(data);

                // Check if pagination is finished
                if (!$('.pagination-links .pagination li.active').next('li').find('a').attr('href')) {
                    $('#load-more-subsubcategory').remove();
                } else {
                    $('#load-more-subsubcategory').text('Load More');
                }
            } else {
                $('#load-more-subsubcategory').remove();
            }
        })
        .fail(function () {
            alert("Something went wrong.");
        });
    });
});
        </script>

<script>
    $(document).ready(function() {
        let page = 1; // Track the current page number

        // On click of Load More button
        $('#load-more-blog').click(function() {
            page++; // Increment the page number

            $.ajax({
                url: "?page=" + page,
                type: "GET",
                beforeSend: function() {
                    $('#load-more-blog').text('Loading...'); // Change button text while loading
                }
            })
            .done(function(data) {
                if (data) {
                    // Append new products to the list
                    $('#blog-list').append(data);

                    // Check if more pages are available
                    var nextPageLink = $('.pagination-links .pagination li.active').next('li').find('a').attr('href');
                    if (!nextPageLink) {
                        $('#load-more-blog').remove(); // Remove button if no more pages
                    } else {
                        $('#load-more-blog').text('Load More'); // Revert button text
                    }
                } else {
                    $('#load-more-blog').remove(); // No data means no more products
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
        });
    });
    </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
    const messageButton = document.getElementById("message-button");
    const messageMenu = document.getElementById("message-menu");

    messageButton.addEventListener("click", function () {
        messageMenu.style.display =
            messageMenu.style.display === "block" ? "none" : "block";
    });

    // Close the menu when clicking outside
    document.addEventListener("click", function (event) {
        if (!messageMenu.contains(event.target) && !messageButton.contains(event.target)) {
            messageMenu.style.display = "none";
        }
    });
});

function openFallback(url) {
    window.open(url, "_blank");
    return false;
}
        </script>

<!--Snowfall Start-->
 <script>
(function () {
    const root = document.getElementById('snowfall-root');
    const MAX = 35;

    for (let i = 0; i < MAX; i++) spawn();
// 💗 🌸 ❄
    function spawn() {
        const s = document.createElement('span');
        s.className = 'snowflake';
        s.innerHTML = '❄';
        const pinks = ['#ff69b4', '#ff85c1', '#ffb6c1'];
s.style.color = pinks[Math.floor(Math.random() * pinks.length)];

        s.style.left = Math.random() * 100 + 'vw';
        s.style.fontSize = (10 + Math.random() * 12) + 'px';
        s.style.opacity = Math.random();
        s.style.animationDuration = (6 + Math.random() * 6) + 's';

        root.appendChild(s);

        setTimeout(() => {
            s.remove();
            spawn();
        }, 12000);
    }

    /*  HARD FIX — bootstrap modal bug */
    document.addEventListener('hidden.bs.modal', function () {
        document.body.classList.remove('modal-open');
        document.body.style.overflow = 'auto';
        document.documentElement.style.overflow = 'auto';
    });
})();
</script>
<!--Snowfall End-->
    @yield('script')
    @stack('script')
<!-- Optional/Editor-related Scripts (only if needed on that page) -->
<script src="{{ asset('frontend/js/bootstrap-tagsinput.min.js') }}" defer></script>
<script src="{{ asset('frontend/js/jodit.min.js') }}" defer></script>

<!-- Image Zoom -->
<script src="{{ asset('frontend/js/xzoom.min.js') }}" defer></script>

<!-- Core Application Scripts -->
<script src="{{ asset('frontend/js/swiper-bundle.min.js') }}" ></script>
<script src="{{ asset('frontend/js/active-shop.js') }}" defer></script>
<script src="{{ asset('frontend/js/main.js') }}" defer></script>
</body>

</html>
