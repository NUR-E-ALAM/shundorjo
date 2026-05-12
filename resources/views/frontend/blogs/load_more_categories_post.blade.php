<div class="row">
    @foreach ($blogs as $value)
        <div class="col-12 mb-4">
            <div class="blog-box d-flex align-items-start">

                <!-- Image -->
                <div class="post-media col-md-4 p-0">
                    <a href="{{ route('health-and-bueaty-tips', $value->slug) }}" title="{{ $value->title }}">
                        <img data-src="{{ asset($value->photo) }}"
                             alt="{{ $value->title }}"
                             class="img-fluid lazyload w-100">
                        <div class="hovereffect"></div>
                    </a>
                </div>

                <!-- Content -->
                <div class="col-md-8">
                    <span class="bg-aqua">
                        <a href="{{ route('health-and-bueaty-tips', $value->slug) }}" title="{{ $value->title }}">
                            {{ $value->category->name }}
                        </a>
                    </span>

                    <h4>
                        <a href="{{ route('health-and-bueaty-tips', $value->slug) }}" title="{{ $value->title }}">
                            {{ $value->title }}
                        </a>
                    </h4>

                    <a href="{{ route('health-and-bueaty-tips', $value->slug) }}">
                        <p class="blog-txt-size">
                            {!! \Illuminate\Support\Str::limit(strip_tags($value->details), 300) !!}
                        </p>
                    </a>

                    <div class="meta mt-2">
                        <small>
                            <i class="fa fa-eye"></i> {{ $value->views }}
                        </small>
                     <small class="ml-3">
    {{ date('F j, Y, g:i a', strtotime($value->created_at)) }}
</small>
                        <small class="ml-3">
                            Written by
                            <a href="{{ route('health-and-bueaty-tips', $value->slug) }}" title="{{ $value->create_by }}">
                                {{ $value->create_by }}
                            </a>
                        </small>
                    </div>
                </div>
            </div>

            <hr class="invis">
        </div>
    @endforeach
</div>

<!-- Pagination -->
@if ($blogs->hasMorePages())
    <div class="pagination-links" style="display: none;">
        {{ $blogs->appends(request()->query())->links() }}
    </div>
@endif
