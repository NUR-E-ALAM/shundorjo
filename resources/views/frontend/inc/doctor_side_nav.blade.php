<div class="sidebar sidebar--style-3 no-border stickyfill p-0">
    <div class="widget mb-0">
        <div class="widget-profile-box text-center p-3">
            {{-- <div class="image" style="background-image:url('{{ Auth::user()->avatar_original }}')"></div> --}}
            @if(!empty(Auth::user()->avatar_original))
            <img src="{{asset(Auth::user()->avatar_original)}}" class="image" alt="">
            @else
            <img src="{{asset('uploads/1.jpg')}}" class="image" alt="">
            @endif
            <div class="name">{{ Auth::user()->name }}</div>
        </div>
        <div class="sidebar-widget-title py-3">
            <span>{{__('Menu')}}</span>
        </div>
        <div class="widget-profile-menu py-3">
            <ul class="categories categories--style-3">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ areActiveRoutesHome(['dashboard'])}}">
                        <i class="la la-dashboard"></i>
                        <span class="category-name">
                            {{__('Dashboard')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('purchase_history.index') }}" class="{{ areActiveRoutesHome(['purchase_history.index'])}}">
                        <i class="la la-file-text"></i>
                        <span class="category-name">
                            {{__('Purchase History')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('wishlists.index') }}" class="{{ areActiveRoutesHome(['wishlists.index'])}}">
                        <i class="la la-heart-o"></i>
                        <span class="category-name">
                            {{__('Wishlist')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile') }}" class="{{ areActiveRoutesHome(['profile'])}}">
                        <i class="la la-user"></i>
                        <span class="category-name">
                            {{__('Manage Profile')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('wallet.index') }}" class="{{ areActiveRoutesHome(['wallet.index'])}}">
                        <i class="la la-dollar"></i>
                        <span class="category-name">
                            {{__('My Wallet')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('prescription.index') }}" class="{{ areActiveRoutesHome(['prescription.index'])}}">
                        <i class="la la-file-text"></i>
                        <span class="category-name">
                            {{__('Upload Prescription')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('message.index') }}" class="{{ areActiveRoutesHome(['message.index'])}}">
                        <i class="la la-envelope-o"></i>
                        <span class="category-name">
                            {{__('Request Message')}}
                        </span>
                    </a>
                </li>
                <li>
                    @if(!empty(\App\Models\Medication::where('user_id', '=', Auth::user()->id)->first()->user_id))
                    <a href="{{route('usermedication.view')}}" class="{{ areActiveRoutesHome(['usermedication.view'])}}">
                        <i class="fa fa-medkit"></i>
                        <span class="category-name">
                            {{__('Medication View')}}
                        </span>
                    </a>
                    @else
                    <a href="{{ route('usermedication.index') }}" class="{{ areActiveRoutesHome(['usermedication.index'])}}">
                        <i class="fa fa-medkit"></i>
                        <span class="category-name">
                            {{__('Add Medication')}}
                        </span>
                    </a>
                    @endif
                </li>
                <li>
                    <a href="{{ route('group.index') }}" class="{{ areActiveRoutesHome(['group.index'])}}">
                        <i class="fa fa-users"></i>
                        <span class="category-name">
                            {{__('Submit Group')}}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        {{-- @if (\App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
            <div class="widget-seller-btn pt-4">
                <a href="{{ route('shops.create') }}" class="btn btn-anim-primary w-100">{{__('Be A Seller')}}</a>
            </div>
        @endif --}}
    </div>
</div>
