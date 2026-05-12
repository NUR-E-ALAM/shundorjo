    <div class="row">
        @foreach ($data['blogs'] as $value)
        <div class="col-md-4">
            <div class="mn-img">
                <img class="lazyload" data-src="{{ asset($value->photo)}}" style="width: 350px; height:180px;"  />
                <div class="mn-title">
                    <a href="{{ route('health-and-bueaty-tips', $value->slug) }}">{{@$value->title}}</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    <!-- Pagination (hidden on the first load but used by AJAX) -->
@if ($data['blogs']->hasMorePages())
<div class="pagination-links" style="display: none;">
    {{ $data['blogs']->appends(request()->query())->links() }}
</div>
@endif

