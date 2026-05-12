@extends('frontend.layouts.app')
@section('title')
    WishList
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
            <!-- <img src="images/logo.png" class="mobile-menu-logo"> -->
            <div class="right-element">
                <div class="dropdown">
                    <a class="btn dropdown-toggle profile-manage" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(!empty(Auth::user()->avatar_original))
                        <img src="{{asset(Auth::user()->avatar_original)}}" alt="">
                        @else
                            <img src="{{asset('uploads/1.jpg')}}" alt="">
                        @endif
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('profile') }}"><span class="iconify"
                                data-icon="carbon:user-avatar"></span> Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><span class="iconify"
                                data-icon="ion:log-out-outline"></span> Log Out</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="dashboard-content">
            <section class="wishlist">
                <div class="title-section">
                    <span class="iconify mr-1" data-icon="bi:heart-fill"></span> Your Wishlist
                </div>

                <div class="wishlist-area">
                    @foreach ($wishlists as $key => $wishlist)
                    <div class="wishliat-items shadow-sm" id="wishlist_{{ $wishlist->id }}">
                        <div class="card">
                            <button class="remove-product " title="Remove From wishlist" onclick="removeFromWishlist({{ $wishlist->id }})">
                                <span class="iconify" data-icon="ci:off-outline-close"></span>
                            </button>
                            <a href="{{ route('product', $wishlist->product->slug) }}" class="d-block"><img class="img-fluid" src="{{ asset($wishlist->product->thumbnail_img) }}" alt="">
                            </a>
                            <p class="title mt-3">
                                <a href="{{ route('product', $wishlist->product->slug) }}">{{ $wishlist->product->name }}</a>
                            </p>
                            <div class="price">
                                {{-- <del>৳505.00</del> --}}
                                @if(home_base_price($wishlist->product->id) != home_discounted_base_price($wishlist->product->id))
                                <del>{{ home_base_price($wishlist->product->id) }}</del> -
                                @endif
                                <span>{{ home_discounted_base_price($wishlist->product->id) }}</span>
                            </div>
                            <p class="actions">

                                <button class="btn-theme text-white mb-2" title="Add to cart" onclick="showAddToCartModal({{ $wishlist->product->id }})">Add To Cart</button>
                            </p>
                        </div>
                    </div>
                    @endforeach

                </div>

                {{-- <nav aria-label="Page navigation">
                    <ul class="pagination float-right mr-3">
                      <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                      <li class="page-item"><a class="page-link active" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                  </nav> --}}
                  <div class="pagination-wrapper py-4">
                    <ul class="pagination justify-content-end">
                        {{ $wishlists->links() }}
                    </ul>
                </div>

            </section>
        </div>
    </div>
</div>

    <div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
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

@endsection

@section('script')
    <script type="text/javascript">
        function removeFromWishlist(id){
            $.post('{{ route('wishlists.remove') }}',{_token:'{{ csrf_token() }}', id:id}, function(data){
                $('#wishlist').html(data);
                $('#wishlist_'+id).hide();
                showFrontendAlert('success', 'Item has been renoved from wishlist');
            })
        }
    </script>
@endsection
