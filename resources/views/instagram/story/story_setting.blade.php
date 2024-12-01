@extends('layouts.app')
@section('title', __('system.foods.create.menu'))
@section('content')
    <div class="col-xl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <h4 class="card-title">{{ __('system.fields.story_settings') }}</h4>

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

                    <input type="range" name="animation_duration" class="form-range" id="customRange" min="1" max="10" value="{{$restaurant->animation_duration}}">
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
@endsection

