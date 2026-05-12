<!--MAIN NAVIGATION-->
<!--===================================================-->
<nav id="mainnav-container">
    <div id="mainnav">

        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">

                    <!--Profile Widget-->
                    <!--================================-->
                    {{-- <div id="mainnav-profile" class="mainnav-profile">
                        <div class="profile-wrap text-center">
                            <div class="pad-btm">
                                <img class="img-circle img-md" src="{{ asset('images/'.Auth::user()->avatar_original) }}" alt="Profile Picture">
                            </div>
                            <a href="#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
                                <span class="pull-right dropdown-toggle">
                                    <i class="dropdown-caret"></i>
                                </span>
                                <p class="mnp-name">{{Auth::user()->name}}</p>
                                <span class="mnp-desc">{{Auth::user()->email}}</span>
                            </a>
                        </div>
                        <div id="profile-nav" class="collapse list-group bg-trans">
                            <a href="#" class="list-group-item">
                                <i class="demo-pli-male icon-lg icon-fw"></i> View Profile
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="demo-pli-gear icon-lg icon-fw"></i> Settings
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="demo-pli-information icon-lg icon-fw"></i> Help
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="demo-pli-unlock icon-lg icon-fw"></i> Logout
                            </a>
                        </div>
                    </div> --}}


                    <!--Shortcut buttons-->
                    <!--================================-->
                    <div id="mainnav-shortcut" class="hidden">
                        <ul class="list-unstyled shortcut-wrap">
                            <li class="col-xs-3" data-content="My Profile">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                                    <i class="demo-pli-male"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Messages">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                                    <i class="demo-pli-speech-bubble-3"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Activity">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-success">
                                    <i class="demo-pli-thunder"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Lock Screen">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-purple">
                                    <i class="demo-pli-lock-2"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--================================-->
                    <!--End shortcut buttons-->


                    <ul id="mainnav-menu" class="list-group">

                        <!--Category name-->
                        {{-- <li class="list-header">Navigation</li> --}}

                        <!--Menu list item-->
                        <li class="{{ areActiveRoutes(['admin.dashboard'])}}">
                            <a class="nav-link" href="{{route('admin.dashboard')}}">
                                <i class="fa fa-dashboard"></i>
                                <span class="menu-title">{{__('Dashboard')}}</span>
                            </a>
                        </li>

                        <!-- Product Menu -->
                        @if(Auth::user()->user_type == 'admin' || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
                            <li>
                                <a href="#">
                                    <i class="fa fa-puzzle-piece"></i>
                                    <span class="menu-title">{{__('Catalog Manage')}}</span>
                                    <i class="arrow"></i>
                                </a>

                                <!--Submenu-->
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['brands.index', 'brands.create', 'brands.edit'])}}">
                                        <a class="nav-link" href="{{route('brands.index')}}">{{__('Brand')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['feature-brands.index', 'feature-brands.create', 'feature-brands.edit'])}}">
                                        <a class="nav-link" href="{{route('feature-brands.index')}}">{{__('Feature Brand')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['categories.index', 'categories.create', 'categories.edit'])}}">
                                        <a class="nav-link" href="{{route('categories.index')}}">{{__('Category')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['subcategories.index', 'subcategories.create', 'subcategories.edit'])}}">
                                        <a class="nav-link" href="{{route('subcategories.index')}}">{{__('Subcategory')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['subsubcategories.index', 'subsubcategories.create', 'subsubcategories.edit'])}}">
                                        <a class="nav-link" href="{{route('subsubcategories.index')}}">{{__('Sub Subcategory')}}</a>
                                    </li>

                                </ul>
                            </li>


                            <li>
                                <a href="#">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="menu-title">{{__('Products Manage')}}</span>
                                    <i class="arrow"></i>
                                </a>

                                <!--Submenu-->
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['products.create', 'products.admin.edit'])}}">
                                        <a class="nav-link" href="{{route('products.create')}}">{{__('Add New')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['products.admin'])}}">
                                        <a class="nav-link" href="{{route('products.admin')}}">{{__('Published Products')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['products.admin.pending'])}}">
                                        <a class="nav-link" href="{{route('products.admin.pending')}}">{{__('Pending Products')}}</a>
                                    </li>
                                    @if(\App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                                        <li class="{{ areActiveRoutes(['products.seller', 'products.seller.edit'])}}">
                                            <a class="nav-link" href="{{route('products.seller')}}">{{__('Seller Products')}}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        {{-- flash deal  --}}
                        @if(Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="{{ areActiveRoutes(['flash_deals.index', 'flash_deals.create', 'flash_deals.edit'])}}">
                            <a class="nav-link" href="{{ route('flash_deals.index') }}">
                                <i class="fa fa-bolt"></i>
                                <span class="menu-title">{{__('Flash Deal')}}</span>
                            </a>
                        </li>
                        @endif

                        {{-- flash deal end --}}
                        @if(Auth::user()->user_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
                            @php
                                $orders = DB::table('orders')
                                            // ->orderBy('code', 'desc')
                                            // ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                                            // //->where('order_details.seller_id', Auth::user()->id)
                                            // ->where('orders.meduserorder', 0)
                                            // ->where('orders.viewed', 0)
                                            ->where('delivery_status', 'pending')
                                            // ->select('orders.id')
                                            // ->distinct()
                                            ->count();
                                            $processingOrder =DB::table('orders')
                                            // ->orderBy('code', 'desc')
                                            // ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                                            // //->where('order_details.seller_id', Auth::user()->id)
                                            ->where('delivery_status', 'processing')
                                            // ->select('orders.id')
                                            // ->distinct()
                                            ->count();

                                            $deliveredOrder =DB::table('orders')
                                            ->where('delivery_status', 'delivered')
                                            ->count();

                                            $on_deliveryOrder =DB::table('orders')
                                            ->where('delivery_status', 'on_delivery')
                                            ->count();
                                            $complainOrder =DB::table('orders')
                                            ->where('delivery_status', 'return')
                                            ->count();
                                             $rejectedOrder =DB::table('orders')
                                            ->where('delivery_status', 'rejected')
                                            ->count();
                                            $allOrder =DB::table('orders')
                                            ->count();
                            @endphp
                        <li class="{{ areActiveRoutes(['orders.index.admin','orders.pending', 'orders.processing', 'orders.on_delivery', 'orders.delivered', 'orders.rejected', 'orders.show'])}}">
                            <a class="nav-link" href="#">
                                <i class="fa fa-shopping-basket"></i>
                                <span class="menu-title">{{__('Orders')}}  <i class="arrow"></i>
                            </a>
                             <!--Submenu-->
                             <ul class="collapse">
                                  <li class="{{ areActiveRoutes(['orders.show', 'custom-orders.index.admin'])}}">
                                    <a class="nav-link" href="{{ route('custom-orders.index.admin') }}">{{__('Create Order')}}</a>

                                </li>
                                <li class="{{ areActiveRoutes(['orders.pending', 'orders.show'])}}">
                                    <a class="nav-link" href="{{ route('orders.pending') }}">{{__('Pending Orders')}}<span class="pull-right badge badge-success">{{ $orders }}</span></a>

                                </li>
                                <li class="{{ areActiveRoutes(['orders.processing', 'orders.show'])}}">
                                    <a class="nav-link" href="{{ route('orders.processing') }}">{{__('Processing Orders')}}
                                        <span class="pull-right badge badge-info">{{ $processingOrder }}</span>
                                    </a>
                                </li>
                                <li class="{{ areActiveRoutes(['orders.complain', 'orders.show'])}}">
                                    <a class="nav-link" href="{{ route('orders.complain') }}">{{__('Return Orders')}}
                                        <span class="pull-right badge badge-warning">{{ $complainOrder }}</span>
                                    </a>
                                </li>
                                <li class="{{ areActiveRoutes(['orders.on_delivery', 'orders.show'])}}">
                                    <a class="nav-link" href="{{ route('orders.on_delivery') }}">{{__('On Delivery Orders')}}
                                        <span class="pull-right badge badge-info">{{ $on_deliveryOrder }}</span>
                                    </a>
                                </li>
                                <li class="{{ areActiveRoutes(['orders.delivered', 'orders.show'])}}">
                                    <a class="nav-link" href="{{ route('orders.delivered') }}">{{__('Delivered Orders')}}
                                        <span class="pull-right badge badge-info">{{ $deliveredOrder }}</span>
                                    </a>
                                </li>
                                <li class="{{ areActiveRoutes(['orders.rejected', 'orders.show'])}}">
                                    <a class="nav-link" href="{{ route('orders.rejected') }}">{{__('Rejected Orders')}}
                                        <span class="pull-right badge badge-danger">{{ $rejectedOrder }}</span>
                                    </a>
                                </li>
                                <li class="{{ areActiveRoutes(['orders.index.admin', 'orders.show'])}}">
                                    <a class="nav-link" href="{{ route('orders.index.admin') }}">{{__('All Order')}}
                                        <span class="pull-right badge badge-info">{{ $allOrder }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif


                        {{-- new medication order end --}}

                        @if(Auth::user()->user_type == 'admin' || in_array('5', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="{{ areActiveRoutes(['order-tracking.index'])}}">
                            <a class="nav-link" href="{{ route('order-tracking.index') }}">
                                <i class="fa fa-map-marker"></i>
                                <span class="menu-title">{{__('Order Tracking')}}</span>
                            </a>
                        </li>
                        @endif


                        @if(Auth::user()->user_type == 'admin' || in_array('6', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="{{ areActiveRoutes(['sales.index', 'sales.show'])}}">
                            <a class="nav-link" href="{{ route('sales.index') }}">
                                <i class="fa fa-money"></i>
                                <span class="menu-title">{{__('Total sales')}}</span>
                            </a>
                        </li>
                        @endif



                        @if(Auth::user()->user_type == 'admin' || in_array('7', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="{{ areActiveRoutes(['customers.index','madication.newuserorder'])}}">
                            <a href="{{ route('customers.index') }}">
                                <i class="fa fa-group"></i>
                                <span class="menu-title">{{__('Customers')}}</span>
                            </a>
                        </li>

                        @endif


                        {{--user message start --}}
                        @if(Auth::user()->user_type == 'admin' || in_array('10', json_decode(Auth::user()->staff->role->permissions)))
                            @php
                                $unread = DB::table('messages')
                                            ->orderBy('id', 'desc')
                                            ->where('read', 0)
                                            ->select('id')
                                            ->distinct()
                                            ->count();

                            @endphp
                        <li class="{{ areActiveRoutes(['admin.message.index'])}}">
                            <a class="nav-link" href="{{ route('admin.message.index') }}">
                                <i class="fa fa-comments-o"></i>
                                <span class="menu-title">{{__('Message')}} @if($unread > 0)<span class="pull-right badge badge-info">{{ $unread }}</span>@endif</span>
                            </a>
                        </li>
                        @endif


                        @if(Auth::user()->user_type == 'admin' || in_array('12', json_decode(Auth::user()->staff->role->permissions)))
                        <li>
                            <a href="#">
                                <i class="fa fa-newspaper-o"></i>
                                <span class="menu-title">{{__('Reports')}}</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="{{ areActiveRoutes(['stock_report.index'])}}">
                                    <a class="nav-link" href="{{ route('stock_report.index') }}">{{__('Stock Report')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['in_house_sale_report.index'])}}">
                                    <a class="nav-link" href="{{ route('in_house_sale_report.index') }}">{{__('Sale Report')}}</a>
                                </li>
                                @if(\App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)

                                    <li class="{{ areActiveRoutes(['seller_report.index'])}}">
                                        <a class="nav-link" href="{{ route('seller_report.index') }}">{{__('Seller Report')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['seller_sale_report.index'])}}">
                                        <a class="nav-link" href="{{ route('seller_sale_report.index') }}">{{__('Seller Based Selling Report')}}</a>
                                    </li>
                                @endif
                                <li class="{{ areActiveRoutes(['wish_report.index'])}}">
                                    <a class="nav-link" href="{{ route('wish_report.index') }}">{{__('Product Wish Report')}}</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        {{-- blog start  --}}

                        @if(Auth::user()->user_type == 'admin' || in_array('13', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="{{ areActiveRoutes(['admin-cblog-index','admin-blog-index','admin-blog-comment'])}}">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span class="menu-title">{{__('Blog')}}</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="{{ areActiveRoutes(['admin-cblog-index'])}}">
                                    <a class="nav-link" href="{{ route('admin-cblog-index') }}">{{__('Category')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['admin-blog-index'])}}">
                                    <a class="nav-link" href="{{ route('admin-blog-index') }}">{{__('Post')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['admin-blog-comment'])}}">
                                    <a class="nav-link" href="{{ route('admin-blog-comment') }}">{{__('Comments')}}</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        {{-- blog end  --}}


                        {{-- email templete setup  --}}
                        @if(Auth::user()->user_type == 'admin' || in_array('14', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="{{ areActiveRoutes(['emailtemplete.index'])}}">
                            <a class="nav-link" href="{{ route('emailtemplete.index') }}">
                                <i class="fa fa-envelope-o"></i>
                                <span class="menu-title">{{__('Email Templete')}}</span>
                            </a>
                        </li>
                        @endif


                        @if(Auth::user()->user_type == 'admin' || in_array('15', json_decode(Auth::user()->staff->role->permissions)))
                        <li>
                            <a href="#">
                                <i class="fa fa-gears"></i>
                                <span class="menu-title">{{__('Business Settings')}}</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="{{ areActiveRoutes(['activation.index'])}}">
                                    <a class="nav-link" href="{{route('activation.index')}}">{{__('Activation')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['payment_method.index'])}}">
                                    <a class="nav-link" href="{{ route('payment_method.index') }}">{{__('Payment method')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['smtp_settings.index'])}}">
                                    <a class="nav-link" href="{{ route('smtp_settings.index') }}">{{__('SMTP Settings')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['google_analytics.index'])}}">
                                    <a class="nav-link" href="{{ route('google_analytics.index') }}">{{__('Google Analytics')}}</a>
                                </li>
                                {{-- <li class="{{ areActiveRoutes(['facebook_chat.index'])}}">
                                    <a class="nav-link" href="{{ route('facebook_chat.index') }}">{{__('Facebook Chat')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['social_login.index'])}}">
                                    <a class="nav-link" href="{{ route('social_login.index') }}">{{__('Social Media Login')}}</a>
                                </li> --}}
                                <li class="{{ areActiveRoutes(['currency.index'])}}">
                                    <a class="nav-link" href="{{route('currency.index')}}">{{__('Currency')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['languages.index', 'languages.create', 'languages.store', 'languages.show', 'languages.edit'])}}">
                                    <a class="nav-link" href="{{route('languages.index')}}">{{__('Languages')}}</a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->user_type == 'admin' || in_array('16', json_decode(Auth::user()->staff->role->permissions)))
                        <li>
                            <a href="#">
                                <i class="fa fa-desktop"></i>
                                <span class="menu-title">{{__('Frontend Settings')}}</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="{{ areActiveRoutes(['home_settings.index', 'home_banners.index', 'sliders.index', 'home_categories.index', 'home_banners.create', 'home_categories.create', 'home_categories.edit', 'sliders.create'])}}">
                                    <a class="nav-link" href="{{route('home_settings.index')}}">{{__('Home')}}</a>
                                </li>
                                {{-- <li class="{{ areActiveRoutes(['security.index'])}}">
                                    <a class="nav-link" href="{{route('security.index','security')}}">{{__('Security')}}</a>
                                </li> --}}
                                <li class="{{ areActiveRoutes(['special-offer.index'])}}">
                                    <a class="nav-link" href="{{route('special-offer.index')}}">{{__('Special Offer')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['shippingmethod.index'])}}">
                                    <a class="nav-link" href="{{route('shippingmethod.index')}}">{{__('Guest Shipping Method')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['shippingaddress.index'])}}">
                                    <a class="nav-link" href="{{route('shippingaddress.index')}}">{{__('Shipping Mathod')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['aboutus.index'])}}">
                                    <a class="nav-link" href="{{route('aboutus.index','about')}}">{{__('About Us')}}</a>
                                </li>
                                {{-- <li class="{{ areActiveRoutes(['stories.index'])}}">
                                    <a class="nav-link" href="{{route('stories.index','dinratri-stories')}}">{{__('Shundorjo Stories')}}</a>
                                </li> --}}

                                {{-- <li class="{{ areActiveRoutes(['payments.index2'])}}">
                                    <a class="nav-link" href="{{route('payments.index2','payments')}}">{{__('Payments')}}</a>
                                </li> --}}
                                {{-- <li class="{{ areActiveRoutes(['shipping.index'])}}">
                                    <a class="nav-link" href="{{route('shipping.index','shipping')}}">{{__('Shipping')}}</a>
                                </li> --}}
                                {{-- <li class="{{ areActiveRoutes(['cancellation.index'])}}">
                                    <a class="nav-link" href="{{route('cancellation.index','cancellation-return')}}">{{__('Cancellation & Return')}}</a>
                                </li> --}}
                                <li class="{{ areActiveRoutes(['faq.index'])}}">
                                    <a class="nav-link" href="{{route('faq.index','faq')}}">{{__('Faq')}}</a>
                                </li>
                                {{-- <li class="{{ areActiveRoutes(['career.index'])}}">
                                    <a class="nav-link" href="{{route('career.index','career')}}">{{__('Career')}}</a>
                                </li> --}}


                                <li>
                                    <a href="#">
                                        <span class="menu-title">{{__('Policy Pages')}}</span>
                                        <i class="arrow"></i>
                                    </a>

                                    <!--Submenu-->
                                    <ul class="collapse">


                                        <li class="{{ areActiveRoutes(['terms.index'])}}">
                                            <a class="nav-link" href="{{route('terms.index', 'terms')}}">{{__('Terms & Conditions')}}</a>
                                        </li>
                                        <li class="{{ areActiveRoutes(['privacypolicy.index'])}}">
                                            <a class="nav-link" href="{{route('privacypolicy.index', 'privacy_policy')}}">{{__('Privacy Policy')}}</a>
                                        </li>
                                        <li class="{{ areActiveRoutes(['stories.index'])}}">
                                            <a class="nav-link" href="{{route('stories.index', 'dinratri-stories')}}">{{__('Stories')}}</a>
                                        </li>
                                        <li class="{{ areActiveRoutes(['payments.index2'])}}">
                                            <a class="nav-link" href="{{route('payments.index2', 'payments')}}">{{__('Payment Policy')}}</a>
                                        </li>
                                        <li class="{{ areActiveRoutes(['shipping.index'])}}">
                                            <a class="nav-link" href="{{route('shipping.index', 'shipping')}}">{{__('Shipping Policy')}}</a>
                                        </li>
                                        <li class="{{ areActiveRoutes(['cancellation.index'])}}">
                                            <a class="nav-link" href="{{route('cancellation.index', 'cancellation')}}">{{__('Cancellation Policy')}}</a>
                                        </li>
                                        <li class="{{ areActiveRoutes(['supportpolicy.index'])}}">
                                            <a class="nav-link" href="{{route('supportpolicy.index', 'support_policy')}}">{{__('Support Policy')}}</a>
                                        </li>
                                         <li class="{{ areActiveRoutes(['returnpolicy.index'])}}">
                                            <a class="nav-link" href="{{route('returnpolicy.index', 'return_policy')}}">{{__('Return Policy')}}</a>
                                        </li>
                                        <li class="{{ areActiveRoutes(['sellerpolicy.index'])}}">
                                            <a class="nav-link" href="{{route('sellerpolicy.index', 'seller_policy')}}">{{__('Saller Policy')}}</a>
                                        </li>
                                    </ul>

                                </li>


                                <li class="{{ areActiveRoutes(['generalsettings.index'])}}">
                                    <a class="nav-link" href="{{route('generalsettings.index')}}">{{__('General Settings')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['generalsettings.logo'])}}">
                                    <a class="nav-link" href="{{route('generalsettings.logo')}}">{{__('Logo Settings')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['generalsettings.color'])}}">
                                    <a class="nav-link" href="{{route('generalsettings.color')}}">{{__('Color Settings')}}</a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->user_type == 'admin' || in_array('17', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="{{ areActiveRoutes(['seosetting.index'])}}">
                            <a class="nav-link" href="{{ route('seosetting.index') }}">
                                <i class="fa fa-search"></i>
                                <span class="menu-title">{{__('SEO Setting')}}</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->user_type == 'admin' || in_array('19', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="{{ areActiveRoutes(['sitemap.index'])}}">
                            <a class="nav-link" href="{{ route('sitemap.index') }}">
                                <i class="fa fa-sitemap"></i>
                                <span class="menu-title">{{__('SiteMap')}}</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->user_type == 'admin' || in_array('18', json_decode(Auth::user()->staff->role->permissions)))
                        <li>
                            <a href="#">
                                <i class="fa fa-address-card"></i>
                                <span class="menu-title">{{__('Staffs')}}</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="{{ areActiveRoutes(['user.admin'])}}">
                                    <a class="nav-link" href="{{ route('user.admin') }}">{{__('All Admin')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])}}">
                                    <a class="nav-link" href="{{ route('staffs.index') }}">{{__('All staffs')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])}}">
                                    <a class="nav-link" href="{{route('roles.index')}}">{{__('Staff permissions')}}</a>
                                </li>
                            </ul>
                        </li>
                        @endif





                    </ul>
                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>
