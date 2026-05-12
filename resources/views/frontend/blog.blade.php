@extends('frontend.layouts.app')

@section('title')
    Apon Health- Online Drug House
@stop
@section('css')
    <link type="text/css" href="{{ asset('frontend/css/extra.css') }}" rel="stylesheet">
@endsection
@section('content')

   <!-- Breadcrumb Area Start -->
   <div class="breadcrumb-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <ul class="pages">

          {{-- Category Breadcumbs --}}

          @if(isset($bcat))

              <li>
                <a href="{{ route('front.index') }}">
                  Home
                </a>
              </li>
              <li>
                <a href="{{ route('front.blog') }}">
                  Blog
                </a>
              </li>
              <li>
                <a href="{{ route('front.blogcategory',$bcat->slug) }}">
                  {{ $bcat->name }}
                </a>
              </li>

          @elseif(isset($slug))

              <li>
                <a href="{{ route('front.index') }}">
                  Home
                </a>
              </li>
              <li>
                <a href="{{ route('front.blog') }}">
                  Blog
                </a>
              </li>
              <li>
                <a href="{{ route('front.blogtags',$slug) }}">
                  Tag: {{ $slug }}
                </a>
              </li>

          @elseif(isset($search))

              <li>
                <a href="{{ route('front.index') }}">
                    Home
                </a>
              </li>
              <li>
                <a href="{{ route('front.blog') }}">
                    Blog
                </a>
              </li>
              <li>
                <a href="Javascript:;">
                  Search
                </a>
              </li>
              <li>
                <a href="Javascript:;">
                  {{ $search }}
                </a>
              </li>

          @elseif(isset($date))

              <li>
                <a href="{{ route('front.index') }}">
                  Home
                </a>
              </li>
              <li>
                <a href="{{ route('front.blog') }}">
                  Blog
                </a>
              </li>
              <li>
                <a href="Javascript:;">
                  Date: {{ date('F Y',strtotime($date)) }}
                </a>
              </li>

          @else

              <li>
                <a href="{{ route('front.index') }}">
                  Home
                </a>
              </li>
              <li>
                <a href="{{ route('front.blog') }}">
                  Blog
                </a>
              </li>
          @endif

          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumb Area End -->

    <!-- Blog Page Area Start -->
    <section class="blogpagearea">
        <div class="container">
            <div id="ajaxContent">

                <div class="row">

                    @foreach ($blogs as $blogg)
                        <div class="col-md-6 col-lg-4">
                            <div class="blog-box">
                                <div class="blog-images">
                                    <div class="img">
                                        <a href="{{ route('front.blogshow', encrypt($blogg->id)) }}">
                                        <img src="{{ $blogg->photo ? asset('public/images/blogs/' . $blogg->photo) : asset('public/images/noimage.png') }}"
                                            class="img-fluid" alt=""></a>
                                        <div class="date d-flex justify-content-center">
                                            <div class="box align-self-center">
                                                <p>{{ date('d', strtotime($blogg->created_at)) }}</p>
                                                <p>{{ date('M', strtotime($blogg->created_at)) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="details">
                                    <a href='{{ route('front.blogshow', encrypt($blogg->id)) }}'>
                                        <h4 class="blog-title">
                                            {{ mb_strlen($blogg->title, 'utf-8') > 50 ? mb_substr($blogg->title, 0, 50, 'utf-8') . '...' : $blogg->title }}
                                        </h4>
                                    </a>
                                    <p class="blog-text">
                                        {{ substr(strip_tags($blogg->details), 0, 120) }}
                                    </p>
                                    <a class="read-more-btn"
                                        href="{{ route('front.blogshow', encrypt($blogg->id)) }}">Read More</a>
                                </div>
                            </div>
                        </div>


                    @endforeach

                </div>

                <div class="page-center">
                    {!! $blogs->links() !!}
                </div>
            </div>

        </div>
    </section>
    <!-- Blog Page Area Start -->



@endsection
@section('script')

@endsection
