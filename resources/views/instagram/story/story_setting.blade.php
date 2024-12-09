@extends('layouts.app')
@section('title', __('system.foods.create.menu'))
@section('content')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<style>
.story_image{
    height: 300px;
    border-radius: 50px;
}

    </style>
    <div class="row">
        <div class="col-md-6 col-sm-12">
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

                                   <select class="form-control" id="animation_type" onchange="change_animation_type()" name="animation_type">
                                    <option {{$restaurant->animation_type=='slide-in-right'?'selected':''}} value="slide-in-right">Slide-In-Right</option>
                                    <option {{$restaurant->animation_type=='fade-in'?'selected':''}} value="fade-in">Fad-In</option>
                                   </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="price-id">
                                <div class="mb-3 form-group @error('price') has-danger @enderror">
                                    @php($lbl_food_price = __('system.fields.number_posts'))
                                    <label class="form-label" for="price-mask">{{ $lbl_food_price }} <span class="text-danger"></span></label>
                                    <input id="number_posts" name="number_posts" class="form-control" value="{{$restaurant->number_posts}}">
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
        <div class="col-md-3 col-sm-12">
           <div class="story_image">
            @include('instagram.story.slider')
           </div>
        </div>
    </div>
    </div>
    <script>
        $("#number_posts").on("keyup",function(){
            get_slider()
        })
        function change_animation_type()
        {
            get_slider()
            $(".fade_in_dev").removeClass("carousel-fade")
            if($("#animation_type").val()=="fade-in")
        {
            $(".fade_in_dev").addClass("carousel-fade")
        }

        }
        setTimeout(() => {
            updateDurationValue($("#animation_duration_input").val())
        }, 500);
        function updateDurationValue(value) {
    //         var newInterval = value*1000; // Example: 7 seconds
    // $('#carouselExampleIndicators').attr('data-interval', newInterval);
    // $('#carouselExampleIndicators').carousel({ interval: newInterval }).carousel('cycle');
            document.getElementById('animation_duration_div').innerText = value;
        }
        function get_slider()
        {
            $.ajax({
                    url: '/instagram/slider?'+'animation_type='+$("#animation_type").val()+'&animation_duration='+$("#animation_duration_input").val()+'&number_of_posts='+$("#number_posts").val(), // The endpoint to fetch the HTML
                    method: 'GET',           // Use GET to fetch data
                    success: function (response) {
                        // Inject the received HTML into a specific element
                        $('.story_image').html(response);
                        $('#carouselExampleIndicators').carousel('cycle');
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching slider:', error);
                        alert('Failed to load the slider. Please try again.');
                    }
                });
        }
    </script>
@endsection

