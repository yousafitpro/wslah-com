@extends('layouts.app')
@section('title', __('system.food_categories.create.menu'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-mb-8 col-xl-8">
                            <h4 class="card-title">{{ __('system.videos.create.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a href="{{ route('restaurant.videos.index') }}">{{ __('system.videos.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.videos.update.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::model($video, ['route' => ['restaurant.videos.update', $video->id], 'method' => 'put', 'files' => true, 'id' => 'pristine-valid']) }}
{{--                            <form autocomplete="off" novalidate="" action="{{ route('restaurant.videos.update',$video->id) }}" id="pristine-valid" method="put" enctype="multipart/form-data">--}}
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="mb-3 form-group @error('file') has-danger @enderror ">
                                                <div class="dropzone" id="videoDropzone">
                                                    <div class="dz-message" data-dz-message>
                                                        <span>Drop your video file here or click to upload.</span>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="file" id="videoFile" required value="{{ old('file', $video->file) }}">
                                            </div>
                                            @error('file')
                                            <div class="pristine-error text-help">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="row mt-2">--}}
{{--                                    <div class=" col-md-4">--}}
{{--                                        @php($lbl_category_name = __('system.crud.title'))--}}
{{--                                        <div class="mb-3 form-group @error('video_title') has-danger @enderror ">--}}
{{--                                            <label class="form-label" for="name">{{ $lbl_category_name }} <span class="text-danger">*</span></label>--}}
{{--                                            <input type="text" class="form-control" placeholder="{{$lbl_category_name}}" name="video_title" value="{{ old('title', $video->title) }}">--}}
{{--                                            @error('video_title')--}}
{{--                                            <div class="pristine-error text-help">{{ $message }}</div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-2">--}}
{{--                                    <div class=" col-md-4">--}}
{{--                                        @php($lbl_category_name = __('system.fields.food_description'))--}}
{{--                                        <div class="mb-3 form-group @error('video_description') has-danger @enderror ">--}}
{{--                                            <label class="form-label" for="name">{{ $lbl_category_name }} <span class="text-danger">*</span></label>--}}
{{--                                            <textarea class="form-control" name="video_description" placeholder="{{ $lbl_category_name }}">{{ old('description', $video->description) }}</textarea>--}}
{{--                                            @error('video_description')--}}
{{--                                            <div class="pristine-error text-help">{{ $message }}</div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                                        <a href="{{ route('restaurant.videos.index') }}"class="btn btn-secondary">{{ __('system.crud.cancel') }}</a>
                                    </div>
                                </div>

                            {{ Form::close() }}
                        </div>
                    </div>

                </div>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
@push('third_party_stylesheets')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css">
    <style>
        /* Add custom styling to the dropzone area */
        #videoDropzone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }
    </style>
@endpush
@push('third_party_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.js"></script>
    <script>
        // Add JS logic for handling file upload with Dropzone.js
        Dropzone.options.videoDropzone = {
            paramName: "file",
            maxFilesize: 1024,
            acceptedFiles: ".mp4,.wmv",
            url: "{{ route('restaurant.videos.update_video') }}",
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    formData.append("_token", "{{ csrf_token() }}"); // Manually add the CSRF token
                });
                this.on("success", function(file, response) {
                    // Set the hidden input value with the uploaded file name
                    document.getElementById("videoFile").value = response.data.upload_name;;
                });
            },
        };
        document.getElementById('pristine-valid').addEventListener('submit', function (event) {
            event.preventDefault();
            this.submit();
        });
    </script>
@endpush