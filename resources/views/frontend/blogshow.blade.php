@extends('frontend.layouts.app')
@section('css')
    {{-- <link rel="stylesheet" href="{{asset('frontend/css/all.css')}}"> --}}
@endsection
@section('content')
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
          <ul class="pages">
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
              <a href="{{ route('front.blogshow',$blog->id) }}">
                {{ $blog->title }}
              </a>
            </li>
          </ul>
      </div>
    </div>
  </div>
</div> 
<!-- Breadcrumb Area End -->



  <!-- Blog Details Area Start -->
  <section class="blog-details" id="blog-details">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="blog-content">
            <div class="feature-image">
              <img class="img-fluid" src="{{ asset('public/images/blogs/'.$blog->photo) }}" alt="">
            </div>

            <div class="content">
                <h3 class="title">
                    {{ $blog->title }}
                  </h3>
                  <ul class="post-meta">
                    <li>
                      <a href="javascript:;">
                        <i class="icofont-calendar"></i>
                        {{ date('d M, Y',strtotime($blog->created_at)) }}
                      </a>
                    </li>
                    <li>
                      <a href="javascript:;">
                          <i class="icofont-eye"></i>
                        {{ $blog->views }} Views
                      </a>
                    </li>
                    <li>
                      <a href="javascript:;">
                        <i class="icofont-speech-comments"></i>
                        Source : {{ $blog->source }}
                      </a>
                    </li>
                  </ul>

                  {!! $blog->details !!}

                  <div class="tag-social-link">
                    <div class="tag">
                      <h6 class="title">Tag : </h6>
                      @foreach(explode(',', $blog->tags) as $key => $tag)
                        <a href="{{ route('front.blogtags',$tag) }}">
                        {{ $tag }}{{ $key != count(explode(',', $blog->tags)) - 1  ? ',':''}}
                        </a>
                      @endforeach
                    </div>

                    <div class="social-sharing a2a_kit a2a_kit_size_32">
                    <ul class="social-links">
                      <li>
                        <a class="facebook a2a_button_facebook" href="">
                          <i class="fa fa-facebook"></i>
                        </a>
                      </li>
                        <li>
                            <a class="twitter a2a_button_twitter" href="">
                              <i class="fa fa-twitter"></i>
                            </a>

                        </li>
                        <li>
                            <a class="linkedin a2a_button_linkedin" href="">
                              <i class="fa fa-linkedin-in"></i>
                            </a>

                        </li>
                        <li>

                        <a class="a2a_dd plus" href="https://www.addtoany.com/share">
                            <i class="fa fa-plus"></i>
                          </a>
                        </li>
                    </ul>
                    </div>
                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                  </div>

            </div>
              {{-- comment form --}}
              <div class="content">
                <h3 class="title"> Make a comment </h3>
                  @if (!empty(Auth::user()->id))
                                          
                  @else
                      <p style="color: #ff4343">To make a comment you should log in first.</p>
                  @endif
                <form method="POST" action="{{ route('blog.comment') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea name="comment" id="comment" cols="30" rows="5" class="form-control" required></textarea>
                  </div>
                  <input type="hidden" class="form-control" id="bcmntid" name="bcmntid" value="{{ $blog->id }}">

                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <div class="text-right mt-4">

                    
                    @if (!empty(Auth::user()->id))
                    <button type="submit" class="btn btn-styled btn-base-1">{{__('Submit')}}</button>
                    @else
                        <button  class="btn btn-styled btn-base-1"><a href="{{route('user.login')}}" style="color: white; text-decoration:none">Go to Login</a></button>
                    @endif

                </div>
                </form>

              </div>
              {{-- comment form end --}}

              {{-- comment show --}}
              
              <h3 class="title"> All Comments </h3>
              @foreach ($bcmnts as $comment)
                <div class="content">
                    <p><strong>Comment:</strong>  {{ $comment->comments }}</p>
                    <p>Name: {{ $comment->name }} | Email: {{ $comment->email }}</p>
                </div>
              @endforeach
              {{ $bcmnts->links() }}
              {{-- comment show end --}}
          </div>
        </div>






        <div class="col-lg-4">
          <div class="blog-aside">
            <div class="serch-form">
              <form action="{{ route('front.blogsearch') }}">
                <input type="text" name="search" placeholder="serch post" required="">
                <button type="submit"><i class="fa fa-search"></i></button>
              </form>
            </div>
            <div class="categori">
              <h4 class="title">Categories</h4>

              <span class="separator"></span>
              <ul class="categori-list">
                @foreach($bcats as $cat)
                <li>
                  <a href="{{ route('front.blogcategory',$cat->slug) }}"  {!! $cat->id == $blog->category_id ? 'class="active"':'' !!}>
                    <span>{{ $cat->name }}</span>
                    <span>({{ $cat->blogs()->count() }})</span>
                  </a>
                </li>
                @endforeach

              </ul>
            </div>
            <div class="recent-post-widget">
              <h4 class="title">Recent Post</h4>
              <span class="separator"></span>
              <ul class="post-list">

                @foreach (App\Models\Blog::orderBy('created_at', 'desc')->limit(4)->get() as $blog)
                <li>
                  <div class="post">
                    <div class="post-img">
                      <img style="width: 73px; height: 59px;" src="{{ asset('public/images/blogs/'.$blog->photo) }}" alt="">
                    </div>
                    <div class="post-details">
                      <a href="{{ route('front.blogshow',$blog->id) }}">
                          <h4 class="post-title">
                              {{mb_strlen($blog->title,'utf-8') > 45 ? mb_substr($blog->title,0,45,'utf-8')." .." : $blog->title}}
                          </h4>
                      </a>
                      <p class="date">
                          {{ date('M d - Y',(strtotime($blog->created_at))) }}
                      </p>
                    </div>
                  </div>
                </li>
                @endforeach


              </ul>
            </div>
            <div class="archives">
              <h4 class="title">Archives</h4>
              <span class="separator"></span>
              <ul class="archives-list">
                @foreach($archives as $key => $archive)
                <li>
                  <a href="{{ route('front.blogarchive',$key) }}">
                    <span>{{ $key }}</span>
                    <span>({{ count($archive) }})</span>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
            <div class="tags">
              <h4 class="title">Tags</h4>
              <span class="separator"></span>
              <ul class="tags-list">
                @foreach($tags as $tag)
                  @if(!empty($tag))
                  <li>
                    <a href="{{ route('front.blogtags',$tag) }}">{{ $tag }} </a>
                  </li>
                  @endif
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Blog Details Area End-->


@endsection
