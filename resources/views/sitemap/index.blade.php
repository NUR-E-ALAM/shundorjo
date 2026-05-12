@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{route('sitemap.generate')}}"><button type="button" class="btn btn-success pull-left mb-2 pb-2"> Generate Site Map </button></a>
        <button type="button" class="btn btn-purple pull-right mb-2 pb-2" data-toggle="modal" data-target="#sitemap"> Add Site Map</button>
     
    </div>
</div>
<br>
<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Site Map List')}}</h3>

    </div>
    <div class="panel-body">
        
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Slug')}}</th>
                    <th>{{__('Description')}}</th>
                    <th width="10%">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siteMap as $key => $sitemaps)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $sitemaps->title }}</td>
                        <td>{{ $sitemaps->slug }}</td>
                        <td>{{ $sitemaps->body }}</td>
                        <td>
                            <button type="button" class="btn btn-purple pull-right mb-2 pb-2" data-toggle="modal" data-target="#{{$sitemaps->id}}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </button>
                        </td>
                    </tr>
                    
                    
                    {{-- view model start --}}
                    <div class="modal fade" id="{{$sitemaps->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Site Map Update</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('sitemap.update')}}" method="post">
                                    @csrf
                                <div class="modal-body">
                        
                                    <div class="form-group">
                                        
                                        <div class="col-sm-12">
                                            <input type="hidden" name="id" value="{{$sitemaps->id}}">
                                            <input type="text" name="title" value="{{$sitemaps->title}}" class="form-control" placeholder="Type your Title">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="text" name="slug" value="{{$sitemaps->slug}}" class="form-control"  placeholder="Type your slug">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <textarea name="desc" id="" cols="76" rows="8" placeholder="Type your commnets">{{$sitemaps->body}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" value="Save changes">
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    {{-- view model end  --}}

                @endforeach
            </tbody>
        </table>
 <!-- Add Modal start -->
 <div class="modal fade" id="sitemap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Site Map</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{route('sitemap.store')}}" method="post">
            @csrf
        <div class="modal-body">

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" name="title" value="" class="form-control" placeholder="Type your Title">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" name="slug" value="" class="form-control"  placeholder="Type your slug">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-12">
                    <textarea name="desc" id="" cols="76" rows="8" placeholder="Type your commnets"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Save changes">
        </div>
    </form>
    </div>
    </div>
</div>
<!-- Add Modal end -->
    </div>
</div>

@endsection

@section('script')
    <script>
        $(function () {
            $("select").select2();
        });
    </script>
@endsection
