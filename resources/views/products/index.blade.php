@extends('layouts.app')

@section('content')

@if($type != 'Seller')
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('products.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Product')}}</a>
        </div>
    </div>
@endif

<br>

<div class="col-lg-12">
    <div class="panel">
        <!--Panel heading-->
        <div class="panel-heading">
            <h3 class="panel-title">{{ __($type.' Products') }}</h3>
        </div>
        @if (isset($sellers))
            <form action="{{ route('products.seller') }}" method="get">
                <div class="row">
                    <div class="col-lg-4">
                        <select name="seller_id" id="" class="form-control">
                            <option value="">Select Seller</option>
                            @foreach($sellers as $seller)
                                <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
            @else
            <form action="{{ route('products.admin') }}" method="get">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                     <input type="text" class="form-control" placeholder="Product Name" name="p_name"/>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        @endif


        <br>

        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">{{__('Name')}}</th>
                        <th>{{__('Photo')}}</th>
                        <th>{{__('Current qty')}}</th>
                        <th>{{__('Unit Price')}}</th>
                        <th>{{__('Discount Price')}}</th>
                        <th>{{__('Todays Deal')}}</th>
                        <th>{{__('Published')}}</th>
                        <th>{{__('Featured')}}</th>
                        <th>{{__('Stock')}}</th>
                        <th>{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td><a href="{{ route('product', $product->slug) }}" target="_blank">{{ __($product->name) }}</a></td>
                            <td><img class="img-md" src="{{ asset($product->thumbnail_img)}}" alt="Image"></td>
                            <td>
                                @php
                                    $qty = 0;
                                    foreach (json_decode($product->variations) as $key => $variation) {
                                        $qty += $variation->qty;
                                    }
                                    echo $qty;
                                @endphp
                            </td>
                            <td> {{ number_format($product->unit_price,2) }} </td>
                            <td>{{ $product->discount_type == 'amount' ? number_format($product->unit_price - $product->discount, 2) : number_format($product->unit_price - ($product->unit_price * $product->discount / 100), 2) }} ({{ $product->discount_type == 'amount' ? number_format($product->discount, 2) :  $product->discount.'%' }}) </td>
                            <td><label class="switch">
                                <input onchange="update_todays_deal(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->todays_deal == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                            <td><label class="switch">
                                <input onchange="update_published(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->published == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                            <td><label class="switch">
                                <input onchange="update_featured(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->featured == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                                <td><label class="switch">
                                    <input onchange="update_isstock(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->is_stock == 1) echo "checked";?> >
                                    <span class="slider round"></span></label></td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if ($type == 'Seller')
                                            <li><a href="{{route('products.seller.edit', encrypt($product->id))}}">{{__('Edit')}}</a></li>
                                        @else
                                            <li><a href="{{route('products.admin.edit', encrypt($product->id))}}">{{__('Edit')}}</a></li>
                                        @endif
                                        <li><a onclick="confirm_modal('{{route('products.destroy', $product->id)}}');">{{__('Delete')}}</a></li>
                                        <li><a href="{{route('products.duplicate', $product->id)}}">{{__('Duplicate')}}</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
         {{ $products->links() }}
    </div>
</div>

@endsection


@section('script')
    <script type="text/javascript">

        $(document).ready(function(){
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.todays_deal') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Todays Deal updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Published products updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Featured products updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_isstock(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.is_stock') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', ' Products Stock updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
