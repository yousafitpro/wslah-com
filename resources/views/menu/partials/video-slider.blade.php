<ul class="slider-wrapper d-flex" style="margin: 0; padding:0; height: 100%; width:100%" id="slider">
    @if (filled($intro_video_url))
        @foreach ($intro_video_url as $key => $intro_url)
            <li class="video slide-current m-auto" style="height: 100%; width:100%; display:flex"
                data-type="video" data-video="{{ asset('storage/' . $intro_url->file) }}" data-muted="true"></li>
        @endforeach
    @endif
</ul>
