<div id="hpage_cats">
    <div class="fl_left">
        <img src="/img/{{ $post->photo }}" alt="" />
        <p>
            <strong>
                <a href="/news/edit/{{ $post->id }}">{{ $post->title }}</a>
            </strong>

        <div class="pull-right">
            <a href="/news/edit/{{$post->id}}">
                <i class="glyphicon glyphicon-edit " aria-hidden="true" title="Edit record"></i>
            </a>
            <a href="/news/delete/{{$post->id}}">
                <i class="glyphicon glyphicon-trash red " id="{{ $post->id }}" aria-hidden="true"
                   title="Delete record"></i>
            </a>  
        </div>
    </p>
    <p class="blog-post-meta">By <a href="#">{{ $post->created_by }}</a> On {{ $post->created_at->toFormattedDateString() }} </p>
    {{ \Illuminate\Support\Str::words($post->body, 35,'...') }}
    <a href='/news/edit/{{ $post->id }}'>Read More</a>

    </div>
</div>