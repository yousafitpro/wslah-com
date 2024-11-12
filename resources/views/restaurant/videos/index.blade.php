@extends('layouts.app')
@section('title', __('system.restaurants.title'))
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">

                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <h4 class="card-title">{{ __('system.videos.menu') }}</h4>
                        <div class="page-title-box pb-0 d-sm-flex">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('system.videos.menu') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">
                        <a href="{{ route('restaurant.videos.create') }}" class="btn btn-primary"><i
                                class="bx bx-plus me-1"></i> {{ __('system.crud.add_new') }}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="mb-4">
                    <div id="restaurants_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                        {{--                            @include('common.filter_ui')--}}
                        <div id="data-preview" class='overflow-hidden'>
                            @include('restaurant.videos.table')
                        </div>

                    </div>
                    <!-- end table -->
                </div>
                <!-- end table responsive -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('third_party_stylesheets')
<style>
.video-container {
    position: relative;
    padding-top: 56.25%;
    /* 16:9 aspect ratio (9 / 16 * 100) */
    overflow: hidden;
    background-color: #000;
    /* Set a background color to match the video's poster color */
}

.video-container video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* Scale the video while maintaining aspect ratio */
}
</style>
@endpush
@push('page_scripts')
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"
    integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(function() {
    $(".tblLocations").sortable({
        cursor: 'pointer',
        dropOnEmpty: false,
        start: function(e, ui) {
            ui.item.addClass("selected");
        },
        stop: function(e, ui) {
            ui.item.removeClass("selected");
            console.log(333);
            $(this).find(".table-data").each(function(index) {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('restaurant.video.change.position') }}",
                    type: 'post',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                        'index': index + 1,

                    },
                    success: function(data) {

                    },
                });

            });
        }
    });
});
</script>
@endpush