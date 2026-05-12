<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link name="favicon" type="image/x-icon" href="{{ asset(\App\Models\GeneralSetting::first()->favicon) }}"
        rel="shortcut icon" />

    <title>{{ config('app.name', 'Shundorjo') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Saira+Condensed:wght@300;400;500;700&display=swap" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:300,300i,400,400i,500,500i&display=swap"
        rel="stylesheet">
    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!--active-shop Stylesheet [ REQUIRED ]-->
    <link href="{{ asset('css/active-shop.min.css') }}" rel="stylesheet">

    <!--active-shop Premium Icon [ DEMONSTRATION ]-->
    <link href="{{ asset('css/demo/active-shop-demo-icons.min.css') }}" rel="stylesheet">

    <!--Font Awesome [ OPTIONAL ]-->
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!--Switchery [ OPTIONAL ]-->
    <link href="{{ asset('plugins/switchery/switchery.min.css') }}" rel="stylesheet">

    <!--DataTables [ OPTIONAL ]-->
    <link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css') }}"
        rel="stylesheet">

    <!--Select2 [ OPTIONAL ]-->
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!--Chosen [ OPTIONAL ]-->
    {{-- <link href="{{ asset('plugins/chosen/chosen.min.css')}}" rel="stylesheet"> --}}

    <!--Bootstrap Tags Input [ OPTIONAL ]-->
    <link href="{{ asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.css') }}" rel="stylesheet">

    <!--Summernote [ OPTIONAL ]-->
    <link href="{{ asset('css/jodit.min.css') }}" rel="stylesheet">

    <!--Theme [ DEMONSTRATION ]-->
    <!-- <link href="{{ asset('css/themes/type-full/theme-dark-full.min.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/themes/type-c/theme-navy.min.css') }}" rel="stylesheet">

    <!--Spectrum Stylesheet [ REQUIRED ]-->
    <link href="{{ asset('css/spectrum.css') }}" rel="stylesheet">

    <!--Custom Stylesheet [ REQUIRED ]-->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Datetimepicker CSS-->
    <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}">

    {{-- extra css --}}
    @yield('css')
    <!--shakil [ invoice required ]-->
    <link rel='stylesheet' type='text/css' href="{{ asset('invoice/css/style.css') }}" />
    <style>
        body {
            /* font-family: 'Saira Condensed', sans-serif;  */
            /*font-size: 1.2rem; letter-spacing: .4px;*/
            font-family: 'Montserrat', sans-serif;
        }

    </style>
    <!--JAVASCRIPT-->
    <!--=================================================-->

    <!--jQuery [ REQUIRED ]-->
    <script src=" {{ asset('js/jquery.min.js') }}"></script>

    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!--active-shop [ RECOMMENDED ]-->
    <script src="{{ asset('js/active-shop.min.js') }}"></script>

    <!--Alerts [ SAMPLE ]-->
    <script src="{{ asset('js/demo/ui-alerts.js') }}"></script>

    <!--Switchery [ OPTIONAL ]-->
    <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>

    <!--DataTables [ OPTIONAL ]-->
    <script src="{{ asset('plugins/datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/media/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>

    <!--DataTables Sample [ SAMPLE ]-->
    <script src="{{ asset('js/demo/tables-datatables.js') }}"></script>

    <!--Select2 [ OPTIONAL ]-->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <!--Summernote [ OPTIONAL ]-->
    <script src="{{ asset('js/jodit.min.js') }}"></script>

    <!--Bootstrap Tags Input [ OPTIONAL ]-->
    <script src="{{ asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

    <!--Bootstrap Validator [ OPTIONAL ]-->
    <script src="{{ asset('plugins/bootstrap-validator/bootstrapValidator.min.js') }}"></script>

    <!--Bootstrap Wizard [ OPTIONAL ]-->
    <script src="{{ asset('plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

    <!--Bootstrap Datepicker [ OPTIONAL ]-->
    <script src="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <!--Form Component [ SAMPLE ]-->
    <script src="{{ asset('js/demo/form-wizard.js') }}"></script>

    <!--Spectrum JavaScript [ REQUIRED ]-->
    <script src="{{ asset('js/spectrum.js') }}"></script>

    <!--Spartan Image JavaScript [ REQUIRED ]-->
    <script src="{{ asset('js/spartan-multi-image-picker-min.js') }}"></script>

    <!--Custom JavaScript [ REQUIRED ]-->
    <script src="{{ asset('js/custom.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            //$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
            if ($('.active-link').parent().parent().parent().is('ul')) {
                $('.active-link').parent().parent().addClass('in');
                $('.active-link').parent().parent().parent().addClass('in');
            }
            if ($('.active-link').parent().parent().is('li')) {
                $('.active-link').parent().parent().addClass('active-sub');
            }
            if ($('.active-link').parent().is('ul')) {
                $('.active-link').parent().addClass('in');
            }

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

        });
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    @if (\App\Models\BusinessSetting::where('type', 'google_analytics')->first()->value == 1)
        <script async src="https://www.googletagmanager.com/gtag/js?id=@php env('TRACKING_ID') @endphp"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', @php env('TRACKING_ID') @endphp);
        </script>
    @endif
   <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MQF6BDC3');</script>
<!-- End Google Tag Manager -->

</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQF6BDC3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    @foreach (session('flash_notification', collect())->toArray() as $message)
        <script type="text/javascript">
            $(document).on('nifty.ready', function() {
                showAlert('{{ $message['level'] }}', '{{ $message['message'] }}');
            });
        </script>
    @endforeach


    <div id="container" class="effect aside-float aside-bright mainnav-lg">

        @include('inc.admin_nav')

        <div class="boxed">

            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <div id="page-content">

                    @yield('content')

                </div>
            </div>
        </div>

        @include('inc.admin_sidenav')

        @include('inc.admin_footer')

        @include('partials.modal')

    </div>
    @yield('script')

</body>

</html>
