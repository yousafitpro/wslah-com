@push('page_css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<style>
.tblLocations .card {
    box-shadow: 0 0 3px rgb(0 0 0 / 15%);
}

body[data-layout-mode="dark"] #data-preview .card {
    background: #0000002e;
}
</style>
@endpush
<div class="row">
    <div class="col-sm-12">
        <div class="row tblLocations">
            @forelse ($videos as $video)

            <div class="col-md-4 table-data" data-id="{{ $video->id }}" role="button">
                <i class="fas fa-grip-vertical grid-move-icon"></i>
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                {{--<h4>{{ $video->title }}</h4>--}}
                                {{--<p>{{ $video->description }}</p>--}}
                                <div class="video-container mb-2">
                                    <video controls>
                                        <source src="{{ asset('storage/' . $video->file) }}">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <form action="{{ route('restaurant.videos.destroy', $video) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this video?')">Delete</button>
                                </form>
                                <!-- Add the "Edit" button -->
                                <a href="{{ route('restaurant.videos.edit', $video) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            @empty
            <li class="list-group-item">No videos found.</li>
            @endforelse
        </div>

    </div>
</div>
<div class="row">
    {{ $videos->links() }}
</div>