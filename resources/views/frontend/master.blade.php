<!-- saved from url=(0027)https://dinratri.aapbd.com/ -->
<html lang="en">
<script async="" src="{{asset('./files/analytics.js')}}"></script>
<script src="{{asset('./files/sdk.js')}}" async="" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf-8" id="zm-extension" src="chrome-extension://fdcgdnkidjaadafnichfpabhfomcebme/scripts/webrtc-patch.js" async=""></script>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Best online shopping websites in bangladesh dhaka, buy electronics, Clothes, Womens fashion, Buy mobile phones online at lowest prices for cash on delivery">
    <meta name="keywords" content="Online shopping websites in bangladesh, Online shopping in bangladesh dhaka, Best online shopping in bangladesh, Online shopping sites in bangladesh cash on delivery, Online shopping in bangladesh with home delivery, Online shopping websites for electronics, Best electronic online shopping, Online shopping websites for clothes, Womens fashion online shopping, Buy mobile phones online at lowest prices, Dinratri, Dinratri com, Books, Online Shopping, Book Store, Magazine, Subscription, Music, CDs, DVDs, Videos, Electronics, Video Games, Computers, Cell Phones, Toys, Games, Apparel, Accessories, Shoes, Jewelry, Watches, Office Products, Sports Outdoors, Sporting Goods, Baby Products, Health, Personal Care, Beauty, Home, Garden, Bed Bath, Furniture, Tools, Hardware, Vacuums, Outdoor Living, Automotive Parts, Pet Supplies, Broadband, DSL, Marketplace in Bangladesh">
    <meta name="author" content="Best online shopping websites in Bangladesh Dhaka l electronics l Clothes l Women fashion l Mobile phones">
    <meta name="_token" content="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs">
    <meta name="csrf-token" content="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs">
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
        });
    </script>

    <!-- Bootstrap style -->
    @yield('css_up')
   
</head>

<body cz-shortcut-listen="true">

    <!--Loader & alert-->
    <div id="loader" style="position: absolute; display: none;">
        <div class="loader-inner"></div>

        <div class="loader-section"></div>
    </div>

    <div id="loadalert" class="alert-success" style="margin-top:18px; display: none; position: fixed; z-index: 9999; width: 50%; text-align: center; left: 25%; padding: 10px;">
        <a href="https://dinratri.aapbd.com/#" class="close">×</a>
        <strong>Please Check Your Mail</strong>
    </div>

    <!--Loader & alert-->

    <div class="loginSuccess">

    </div>
    <div id="mobile-menu" style="left: -250px; width: 250px;">

        <ul class="mobile-menu">

            <li><span class="expand fa fa-plus"></span><a href="https://dinratri.aapbd.com/catproducts/viewcategorylist/MSwyMjI=" style="padding-right: 55px;">

                                 WOMEN
           </a>

                <ul class="" style="display: none;">
                    <li><a href="https://dinratri.aapbd.com/catproducts/viewcategorylist/Miw3MA==">

               CLOTHING
                           </a>
                    </li>
                </ul>
            </li>
            <li><span class="expand fa fa-plus"></span><a href="https://dinratri.aapbd.com/catproducts/viewcategorylist/MSwyMjQ=" style="padding-right: 55px;">

                                 ELECTRONICS
           </a>

                <ul class="" style="display: none;">
                    <li><a href="https://dinratri.aapbd.com/catproducts/viewcategorylist/Miw5Mg==">

               HOME APPLIANCES
                           </a>
                    </li>
                </ul>
            </li>
            <li><span class="expand fa fa-plus"></span><a href="https://dinratri.aapbd.com/catproducts/viewcategorylist/MSwyMjU=" style="padding-right: 55px;">

                                 HOME APPLIANCE 
           </a>

                <ul class="" style="display: none;">
                    <li><span class="expand fa fa-plus"></span><a href="https://dinratri.aapbd.com/catproducts/viewcategorylist/Miw5OA==" style="padding-right: 55px;">

               KITCHEN
                           </a>

                        <ul class="" style="display: none;">
                            <li><a href="https://dinratri.aapbd.com/catproducts/viewcategorylist/MywyNzg=">

                                                      Kitchen Appliances
                  </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li><a href="https://dinratri.aapbd.com/category_list_all">
                 More Categories                  </a>
            </li>

            <li style="height: 30px;"></li>
        </ul>
    </div>
    <div id="page">

        @include('frontend.include.header')
        @include('frontend.include.nav')

        <script>
            function myFunction(x) {
                x.classList.toggle("change");
                var element = document.getElementById("res_menu");
                element.classList.toggle("active");
            }
        </script>
        <div class="preloader-wrapper" style="display: none;">
            <div class="preloader">
                <!--   <img src="http://prorabbi.website/nila/assets/images/preloader.gif" alt="NILA">-->
            </div>
        </div>

        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $('.preloader-wrapper').fadeOut();
                }, 3);
            });
        </script>
        @yield('main_content')
      
        <style>
            input[type='text'],
            input[type="submit"] {
                display: inline-block;
            }
        </style>

        @include('frontend.include.footer')

        <!-- jquery js -->
        <script type="text/javascript" src="{{asset('./files/jquery.min.js')}}"></script>

        <!-- bootstrap js -->
        <script type="text/javascript" src="{{asset('./files/bootstrap.min.js')}}"></script>

        <!-- owl.carousel.min js -->
        <script type="text/javascript" src="{{asset('./files/owl.carousel.min.js')}}"></script>

        <!-- jquery.mobile-menu js -->
        <script type="text/javascript" src="{{asset('./files/mobile-menu.js')}}"></script>

        <!--jquery-ui.min js -->
        <script type="text/javascript" src="{{asset('./files/jquery-ui.js')}}"></script>

        <!-- main js -->
        <script type="text/javascript" src="{{asset('./files/main.js')}}"></script>

        <!-- flexslider js -->
        <script type="text/javascript" src="{{asset('./files/jquery.flexslider.js')}}"></script>

        <!-- countdown js -->
        <script type="text/javascript" src="{{asset('./files/countdown.js')}}"></script>

        <!-- Slider Js -->
        <script type="text/javascript" src="{{asset('./files/revolution-slider.js')}}"></script>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery('#rev_slider_4').show().revolution({
                    dottedOverlay: 'none',
                    delay: 5000,
                    startwidth: 865,
                    startheight: 450,

                    hideThumbs: 200,
                    thumbWidth: 200,
                    thumbHeight: 50,
                    thumbAmount: 2,

                    navigationType: 'thumb',
                    navigationArrows: 'solo',
                    navigationStyle: 'round',

                    touchenabled: 'on',
                    onHoverStop: 'on',

                    swipe_velocity: 0.7,
                    swipe_min_touches: 1,
                    swipe_max_touches: 1,
                    drag_block_vertical: false,

                    spinner: 'spinner0',
                    keyboardNavigation: 'off',

                    navigationHAlign: 'center',
                    navigationVAlign: 'bottom',
                    navigationHOffset: 0,
                    navigationVOffset: 20,

                    soloArrowLeftHalign: 'left',
                    soloArrowLeftValign: 'center',
                    soloArrowLeftHOffset: 20,
                    soloArrowLeftVOffset: 0,

                    soloArrowRightHalign: 'right',
                    soloArrowRightValign: 'center',
                    soloArrowRightHOffset: 20,
                    soloArrowRightVOffset: 0,

                    shadow: 0,
                    fullWidth: 'on',
                    fullScreen: 'off',

                    stopLoop: 'off',
                    stopAfterLoops: -1,
                    stopAtSlide: -1,

                    shuffle: 'off',

                    autoHeight: 'off',
                    forceFullWidth: 'on',
                    fullScreenAlignForce: 'off',
                    minFullScreenHeight: 0,
                    hideNavDelayOnMobile: 1500,

                    hideThumbsOnMobile: 'off',
                    hideBulletsOnMobile: 'off',
                    hideArrowsOnMobile: 'off',
                    hideThumbsUnderResolution: 0,

                    hideSliderAtLimit: 0,
                    hideCaptionAtLimit: 0,
                    hideAllCaptionAtLilmit: 0,
                    startWithSlide: 0,
                    fullScreenOffsetContainer: ''
                });
            });
        </script>
        <!-- extension Js -->
        <script type="text/javascript" src="{{asset('./files/revolution-extension.js')}}"></script>

        <!-- bxslider js -->
        <script type="text/javascript" src="{{asset('./files/jquery.bxslider.js')}}"></script>

        <!-- carousel js -->
        <!-- <script type="text/javascript" src="/public/themes/js/owl.carousel.rtl.js"></script> -->

        <!--cloud-zoom js -->
        <script type="text/javascript" src="{{asset('./files/cloud-zoom.js')}}"></script>

        <script type="text/javascript">
            $(window).load(function() {

                $('#upload_add').click(function() {

                    var position = $("#ad_pos option:selected").val();
                    var page = $("#ad_pages option:selected").val();

                    if ($('#ad_title').val() == "") {
                        $('#ad_title').css('border', '1px solid red');
                        $('#ad_title').focus();
                        return false;
                    } else {
                        $('#ad_title').css('border', '');
                    }
                    if (position == 0) {
                        $('#ad_pos').css('border', '1px solid red');
                        $('#ad_pos').focus();
                        return false;
                    } else {
                        $('#ad_pos').css('border', '');
                    }
                    if (page == 0) {
                        $('#ad_pages').css('border', '1px solid red');
                        $('#ad_pages').focus();
                        return false;
                    } else {
                        $('#ad_pages').css('border', '');
                    }
                    if ($('#ad_url').val() == "") {
                        $('#ad_url').css('border', '1px solid red');
                        $('#ad_url').focus();
                        return false;
                    } else {
                        var txt = $('#ad_url').val();
                        var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
                        if (re.test(txt)) {
                            $('#ad_url').css('border', '');
                        } else {
                            $('#ad_url').css('border', '1px solid red');
                            $('#ad_url').focus();
                            return false;
                        }

                    }
                    if ($('#file').val() == '') {
                        alert('Image field required!');
                        return false;
                    } else {

                        var title = $('#ad_title').val();
                        var pass = "title=" + title;
                        $.ajax({
                            type: 'get',
                            data: pass,
                            url: 'https://dinratri.aapbd.com/check_title',
                            success: function(responseText) {

                                if (responseText == "success") {
                                    $('#error_name').html('Thank You ,Your request should be processed soon');
                                    $("#uploadform").submit();
                                } else {
                                    $('#ad_title').css('border', '1px solid red');
                                    $('#ad_title').focus();
                                    $('#error_name').html('Ad title already exists');
                                }
                            }
                        });

                    }

                });
                $('#news_result').hide();
                $('#newsletter').click(function() {
                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    var sname4 = $('#sname4');
                    if (sname4.val() == "") {
                        $(sname4).focus();
                        $(sname4).css("border", "red solid 1px");
                        return false;
                    } else if ($.trim(sname4.val()) == "") {
                        $(sname4).focus();
                        $(sname4).css("border", "red solid 1px");
                        return false;
                    } else if (!emailReg.test(sname4.val())) {
                        $(sname4).focus();
                        $(sname4).css("border", "red solid 1px");
                        return false;
                    } else {
                        $('#newsletter').hide();
                        $(sname4).css("border", "#CCCCCC solid 1px");
                        var passData = 'semail=' + sname4.val();
                        $.ajax({
                            type: 'GET',
                            data: passData,
                            url: 'https://dinratri.aapbd.com/front_newsletter_submit',
                            success: function(responseText) {
                                //alert(responseText);
                                $('#news_result').show();
                                setTimeout(function() {
                                    window.location.reload();
                                }, 3000);

                            }
                        });
                        return false;

                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $(".search").keyup(function(e) {

                    var searchbox = $(this).val();
                    var dataString = 'searchword=' + searchbox;
                    if (searchbox == '') {
                        $("#display").html("").hide();
                    } else {
                        var passData = 'searchword=' + searchbox + '&url=/';
                        //alert(passData);
                        $.ajax({
                            type: 'GET',
                            data: passData,
                            url: 'https://dinratri.aapbd.com/autosearch',
                            success: function(responseText) {
                                $("#display").html(responseText).show();
                            }
                        });
                    }
                    return false;

                });
            });

            /*var __lc = {};
            __lc.license = 4302571;

            (function() {
             var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
             lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
             var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
            })();*/
        </script>

        <script type="text/javascript">
            /*var __lc = {};
            __lc.license = 6132091;

            (function() {
              var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
              lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
              var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
            })();*/
        </script>

        <script>
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-62671250-1', 'auto');
            ga('send', 'pageview');
        </script>

        <script>
            //paste this code under head tag or in a seperate js file.
            // Wait for window load
            $(window).load(function() {
                // Animate loader off screen
                $(".se-pre-con").fadeOut("slow");;
            });
        </script>

        <script>
            $('document').ready(function() {
                console.clear();

                $('#demo').jplist({

                    itemsBox: '.list',
                    itemPath: '.list-item',
                    panelPath: '.jplist-panel'

                    //save plugin state
                    ,
                    storage: 'localstorage' //'', 'cookies', 'localstorage'     
                        ,
                    storageName: 'jplist-div-layout'
                });
                $(".loading_prnt").hide();
                $(".productLoading").css("opacity", "1");

            });
        </script>

        <script type="text/javascript">
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 2000);
        </script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
        </script>
        <script type="text/javascript">
            $(document).on("click", ".quick-view", function() {
                $(window).trigger('resize');

                setTimeout(function() {
                    $(window).trigger('resize');
                });
                $(window).scrollTop(0);
            });
        </script>

        <!--quick view best rated-->

        <input type="hidden" id="pro_qty_hidden_96" name="pro_qty_hidden" value="10">
        <input type="hidden" id="pro_purchase_hidden_96" name="pro_purchase_hidden" value="1">
        <div style="display: none;" class="quick_view_popup-wrap hh" id="quick_view_popup-wrap96">
            <div id="quick_view_popup-overlay"></div>
            <div id="quick_view_popup-outer">
                <div id="quick_view_popup-content">
                    <div style="width:auto;height:auto;overflow: auto;position:relative;">
                        <div class="product-view-area">
                            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
                                <div class="large-image">
                                    <a href="./files/Product_155341492350042423.jpg" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img class="" src="{{asset('./files/Product_155341492350042423.jpg')}}"> </a>
                                </div>
                                <div class="flexslider flexslider-thumb">

                                    <div class="flex-viewport" style="overflow: hidden; position: relative;">
                                        <ul class="previews-list slides" style="width: 600%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                                            <!-- //product image is not null and exists in folder -->

                                            <li style="width: 0px; float: left; display: block;">
                                                <a href="./files/Product_155341492350042423.jpg" class="cloud-zoom-gallery" rel="useZoom: &#39;zoom1&#39;, smallImage: &#39;https://dinratri.aapbd.com/public/assets/product/Product_155341492350042423.jpg&#39; "><img src="{{asset('./files/Product_155341492350042423.jpg')}}" alt="Thumbnail 2" draggable="false"></a>
                                            </li>
                                            <!-- //product image is not null and exists in folder -->

                                            <li style="width: 0px; float: left; display: block;">
                                                <a href="./files/Product_1553414923551316973.jpg" class="cloud-zoom-gallery" rel="useZoom: &#39;zoom1&#39;, smallImage: &#39;https://dinratri.aapbd.com/public/assets/product/Product_1553414923551316973.jpg&#39; "><img src="{{asset('./files/Product_1553414923551316973.jpg')}}" alt="Thumbnail 2" draggable="false"></a>
                                            </li>
                                            <!-- //product image is not null and exists in folder -->

                                            <li style="width: 0px; float: left; display: block;">
                                                <a href="./files/Product_1553414923594337208.jpg" class="cloud-zoom-gallery" rel="useZoom: &#39;zoom1&#39;, smallImage: &#39;https://dinratri.aapbd.com/public/assets/product/Product_1553414923594337208.jpg&#39; "><img src="{{asset('./files/Product_1553414923594337208.jpg')}}" alt="Thumbnail 2" draggable="false"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="flex-direction-nav">
                                        <li>
                                            <a class="flex-prev flex-disabled" href="https://dinratri.aapbd.com/#" tabindex="-1"></a>
                                        </li>
                                        <li>
                                            <a class="flex-next" href="https://dinratri.aapbd.com/#"></a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end: more-images -->
                            </div>
                            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7">
                                <div class="product-details-area">
                                    <div class="product-name">
                                        <h1> Manual Hand mixer 

                        </h1>
                                    </div>
                                    <div class="price-box">
                                        <p class="special-price"> <span class="price-label"></span> <span class="price"> BDT 265.00 </span> </p>
                                        <p class="old-price"> <span class="price-label"></span> <span class="price"> BDT 350.00 </span> </p>
                                    </div>
                                    <div class="ratings">
                                        <div class="rating">

                                            <i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>

                                        </div>
                                        <p class="availability in-stock pull-right"> Available Stock : <span>9   In Stock </span></p>
                                    </div>
                                    <div class="short-description">
                                        <h2> Quick Overview </h2>

                                        <div class="micheal"></div>
                                        <!--  -->
                                        <p>
                                            <!-- <ul><li>Hand Blender | Mixer | Milk Frother | Butter Milk Lassi Maker | Hand Free Blender Mixer | Egg Beater | Lassi Butter | Coffee Milk Egg Beater Mixer Shaker</li></ul><span>Power Free Hand Blender -->
                                        </p>
                                        <ul>
                                            <li>Hand Blender | Mixer | Milk Frother | Butter Milk Lassi Maker | Hand Free Blender Mixer | Egg Beater | Lassi Butter | Coffee Milk Egg Beater Mixer Shaker</li>
                                        </ul><span>Power Free Hand Blender (Butter Milk Lassi Maker Hand Free Blender Mixer Egg Beater Lassi Butter Coffee Milk Egg Beater Mixer Shaker)<br><br></span>
                                        <p></p>
                                    </div>
                                    <div class="product-color-size-area">

                                        <div class="size-area">
                                            <h2 class="saider-bar-title"> Size </h2>
                                            <div class="size">
                                                <select name="addtocart_size" id="addtocart_size_96" required="">
                                                    <option value="">-- Select Size --</option>

                                                    <option value="11">
                                                        No Size
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-variation">
                                        <form method="POST" action="https://dinratri.aapbd.com/addtocart" accept-charset="UTF-8" class="submit_form" enctype="multipart/form-data">
                                            <input name="_token" type="hidden" value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs">

                                            <div class="cart-plus-minus">
                                                <label for="qty"> Quantity :</label>
                                                <div class="numbers-row">
                                                    <div onclick="remove_quantity(96)" class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i></div>
                                                    <input type="number" class="qty" min="1" value="1" max="9" id="addtocart_qty_96" name="addtocart_qty" readonly="" required="">
                                                    <div onclick="add_quantity(96)" class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i></div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="_token" value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs">
                                            <input name="addtocart_type" type="hidden" value="product">
                                            <input name="addtocart_pro_id" type="hidden" value="96">

                                            <a href="https://dinratri.aapbd.com/" role="button" data-toggle="modal" data-target="#loginpop">
                                                <button type="button" class=" button pro-add-to-cart">
                                                    <span><i class="fa fa-shopping-basket" aria-hidden="true"></i> 
                         Add to cart </span>
                                                </button>
                                            </a>

                                        </form>
                                    </div>
                                    <div class="product-cart-option">
                                        <ul>
                                            <li>

                                                <a href="https://dinratri.aapbd.com/" role="button" data-toggle="modal" data-target="#loginpop">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i> Add to Wishlist </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--product-view-->
                    </div>
                </div>
                <a style="display: inline;" id="quick_view_popup-close" href="https://dinratri.aapbd.com/index"><i class="icon pe-7s-close"></i></a>
            </div>
        </div>

        <input type="hidden" id="pro_qty_hidden_97" name="pro_qty_hidden" value="12">
        <input type="hidden" id="pro_purchase_hidden_97" name="pro_purchase_hidden" value="0">
        <div style="display: none;" class="quick_view_popup-wrap hh" id="quick_view_popup-wrap97">
            <div id="quick_view_popup-overlay"></div>
            <div id="quick_view_popup-outer">
                <div id="quick_view_popup-content">
                    <div style="width:auto;height:auto;overflow: auto;position:relative;">
                        <div class="product-view-area">
                            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
                                <div class="large-image">
                                    <a href="./files/Product_1553755958285560052.jpg" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img class="" src="{{asset('./files/Product_1553755958285560052.jpg')}}"> </a>
                                </div>
                                <div class="flexslider flexslider-thumb">
                                    <ul class="previews-list slides">
                                        <!-- //product image is not null and exists in folder -->

                                        <li style="width: 100px; float: left; display: block;">
                                            <a href="./files/Product_1553755958285560052.jpg" class="cloud-zoom-gallery" rel="useZoom: &#39;zoom1&#39;, smallImage: &#39;https://dinratri.aapbd.com/public/assets/product/Product_1553755958285560052.jpg&#39; "><img src="{{asset('./files/Product_1553755958285560052.jpg')}}" alt="Thumbnail 2"></a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end: more-images -->
                            </div>
                            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7">
                                <div class="product-details-area">
                                    <div class="product-name">
                                        <h1>Iron max

                        </h1>
                                    </div>
                                    <div class="price-box">
                                        <p class="special-price"> <span class="price-label"></span> <span class="price"> BDT 1000.00 </span> </p>
                                        <p class="old-price"> <span class="price-label"></span> <span class="price"> BDT 1200.00 </span> </p>
                                    </div>
                                    <div class="ratings">
                                        <div class="rating">

                                            <i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>

                                        </div>
                                        <p class="availability in-stock pull-right"> Available Stock : <span>12   In Stock </span></p>
                                    </div>
                                    <div class="short-description">
                                        <h2> Quick Overview </h2>

                                        <div class="micheal"></div>
                                        <!--  -->
                                        <p>
                                            <!-- <p>This product is made by china.<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAtCAYAAAAHpEG5AAALF0lEQVR4nO2dT2wjVx3HP17RrdQtxQsIqSquJqV4XQFdV9ATEp1wg0P+4Fy4dON7xMa55LbW7C2XeLfyPU4vXBz --></p>
                                        <p>This product is made by china.<img src="data:image/png;base64,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" data-filename="Logo_1551004966.png" style="width: 180px;"></p>
                                        <p></p>
                                    </div>
                                    <div class="product-color-size-area">

                                        <div class="size-area">
                                            <h2 class="saider-bar-title"> Size </h2>
                                            <div class="size">
                                                <select name="addtocart_size" id="addtocart_size_97" required="">
                                                    <option value="">-- Select Size --</option>

                                                    <option value="11">
                                                        No Size
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-variation">
                                        <form method="POST" action="https://dinratri.aapbd.com/addtocart" accept-charset="UTF-8" class="submit_form" enctype="multipart/form-data">
                                            <input name="_token" type="hidden" value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs">

                                            <div class="cart-plus-minus">
                                                <label for="qty"> Quantity :</label>
                                                <div class="numbers-row">
                                                    <div onclick="remove_quantity(97)" class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i></div>
                                                    <input type="number" class="qty" min="1" value="1" max="12" id="addtocart_qty_97" name="addtocart_qty" readonly="" required="">
                                                    <div onclick="add_quantity(97)" class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i></div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="_token" value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs">
                                            <input name="addtocart_type" type="hidden" value="product">
                                            <input name="addtocart_pro_id" type="hidden" value="97">

                                            <a href="https://dinratri.aapbd.com/" role="button" data-toggle="modal" data-target="#loginpop">
                                                <button type="button" class=" button pro-add-to-cart">
                                                    <span><i class="fa fa-shopping-basket" aria-hidden="true"></i> 
                         Add to cart </span>
                                                </button>
                                            </a>

                                        </form>
                                    </div>
                                    <div class="product-cart-option">
                                        <ul>
                                            <li>

                                                <a href="https://dinratri.aapbd.com/" role="button" data-toggle="modal" data-target="#loginpop">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i> Add to Wishlist </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--product-view-->
                    </div>
                </div>
                <a style="display: inline;" id="quick_view_popup-close" href="https://dinratri.aapbd.com/index"><i class="icon pe-7s-close"></i></a>
            </div>
        </div>

        <input type="hidden" id="pro_qty_hidden_94" name="pro_qty_hidden" value="100">
        <input type="hidden" id="pro_purchase_hidden_94" name="pro_purchase_hidden" value="1">
        <div style="display: none;" class="quick_view_popup-wrap hh" id="quick_view_popup-wrap94">
            <div id="quick_view_popup-overlay"></div>
            <div id="quick_view_popup-outer">
                <div id="quick_view_popup-content">
                    <div style="width:auto;height:auto;overflow: auto;position:relative;">
                        <div class="product-view-area">
                            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
                                <div class="large-image">
                                    <a href="./files/Product_15527560531491433287.jpg" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img class="" src="{{asset('./files/Product_15527560531491433287.jpg')}}"> </a>
                                </div>
                                <div class="flexslider flexslider-thumb">
                                    <ul class="previews-list slides">
                                        <!-- //product image is not null and exists in folder -->

                                        <li style="width: 100px; float: left; display: block;">
                                            <a href="./files/Product_15527560531491433287.jpg" class="cloud-zoom-gallery" rel="useZoom: &#39;zoom1&#39;, smallImage: &#39;https://dinratri.aapbd.com/public/assets/product/Product_15527560531491433287.jpg&#39; "><img src="{{asset('./files/Product_15527560531491433287.jpg')}}" alt="Thumbnail 2"></a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end: more-images -->
                            </div>
                            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7">
                                <div class="product-details-area">
                                    <div class="product-name">
                                        <h1>Test product By Biplob

                        </h1>
                                    </div>
                                    <div class="price-box">
                                        <p class="special-price"> <span class="price-label"></span> <span class="price"> BDT 90.00 </span> </p>
                                        <p class="old-price"> <span class="price-label"></span> <span class="price"> BDT 100.00 </span> </p>
                                    </div>
                                    <div class="ratings">
                                        <div class="rating">

                                            <i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>

                                        </div>
                                        <p class="availability in-stock pull-right"> Available Stock : <span>99   In Stock </span></p>
                                    </div>
                                    <div class="short-description">
                                        <h2> Quick Overview </h2>

                                        <div class="micheal"></div>
                                        <!--  -->
                                        <p>
                                            <!-- <p><br>Test product, don't buy it<br>Test product, don't buy it<br>Test product, don't buy it<br>Test product, don't buy it<br>Test product, don't buy it<br>Test product, don't buy it<br>Test product, --></p>
                                        <p>
                                            <br>Test product, don't buy it
                                            <br>Test product, don't buy it
                                            <br>Test product, don't buy it
                                            <br>Test product, don't buy it
                                            <br>Test product, don't buy it
                                            <br>Test product, don't buy it
                                            <br>Test product, don't buy it
                                            <br>
                                        </p>
                                        <p><img src=""  style="width: 729px;">
                                            <br>
                                        </p>
                                        <p>
                                            <br>
                                        </p>
                                        <p>
                                            <br>
                                        </p>
                                        <p>
                                            <br>
                                        </p>
                                        <p>
                                            <iframe frameborder="0" src="./files/_O1JIvKtCXE.html" width="640" height="360" class="note-video-clip"></iframe>
                                            <br>
                                        </p>
                                        <p>
                                            <br>
                                        </p>
                                        <p>
                                            <br>Test product, don't buy it
                                            <br>Test product, don't buy it
                                            <br>
                                        </p>
                                        <p>
                                            <br>
                                        </p>
                                        <p>
                                            <br>
                                        </p>
                                        <p>
                                            <br>
                                        </p>
                                        <p></p>
                                    </div>
                                    <div class="product-color-size-area">

                                        <div class="size-area">
                                            <h2 class="saider-bar-title"> Size </h2>
                                            <div class="size">
                                                <select name="addtocart_size" id="addtocart_size_94" required="">
                                                    <option value="">-- Select Size --</option>

                                                    <option value="11">
                                                        No Size
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-variation">
                                        <form method="POST" action="https://dinratri.aapbd.com/addtocart" accept-charset="UTF-8" class="submit_form" enctype="multipart/form-data">
                                            <input name="_token" type="hidden" value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs">

                                            <div class="cart-plus-minus">
                                                <label for="qty"> Quantity :</label>
                                                <div class="numbers-row">
                                                    <div onclick="remove_quantity(94)" class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i></div>
                                                    <input type="number" class="qty" min="1" value="1" max="99" id="addtocart_qty_94" name="addtocart_qty" readonly="" required="">
                                                    <div onclick="add_quantity(94)" class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i></div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="_token" value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs">
                                            <input name="addtocart_type" type="hidden" value="product">
                                            <input name="addtocart_pro_id" type="hidden" value="94">

                                            <a href="https://dinratri.aapbd.com/" role="button" data-toggle="modal" data-target="#loginpop">
                                                <button type="button" class=" button pro-add-to-cart">
                                                    <span><i class="fa fa-shopping-basket" aria-hidden="true"></i> 
                         Add to cart </span>
                                                </button>
                                            </a>

                                        </form>
                                    </div>
                                    <div class="product-cart-option">
                                        <ul>
                                            <li>

                                                <a href="https://dinratri.aapbd.com/" role="button" data-toggle="modal" data-target="#loginpop">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i> Add to Wishlist </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--product-view-->
                    </div>
                </div>
                <a style="display: inline;" id="quick_view_popup-close" href="https://dinratri.aapbd.com/index"><i class="icon pe-7s-close"></i></a>
            </div>
        </div>
        <!--end qiuck view best rated-->

        <input type="hidden" id="pro_qty_hidden_offer_96" name="pro_qty_hidden_offer" value="10">
        <input type="hidden" id="pro_purchase_hidden_offer_96" name="pro_purchase_hidden_offer" value="1">
        <div style="display:none;" class="quick_view_popup-wrap" id="quick_view_popup-wrap_offer96">
            <div id="quick_view_popup-overlay"></div>
            <div id="quick_view_popup-outer">
                <div id="quick_view_popup-content">
                    <div style="width:auto;height:auto;overflow: auto;position:relative;">
                        <div class="product-view-area">
                            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
                                <div class="large-image">
                                    <a href="./files/Product_155341492350042423.jpg" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img class="" src="{{asset('./files/Product_155341492350042423.jpg')}}"> </a>
                                </div>
                                <div class="flexslider flexslider-thumb">

                                    <div class="flex-viewport" style="overflow: hidden; position: relative;">
                                        <ul class="previews-list slides" style="width: 600%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                                            <!-- //product image is not null and exists in folder -->

                                            <li style="width: 0px; float: left; display: block;">
                                                <a href="./files/Product_155341492350042423.jpg" class="cloud-zoom-gallery" rel="useZoom: &#39;zoom1&#39;, smallImage: &#39;https://dinratri.aapbd.com/public/assets/product/Product_155341492350042423.jpg&#39; "><img src="{{asset('./files/Product_155341492350042423.jpg')}}" alt="Thumbnail 2" draggable="false"></a>
                                            </li>
                                            <!-- //product image is not null and exists in folder -->

                                            <li style="width: 0px; float: left; display: block;">
                                                <a href="./files/Product_1553414923551316973.jpg" class="cloud-zoom-gallery" rel="useZoom: &#39;zoom1&#39;, smallImage: &#39;https://dinratri.aapbd.com/public/assets/product/Product_1553414923551316973.jpg&#39; "><img src="{{asset('./files/Product_1553414923551316973.jpg')}}" alt="Thumbnail 2" draggable="false"></a>
                                            </li>
                                            <!-- //product image is not null and exists in folder -->

                                            <li style="width: 0px; float: left; display: block;">
                                                <a href="./files/Product_1553414923594337208.jpg" class="cloud-zoom-gallery" rel="useZoom: &#39;zoom1&#39;, smallImage: &#39;https://dinratri.aapbd.com/public/assets/product/Product_1553414923594337208.jpg&#39; "><img src="{{asset('./files/Product_1553414923594337208.jpg')}}" alt="Thumbnail 2" draggable="false"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="flex-direction-nav">
                                        <li>
                                            <a class="flex-prev flex-disabled" href="https://dinratri.aapbd.com/#" tabindex="-1"></a>
                                        </li>
                                        <li>
                                            <a class="flex-next" href="https://dinratri.aapbd.com/#"></a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end: more-images -->
                            </div>
                            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7">
                                <div class="product-details-area">
                                    <div class="product-name">
                                        <h1> Manual Hand mixer 

                        </h1>
                                    </div>
                                    <div class="price-box">
                                        <p class="special-price"> <span class="price-label"></span> <span class="price">BDT 265.00 </span> </p>
                                        <p class="old-price"> <span class="price-label"></span> <span class="price"> BDT 350.00 </span> </p>
                                    </div>
                                    <div class="ratings">
                                        <div class="rating">

                                            <i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>

                                        </div>
                                        <p class="availability in-stock pull-right"> Available Stock : <span>9   In Stock </span></p>
                                    </div>
                                    <div class="short-description">
                                        <h2> Quick Overview </h2>

                                        <p></p>
                                        <ul>
                                            <li>Hand Blender | Mixer | Milk Frother | Butter Milk Lassi Maker | Hand Free Blender Mixer | Egg Beater | Lassi Butter | Coffee Milk Egg Beater Mixer Shaker</li>
                                        </ul><span>Power Free Hand Blender<p></p>
                     </span></div>
                                    <div class="product-color-size-area">

                                        <div class="size-area">
                                            <h2 class="saider-bar-title"> Size </h2>
                                            <div class="size">
                                                <select name="addtocart_size" id="addtocart_size_offer_96" required="">
                                                    <option value="">-- Select Size --</option>

                                                    <option value="11">
                                                        No Size
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-variation">
                                        <form method="POST" action="https://dinratri.aapbd.com/addtocart" accept-charset="UTF-8" class="submit_form_offer" enctype="multipart/form-data">
                                            <input name="_token" type="hidden" value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs">

                                            <div class="cart-plus-minus">
                                                <label for="qty"> Quantity :</label>
                                                <div class="numbers-row">
                                                    <div onclick="remove_quantity_offer(96)" class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i></div>
                                                    <input type="number" class="qty" min="1" value="1" max="9" id="addtocart_qty_offer_96" name="addtocart_qty" readonly="" required="">
                                                    <div onclick="add_quantity_offer(96)" class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i></div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="_token" value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs">
                                            <input name="addtocart_type" type="hidden" value="product">
                                            <input name="addtocart_pro_id" type="hidden" value="96">

                                            <a href="https://dinratri.aapbd.com/" role="button" data-toggle="modal" data-target="#loginpop">
                                                <button type="button" class=" button pro-add-to-cart">
                                                    <span><i class="fa fa-shopping-basket" aria-hidden="true"></i> 
                         Add to cart </span>
                                                </button>
                                            </a>

                                        </form>
                                    </div>
                                    <div class="product-cart-option">
                                        <ul>
                                            <li>

                                                <a href="https://dinratri.aapbd.com/" role="button" data-toggle="modal" data-target="#loginpop">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i> Add to Wishlist </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--product-view-->
                    </div>
                </div>
                <a style="display: inline;" id="quick_view_popup-close" href="https://dinratri.aapbd.com/index"><i class="icon pe-7s-close"></i></a>
            </div>
        </div>

        <input type="hidden" id="pro_qty_hidden_offer_97" name="pro_qty_hidden_offer" value="12">
        <input type="hidden" id="pro_purchase_hidden_offer_97" name="pro_purchase_hidden_offer" value="0">
        <div style="display:none;" class="quick_view_popup-wrap" id="quick_view_popup-wrap_offer97">
            <div id="quick_view_popup-overlay"></div>
            <div id="quick_view_popup-outer">
                <div id="quick_view_popup-content">
                    <div style="width:auto;height:auto;overflow: auto;position:relative;">
                        <div class="product-view-area">
                            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
                                <div class="large-image">
                                    <a href="./files/Product_1553755958285560052.jpg" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img class="" src="./files/Product_1553755958285560052.jpg"> </a>
                                </div>
                                <div class="flexslider flexslider-thumb">
                                    <ul class="previews-list slides">
                                        <!-- //product image is not null and exists in folder -->

                                        <li style="width: 100px; float: left; display: block;">
                                            <a href="./files/Product_1553755958285560052.jpg" class="cloud-zoom-gallery" rel="useZoom: &#39;zoom1&#39;, smallImage: &#39;https://dinratri.aapbd.com/public/assets/product/Product_1553755958285560052.jpg&#39; "><img src="./files/Product_1553755958285560052.jpg" alt="Thumbnail 2"></a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end: more-images -->
                            </div>
                            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7">
                                <div class="product-details-area">
                                    <div class="product-name">
                                        <h1>Iron max

                        </h1>
                                    </div>
                                    <div class="price-box">
                                        <p class="special-price"> <span class="price-label"></span> <span class="price">BDT 1000.00 </span> </p>
                                        <p class="old-price"> <span class="price-label"></span> <span class="price"> BDT 1200.00 </span> </p>
                                    </div>
                                    <div class="ratings">
                                        <div class="rating">

                                            <i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>

                                        </div>
                                        <p class="availability in-stock pull-right"> Available Stock : <span>12   In Stock </span></p>
                                    </div>
                                    <div class="short-description">
                                        <h2> Quick Overview </h2>

                                        <p></p>
                                        <p>This product is made by china.
                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAtCAYAAAAHpEG5AAALF0lEQVR4nO2dT2wjVx3HP17RrdQtxQsIqSquJqV4XQFdV9ATEp1wg0P+4Fy4dON7xMa55LbW7C2XeLfyPU4vXBz&lt;/p&gt;                     &lt;/div&gt;                                          &lt;div class=" product-color-size-area "=" ">

                        </p><div class="size-area ">
                           <h2 class="saider-bar-title "> Size </h2>
                           <div class="size ">
                              <select name="addtocart_size " id="addtocart_size_offer_97 " required=" ">
                                 <option value=" ">-- Select Size --</option>

                                 <option value="11 ">
                                    No Size
                                 </option>
                                                               </select>
                           </div>
                        </div>
                                                                     </div>
                     <div class="product-variation ">
                        <form method="POST " action="https://dinratri.aapbd.com/addtocart " accept-charset="UTF-8 " class="submit_form_offer " enctype="multipart/form-data "><input name="_token " type="hidden " value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs ">

                        <div class="cart-plus-minus ">
                           <label for="qty "> Quantity  :</label>
                           <div class="numbers-row ">
                              <div onclick="remove_quantity_offer(97) " class="dec qtybutton "><i class="fa fa-minus ">&nbsp;</i></div>
                              <input type="number " class="qty " min="1 " value="1 " max="12 " id="addtocart_qty_offer_97 " name="addtocart_qty " readonly=" " required=" ">
                              <div onclick="add_quantity_offer(97) " class="inc qtybutton "><i class="fa fa-plus ">&nbsp;</i></div>
                           </div>
                        </div>

                        <input type="hidden " name="_token " value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs ">
                        <input name="addtocart_type " type="hidden " value="product ">
                        <input name="addtocart_pro_id " type="hidden " value="97 ">

                                                <a href="https://dinratri.aapbd.com/ " role="button " data-toggle="modal " data-target="#loginpop ">
                        <button type="button " class=" button pro-add-to-cart ">
                        <span><i class="fa fa-shopping-basket " aria-hidden="true "></i> 
                         Add to cart </span>
                        </button> 
                        </a>

                                                </form>
                     </div>
                     <div class="product-cart-option ">
                        <ul>
                           <li>

                              <a href="https://dinratri.aapbd.com/ " role="button " data-toggle="modal " data-target="#loginpop ">
                              <i class="fa fa-heart-o " aria-hidden="true "></i>  Add to Wishlist                               </a>
                                                                                       </li>

                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <!--product-view--> 
         </div>
      </div>
      <a style="display: inline; " id="quick_view_popup-close " href="https://dinratri.aapbd.com/index "><i class="icon pe-7s-close "></i></a> 
   </div>
</div>

<input type="hidden " id="pro_qty_hidden_offer_94 " name="pro_qty_hidden_offer " value="100 ">
<input type="hidden " id="pro_purchase_hidden_offer_94 " name="pro_purchase_hidden_offer " value="1 ">
<div style="display:none; " class="quick_view_popup-wrap " id="quick_view_popup-wrap_offer94 ">
   <div id="quick_view_popup-overlay "></div>
   <div id="quick_view_popup-outer ">
      <div id="quick_view_popup-content ">
         <div style="width:auto;height:auto;overflow: auto;position:relative; ">
            <div class="product-view-area ">
               <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5 ">
                  <div class="large-image "> 
                     <a href="./files/Product_15527560531491433287.jpg " class="cloud-zoom " id="zoom1 " rel="useWrapper: false, adjustY:0, adjustX:20 "> <img class=" " src="./files/Product_15527560531491433287.jpg "> </a> 
                  </div>
                  <div class="flexslider flexslider-thumb ">
                     <ul class="previews-list slides ">
                                                                         <!-- //product image is not null and exists in folder -->

                                                <li style="width: 100px; float: left; display: block; "><a href="./files/Product_15527560531491433287.jpg " class="cloud-zoom-gallery " rel="useZoom: &#39;zoom1&#39;, smallImage: &#39;https://dinratri.aapbd.com/public/assets/product/Product_15527560531491433287.jpg&#39; "><img src="./files/Product_15527560531491433287.jpg " alt="Thumbnail 2 "></a></li>
                                             </ul>
                  </div>
                  <!-- end: more-images --> 
               </div>
               <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7 ">
                  <div class="product-details-area ">
                     <div class="product-name ">
                        <h1>Test product By Biplob

                        </h1>
                     </div>
                     <div class="price-box ">
                        <p class="special-price "> <span class="price-label "></span> <span class="price ">BDT 90.00 </span> </p>
                        <p class="old-price "> <span class="price-label "></span> <span class="price "> BDT 100.00 </span> </p>
                     </div>
                     <div class="ratings ">
                                                <div class="rating "> 

                                                                                 <i class="fa fa-star-o "></i><i class="fa fa-star-o "></i><i class="fa fa-star-o "></i><i class="fa fa-star-o "></i><i class="fa fa-star-o "></i>

                        </div>
                        <p class="availability in-stock pull-right ">  Available Stock : <span>99   In Stock </span></p>
                     </div>
                     <div class="short-description ">
                        <h2> Quick Overview </h2>

                                                                        <p></p><p><br>Test product, don't buy it<br>Test product, don't buy it<br>Test product, don't buy it<br>Test product, don't buy it<br>Test product, don't buy it<br>Test product, don't buy it<br>Test product,</p>
                     </div>
                                          <div class="product-color-size-area ">

                        <div class="size-area ">
                           <h2 class="saider-bar-title "> Size </h2>
                           <div class="size ">
                              <select name="addtocart_size " id="addtocart_size_offer_94 " required=" ">
                                 <option value=" ">-- Select Size --</option>

                                 <option value="11 ">
                                    No Size
                                 </option>
                                                               </select>
                           </div>
                        </div>
                                                                     </div>
                     <div class="product-variation ">
                        <form method="POST " action="https://dinratri.aapbd.com/addtocart " accept-charset="UTF-8 " class="submit_form_offer " enctype="multipart/form-data "><input name="_token " type="hidden " value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs ">

                        <div class="cart-plus-minus ">
                           <label for="qty "> Quantity  :</label>
                           <div class="numbers-row ">
                              <div onclick="remove_quantity_offer(94) " class="dec qtybutton "><i class="fa fa-minus ">&nbsp;</i></div>
                              <input type="number " class="qty " min="1 " value="1 " max="99 " id="addtocart_qty_offer_94 " name="addtocart_qty " readonly=" " required=" ">
                              <div onclick="add_quantity_offer(94) " class="inc qtybutton "><i class="fa fa-plus ">&nbsp;</i></div>
                           </div>
                        </div>

                        <input type="hidden " name="_token " value="9Y2gCLVyVKKgqY9o4j3uKA11Lia1W6n376QuaoUs ">
                        <input name="addtocart_type " type="hidden " value="product ">
                        <input name="addtocart_pro_id " type="hidden " value="94 ">

                                                <a href="https://dinratri.aapbd.com/ " role="button " data-toggle="modal " data-target="#loginpop ">
                        <button type="button " class=" button pro-add-to-cart ">
                        <span><i class="fa fa-shopping-basket " aria-hidden="true "></i> 
                         Add to cart </span>
                        </button> 
                        </a>

                                                </form>
                     </div>
                     <div class="product-cart-option ">
                        <ul>
                           <li>

                              <a href="https://dinratri.aapbd.com/ " role="button " data-toggle="modal " data-target="#loginpop ">
                              <i class="fa fa-heart-o " aria-hidden="true "></i>  Add to Wishlist                               </a>
                                                                                       </li>

                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <!--product-view--> 
         </div>
      </div>
      <a style="display: inline; " id="quick_view_popup-close " href="https://dinratri.aapbd.com/index "><i class="icon pe-7s-close "></i></a> 
   </div>
</div>

<!--quick view best rated 50% offer--> 
<!--end quick view best rated 50% offer--> 

<a href="https://dinratri.aapbd.com/# " id="back-to-top " title="Back to top " class=" "><i class="fa fa-angle-up "></i></a> 
<!-- End Footer --> 
</div>
<!-- JS --> 
<script type="text/javascript ">
   jQuery(document).ready(function(){
       jQuery('#rev_slider_4').show().revolution({
           dottedOverlay: 'none',
           delay: 5000,
           startwidth: 865,
        startheight: 450,

           hideThumbs: 200,
           thumbWidth: 200,
           thumbHeight: 50,
           thumbAmount: 2,

           navigationType: 'thumb',
           navigationArrows: 'solo',
           navigationStyle: 'round',

           touchenabled: 'on',
           onHoverStop: 'on',

           swipe_velocity: 0.7,
           swipe_min_touches: 1,
           swipe_max_touches: 1,
           drag_block_vertical: false,

           spinner: 'spinner0',
           keyboardNavigation: 'off',

           navigationHAlign: 'center',
           navigationVAlign: 'bottom',
           navigationHOffset: 0,
           navigationVOffset: 20,

           soloArrowLeftHalign: 'left',
           soloArrowLeftValign: 'center',
           soloArrowLeftHOffset: 20,
           soloArrowLeftVOffset: 0,

           soloArrowRightHalign: 'right',
           soloArrowRightValign: 'center',
           soloArrowRightHOffset: 20,
           soloArrowRightVOffset: 0,

           shadow: 0,
           fullWidth: 'on',
           fullScreen: 'off',

           stopLoop: 'off',
           stopAfterLoops: -1,
           stopAtSlide: -1,

           shuffle: 'off',

           autoHeight: 'off',
           forceFullWidth: 'on',
           fullScreenAlignForce: 'off',
           minFullScreenHeight: 0,
           hideNavDelayOnMobile: 1500,

           hideThumbsOnMobile: 'off',
           hideBulletsOnMobile: 'off',
           hideArrowsOnMobile: 'off',
           hideThumbsUnderResolution: 0,

           hideSliderAtLimit: 0,
           hideCaptionAtLimit: 0,
           hideAllCaptionAtLilmit: 0,
           startWithSlide: 0,
           fullScreenOffsetContainer: ''
       });
   });
</script>
<script type="text/javascript ">
   $('#subscribe_submit').click(function(){  
     var email=$('#sub_email').val(); 
     if(email=='') {
       alert('Enter an email id');
       return false;
     }
   $('.mail-loader').css('display','block');
      $.ajax( { 
               type: 'get',
               data: {email},
               url: 'https://dinratri.aapbd.com/subscription_submit',
               success: function(responseText){  

                if(responseText=='0')
                { 
                        alert("Email already subscribed! ");
                           $('.mail-loader').css('display','none');
                } else{
                 // Need loader
               $('.mail-loader').css('display','none');
                 alert("Email subscribed Successfully! ");
                }
             }       
         });  

   });

</script>
<script type="text/javascript ">
   function addtowish(pro_id,cus_id){

     var wishlisturl = document.getElementById('wishlisturl').value;

     $.ajax({
           type: "get ",   
           url:"https://dinratri.aapbd.com/addtowish ",
           data:{'pro_id':pro_id,'cus_id':cus_id},
           success:function(response){
            // alert(response);
             if(response==0){

                                      $(".add-to-wishlist ").fadeIn('slow').delay(5000).fadeOut('slow');
               //window.location=wishlisturl;
                             window.location.reload();

             }else{
               alert('Product Already exists in Your Wishlist');
               //window.location=wishlisturl;
             }

           }
         });
   }
</script>
<script type="text/javascript ">
   jQuery(document).ready(function($) {
     var Body = $('body');
     Body.addClass('preloader-site');
   });
   $(window).load(function(){
     $('.preloader-wrapper').fadeOut();
     $('body').removeClass('preloader-site');
   });
</script>
<script>
   function add_quantity(id)
   {
     /*var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;*/
     var quantity=$("#addtocart_qty_ "+id).val(); 
     var pro_qty_hidden=$("#pro_qty_hidden_ "+id).val();
     var pro_purchase_hidden=$("#pro_purchase_hidden_ "+id).val();
     var remaining_product=parseInt(pro_qty_hidden - pro_purchase_hidden);

     if(quantity<remaining_product)
     { 
       var new_quantity=parseInt(quantity)+1;
       $("#addtocart_qty_ "+id).val(new_quantity);
     }
     //alert();
   }

   function remove_quantity(id)
   {
     //alert();
     /*var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) result.value--;return false;*/

     var quantity=$("#addtocart_qty_ "+id).val();
     var quantity=parseInt(quantity);
     if(quantity>1)
     {
       var new_quantity=quantity-1;
       $("#addtocart_qty_ "+id).val(new_quantity);
     }
     //alert();
   }

   function add_quantity_offer(id)
   {
     /*var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;*/
     var quantity=$("#addtocart_qty_offer_ "+id).val(); 
     var pro_qty_hidden=$("#pro_qty_hidden_offer_ "+id).val();
     var pro_purchase_hidden=$("#pro_purchase_hidden_offer_ "+id).val();
     var remaining_product=parseInt(pro_qty_hidden - pro_purchase_hidden);

     if(quantity<remaining_product)
     { 
       var new_quantity=parseInt(quantity)+1;
       $("#addtocart_qty_offer_ "+id).val(new_quantity);
     }
     //alert();
   }

   function remove_quantity_offer(id)
   {
     //alert();
     /*var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) result.value--;return false;*/

     var quantity=$("#addtocart_qty_offer_ "+id).val();
     var quantity=parseInt(quantity);
     if(quantity>1)
     {
       var new_quantity=quantity-1;
       $("#addtocart_qty_offer_ "+id).val(new_quantity);
     }
     //alert();
   }
</script>
<script type="text/javascript ">
   function addtowish(pro_id,cus_id){
     //alert();
     var wishlisturl = document.getElementById('wishlisturl').value;

     $.ajax({
           type: "get ",   
           url:"https://dinratri.aapbd.com/addtowish ",
           data:{'pro_id':pro_id,'cus_id':cus_id},
             success:function(response){
             //alert(response); return false;
             if(response==0){
                                      $(".add-to-wishlist ").fadeIn('slow').delay(5000).fadeOut('slow');
               //window.location=wishlisturl;
                             window.location.reload();

             }else{
               alert('Product Already exists in Your Wishlist');
               //window.location=wishlisturl;
             }

           }
         });
   }
</script>
<script type="text/javascript ">
   function addtocart_validate_offer(id){

   var pro_qty=$("#pro_qty_hidden_offer_ "+id).val();
   var pro_purchase1=$("#pro_purchase_hidden_offer_ "+id).val();
   var pro_purchase = parseInt($('#addtocart_qty_offer_').val()) + parseInt(pro_purchase1);
   var error = 0;
   if(pro_purchase > parseInt(pro_qty))
   {
     $('#addtocart_qty_offer_'+id).focus();
     $('#addtocart_qty_offer_'+id).css('border-color', 'red');
     $('#addtocart_qty_error_offer_'+id).html('Limited Quantity Available');
   error++;
     return false;
   }
   else
   {
     $('#addtocart_qty_offer_'+id).css('border-color', '');
     $('#addtocart_qty_error_offer_'+id).html('');
   }
   if($('#addtocart_color_offer_'+id).val() ==0) 
   {
     $('#addtocart_color_offer_'+id).focus();
     $('#addtocart_color_offer_'+id).css('border-color', 'red');
     $('#size_color_error_offer_'+id).html('Select Color');
     error++;
   return false;
   }
   else
   {
     $('#addtocart_color_offer_'+id).css('border-color', '');
     $('#size_color_error_offer_'+id).html('');
   }
   if($('#addtocart_size_offer_'+id).val() ==0)
   {
     $('#addtocart_size_offer_'+id).focus();
     $('#addtocart_size_offer_'+id).css('border-color', 'red');
     $('#size_color_error_offer_'+id).html('Select Size');
     error++;
   return false;
   }
   else
   {
     $('#addtocart_size_offer_'+id).css('border-color', '');
     $('#size_color_error_offer_'+id).html('');
   }

   if(error <= 0){
    $(".submit_form_offer ").submit(); 
   }

   }  
</script>   
<script type="text/javascript ">
   function addtocart_validate(id){

   var pro_qty=$("#pro_qty_hidden_ "+id).val();
   var pro_purchase1=$("#pro_purchase_hidden_ "+id).val();
   var pro_purchase = parseInt($('#addtocart_qty_offer_').val()) + parseInt(pro_purchase1);
   var error1 = 0;
    if(pro_purchase > parseInt(pro_qty))
   {
     $('#addtocart_qty_'+id).focus();
     $('#addtocart_qty_'+id).css('border-color', 'red');
     $('#addtocart_qty_error_'+id).html('Limited Quantity Available');
     return false;
   }
   else
   {
     $('#addtocart_qty_'+id).css('border-color', '');
     $('#addtocart_qty_error_'+id).html('');
   }
   if($('#addtocart_color_'+id).val() ==0) 
   {
     $('#addtocart_color_'+id).focus();
     $('#addtocart_color_'+id).css('border-color', 'red');
     $('#size_color_error_'+id).html('Select Color');
     return false;
   }
   else
   {
     $('#addtocart_color_'+id).css('border-color', '');
     $('#size_color_error_'+id).html('');
   }
   if($('#addtocart_size_'+id).val() ==0)
   {
     $('#addtocart_size_'+id).focus();
     $('#addtocart_size_'+id).css('border-color', 'red');
     $('#size_color_error_'+id).html('Select Size');
     return false;
   }
   else
   {
     $('#addtocart_size_'+id).css('border-color', '');
     $('#size_color_error_'+id).html('');
   }

   if(error1 <= 0){
    $(".submit_form ").submit(); 
   }

   }  
</script>

<div id="fb-root " class=" fb_reset "><div style="position: absolute; top: -10000px; width: 0px; height: 0px; "><div><iframe name="fb_xdm_frame_https " frameborder="0 " allowtransparency="true " allowfullscreen="true " scrolling="no " allow="encrypted-media " id="fb_xdm_frame_https " aria-hidden="true " title="Facebook Cross Domain Communication Frame " tabindex="-1 " src="./files/d_vbiawPdxB.html " style="border: none; "></iframe></div><div></div></div></div></body></html>