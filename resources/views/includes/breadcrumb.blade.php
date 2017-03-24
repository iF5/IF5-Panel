<h2>
    @foreach($breadcrumbs as $breadcrumb)
        @if($breadcrumb->active)
            {{ $breadcrumb->label }}
        @else
            <a href="{{ $breadcrumb->link }}">
                <span class="text-primary">{{ $breadcrumb->label }}</span>
            </a>
            <span class="glyphicon glyphicon-chevron-right"></span>
        @endif
    @endforeach
</h2>
<div class="clearfix"></div>