@extends('layouts.app')
@section('title', __('system.foods.create.menu'))
@section('content')
    <div class="col-xl-12 col-sm-12">
        <div class="card">
            <div class="card-header">

                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <h4 class="card-title">{{ __('system.instagram_story.menu') }}</h4>
                        <div class="page-title-box pb-0 d-sm-flex">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ url('environment/instagram-story') }}">{{ __('system.instagram_story.menu') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('system.fields.story_settings') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @php
                    $uniqe = createQniqueSessionAndDestoryOld('unique');
                @endphp

                <form autocomplete="off" novalidate="" action="{{ url('instagram/story-setting') }}" id="pristine-valid" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="folder" value="{{ $uniqe }}">
                    <div class="row" >
                        <div class="col-md-6" id="price-id">
                            <div class="mb-3 form-group @error('price') has-danger @enderror">
                                @php($lbl_food_price = __('system.fields.animation_type'))
                                <label class="form-label" for="price-mask">{{ $lbl_food_price }} <span class="text-danger"></span></label>

                               <select class="form-control" name="animation_type">
                                <option {{$restaurant->animation_type=='slide-in-right'?'selected':''}} value="slide-in-right">Slide-In-Right</option>
                                <option {{$restaurant->animation_type=='fade-in'?'selected':''}} value="fade-in">Fad-In</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="price-id">
                            <div class="mb-3 form-group @error('price') has-danger @enderror">
                                @php($lbl_food_price = __('system.fields.number_posts'))
                                <label class="form-label" for="price-mask">{{ $lbl_food_price }} <span class="text-danger"></span></label>
                                <input name="number_posts" class="form-control" value="{{$restaurant->number_posts}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" id="price-id">
                            <div class="mb-3 form-group @error('price') has-danger @enderror">
                                @php($lbl_food_price = __('system.fields.animation_duration'))
                                <label class="form-label" for="price-mask">{{ $lbl_food_price }} <span class="text-danger"></span></label>

                    <input type="range" id="animation_duration_input" oninput="updateDurationValue(this.value)" name="animation_duration" class="form-range" id="customRange" min="1" max="10" value="{{$restaurant->animation_duration}}">
                    <small id="animation_duration_div">10</small>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12 mt-3">
                            <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                            {{-- <a href="{{ route('restaurant.products.index') }}"class="btn btn-secondary">{{ __('system.crud.cancel') }}</a> --}}
                        </div>
                    </div>
                </form>
            </div>
            <!-- end card -->
        </div>
    </div>
    </div>
    <script>
        setTimeout(() => {
            updateDurationValue($("#animation_duration_input").val())
        }, 500);
        function updateDurationValue(value) {
            document.getElementById('animation_duration_div').innerText = value;
        }
    </script>
@endsection

