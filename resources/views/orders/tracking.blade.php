@extends('layouts.app')

@section('content')
 {{-- search strt  --}}
 <form  action="{{route('tracking_search.index')}}" method ="POST">
    @csrf
    <br>
    <div class="container-fluid" style="background-color: rgb(0 0 0 / 20%); border: 1px solid #8a753bbf;">
        <div class="row">
            <div class="col-md-9">
                <label for="code" style="margin-top: 9px;" class="col-form-label col-md-3">Order Code</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" style="margin-top: 2px;" id="code" name="code" required placeholder="Input Order Number">
                </div>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-success" name="search" title="Search" style="width: 220px"><img src="https://img.icons8.com/android/24/000000/search.png"/>Search</button>
            </div>
        </div>
    </div>
    <br>
</form>
{{-- search end  --}}




@endsection

@section('script')
    {{-- <script>
        $(function () {
            $("select").select2();
        });
    </script> --}}
@endsection
