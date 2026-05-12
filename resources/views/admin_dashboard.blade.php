@extends('layouts.app')

@section('content')
 <!-- Ionicons -->
<style>
    table td, table th {
    border: 1px solid #e3e3e3 !important;
    padding: 5px;
    }
</style>
@if(Auth::user()->user_type == 'admin' || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-xs-6">
                    <div class="panel bg-info">
                        <div class="pad-top text-center dash-widget">
                            <i class="fa fa-money" style="font-size:60px;"></i>

                            <p class="text-semibold text-2x text-white">৳ {{ \App\Models\Order::whereMonth('updated_at', date('m'))->where('payment_status','paid')->sum('grand_total') }} </p>
                            <p class="btn btn-primary mar-top btn-block top-border-radius-no">Total Recived (<small>This Month</small>)</p>

                            {{-- <a href="{{ route('subcategories.create') }}" class="btn btn-primary mar-top btn-block top-border-radius-no">Create Sub Category</a> --}}
                        </div>
                    </div>
                    <div class="panel" style="background-color: #0000cc;">
                        <div class="pad-top text-center dash-widget">
<a href="{{ route('orders.delivered') }}">
                            <p class="text-semibold text-2x" style="color: white;">{{ \App\Models\Order::whereMonth('updated_at', date('m'))->where('delivery_status','delivered')->count()}}</p>
                            <i class="fa fa-shopping-bag" style="font-size:60px; color:white;"></i>

                            <p class="btn btn-primary mar-top btn-block top-border-radius-no">Total Complete Order (<small>This Month</small>)</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="panel bg-success">
                        <div class="pad-top text-center dash-widget">
 <a href="{{ route('orders.index.admin') }}">
                            <p class="text-semibold text-2x text-white">{{ \App\Models\Order::whereMonth('created_at', date('m'))->count()}}</p>
                            <i class="fa fa-shopping-basket" style="font-size:60px;"></i>

                            <p class="btn btn-primary mar-top btn-block top-border-radius-no">Total Order (<small>This Month</small>)</p>
                            </a>
                        </div>
                    </div>
                    <div class="panel bg-warning">
                        <div class="pad-top text-center dash-widget">
<a href="{{ route('orders.pending') }}">
                            <p class="text-semibold text-2x text-white">{{ \App\Models\Order::where('delivery_status','pending')->count()}}</p>
                            <i class="fa fa-cubes" style="font-size:60px;"></i>
                            <p class="btn btn-primary mar-top btn-block top-border-radius-no">Total Pending Order </p>
                            </a>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-xs-6">
                    <div class="panel bg-danger">
                        <div class="pad-top text-center dash-widget">
                            <i class="fa fa-gift" style="font-size:60px;"></i>

                            <p class="text-semibold text-2x text-white">৳ {{ \App\Models\Order::where('payment_status','unpaid')->sum('grand_total') }} </p>
                            <p class="btn btn-primary mar-top btn-block top-border-radius-no">Total Unpaid Sales</p>
                        </div>
                    </div>
                    <div class="panel" style="background-color: #ff0066;">
                        <div class="pad-top text-center dash-widget">
<a href="{{ route('orders.processing') }}">
                            <p class="text-semibold text-2x" style="color: white;">{{ \App\Models\Order::where('delivery_status','processing')->count()}}</p>
                            <i class="fa fa-hourglass-half" style="font-size:60px; color:white;"></i>
                            <p class="btn btn-primary mar-top btn-block top-border-radius-no">Total Processing Order</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="panel" style="background-color: #8800cc">
                        <div class="pad-top text-center dash-widget">
<a href="{{ route('orders.on_delivery') }}">
                            <p class="text-semibold text-2x" style="color:white;">{{ \App\Models\Order::where('delivery_status','on_delivery')->count()}}</p>
                            <i class="fa fa-truck" style="font-size:60px; color:white;"></i>
                            <p class="btn btn-primary mar-top btn-block top-border-radius-no">On-Delivery Order</p>
                            </a>
                        </div>
                    </div>
                    <div class="panel" style="background-color:  #cc0099;">
                        <div class="pad-top text-center dash-widget">
                            <a href="{{ route('customers.index') }}">
                            <p class="text-semibold text-2x" style="color:white;">{{ \App\Models\User::where('user_type','customer')->count() }}</p>
                            <i class="fa fa-users" style="font-size:60px; color:white;"></i>

                            <p class="btn btn-primary mar-top btn-block top-border-radius-no">Customers</p>
                            </a>
                        </div>
                    </div>
                </div>


            </div>

        </div>

{{-- Products  --}}


    <div class="col-md-6">
        <div class="panel">
            <div class="panel-body text-center dash-widget dash-widget-left">
                <div class="dash-widget-vertical">
                    <div class="rorate">PRODUCTS</div>
                </div>
                <div class="pad-ver mar-top text-main">
                    <i class="demo-pli-data-settings icon-4x"></i>
                </div>
                <br>
                <p class="text-lg text-main">Total published products: <span class="text-bold">{{ \App\Models\Product::where('published', 1)->get()->count() }}</span></p>
                @if (\App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                    <p class="text-lg text-main">Total seller's products: <span class="text-bold">{{ \App\Models\Product::where('published', 1)->where('added_by', 'seller')->get()->count() }}</span></p>
                @endif
                <p class="text-lg text-main">Total admin's products: <span class="text-bold">{{ \App\Models\Product::where('published', 1)->where('added_by', 'admin')->get()->count() }}</span></p>
                <br>
                <a href="{{ route('products.admin') }}" class="btn btn-primary mar-top">Manage Products <i class="fa fa-long-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel">
                    <div class="pad-top text-center dash-widget">
                        <p class="text-normal text-main">Total product category</p>
                        <p class="text-semibold text-3x text-main">{{ \App\Models\Category::all()->count() }}</p>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary mar-top btn-block top-border-radius-no">Create Category</a>
                    </div>
                </div>
                <div class="panel">
                    <div class="pad-top text-center dash-widget">
                        <p class="text-normal text-main">Total product sub sub category</p>
                        <p class="text-semibold text-3x text-main">{{ \App\Models\SubSubCategory::all()->count() }}</p>
                        <a href="{{ route('subsubcategories.create') }}" class="btn btn-primary mar-top btn-block top-border-radius-no">Create Sub Sub Category</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel">
                    <div class="pad-top text-center dash-widget">
                        <p class="text-normal text-main">Total product sub category</p>
                        <p class="text-semibold text-3x text-main">{{ \App\Models\SubCategory::all()->count() }}</p>
                        <a href="{{ route('subcategories.create') }}" class="btn btn-primary mar-top btn-block top-border-radius-no">Create Sub Category</a>
                    </div>
                </div>
                <div class="panel">
                    <div class="pad-top text-center dash-widget">
                        <p class="text-normal text-main">Total product brand</p>
                        <p class="text-semibold text-3x text-main">{{ \App\Models\Brand::all()->count() }}</p>
                        <a href="{{ route('brands.create') }}" class="btn btn-primary mar-top btn-block top-border-radius-no">Create Brand</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if((Auth::user()->user_type == 'admin' || in_array('5', json_decode(Auth::user()->staff->role->permissions))) && \App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
    <div class="row">
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body text-center dash-widget dash-widget-left">
                <div class="dash-widget-vertical">
                    <div class="rorate">SELLERS</div>
                </div>
                <br>
                <p class="text-normal text-main">Total sellers</p>
                <p class="text-semibold text-3x text-main">{{ \App\Models\Seller::all()->count() }}</p>
                <br>
                <a href="{{ route('sellers.index') }}" class="btn-link">Manage Sellers <i class="fa fa-long-arrow-right"></i></a>
                <br>
                <br>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body text-center dash-widget">
                <br>
                <p class="text-normal text-main">Total approved sellers</p>
                <p class="text-semibold text-3x text-main">{{ \App\Models\Seller::where('verification_status', 1)->get()->count() }}</p>
                <br>
                <a href="{{ route('sellers.index') }}" class="btn-link">Manage Sellers <i class="fa fa-long-arrow-right"></i></a>
                <br>
                <br>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body text-center dash-widget">
                <br>
                <p class="text-normal text-main">Total pending sellers</p>
                <p class="text-semibold text-3x text-main">{{ \App\Models\Seller::where('verification_status', 0)->count() }}</p>
                <br>
                <a href="{{ route('sellers.index') }}" class="btn-link">Manage Sellers <i class="fa fa-long-arrow-right"></i></a>
                <br>
                <br>
            </div>
        </div>
    </div>
</div>
@endif

@if(Auth::user()->user_type == 'admin' || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
    <div class="row">
    <div class="col-md-6">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title" style="border: 1px solid #e3e3e3">Category wise product sale</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Models\Category::all() as $key => $category)
                                <tr>
                                    <td>{{ __($category->name) }}</td>
                                    <td>{{ \App\Models\Product::where('category_id', $category->id)->sum('num_of_sale') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title" style="border: 1px solid #e3e3e3">Category wise product stock</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Models\Category::all() as $key => $category)
                                @php
                                    $products = \App\Models\Product::where('category_id', $category->id)->get();
                                    $qty = 0;
                                    foreach ($products as $key => $product) {
                                        foreach (json_decode($product->variations) as $key => $variation) {
                                            $qty += $variation->qty;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ __($category->name) }}</td>
                                    <td>{{ $qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
