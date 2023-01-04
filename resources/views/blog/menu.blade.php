<div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
        <a class="p-2 text-muted" href="{{ route('blog.index') }}">All</a>
        @foreach($list as $item)
            <a class="p-2 text-muted" href="{{ $item->url }}">{{ $item->title }}</a>
        @endforeach
    </nav>
</div>
