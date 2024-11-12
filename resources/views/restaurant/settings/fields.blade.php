<div class="row">

    <div class="col-md-12">
        @php($lbl_restaurant_logo = __('system.fields.restaurant_logo'))
        <div class="mb-3 form-group">
            <label class="form-label d-block" for="app_name">{{ $lbl_restaurant_logo }} <span class="text-danger">*</span></label>
            <div class="d-flex align-items-center">
                <div class='mx-3 ' style="width: 150px">
                    <img data-src="{{ asset($row->logo) }}" alt="" class=" preview-image lazyload" style="max-width:100%;">
                </div>

                <input type="file" name="restaurant_logo" id="restaurant_logo" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_restaurant_logo)]) }}" data-preview='.preview-image'>
                <label for="restaurant_logo" class="mb-0">
                    <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                        {{ $lbl_restaurant_logo }}
                    </div>
                </label>
            </div>
            @error('restaurant_logo')
            <div class="pristine-error text-help px-3">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        @php($lbl_restaurant_name = __('system.fields.restaurant_name'))
        <div class="mb-3 form-group @error('restaurant_name') has-danger @enderror">
            <label class="form-label" for="input-restaurant_name">{{ $lbl_restaurant_name }} <span class="text-danger">*</span></label>
            {!! Form::text('restaurant_name', $row->name, [
            'class' => 'form-control',
            'id' => 'input-restaurant_name',
            'required' => 'true',
            ]) !!}

            @error('restaurant_name')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4">
        <div class="row">
            <div class="col-mb-6">
                @php($lbl_is_on_off = __('system.fields.is_on_off'))
                <div class="mt-4 mt-md-0">
                    <label class="form-label" for="is_on_off">{{ $lbl_is_on_off }}</label>
                    <div class="form-check form-switch form-switch-md mb-3">
                        <input type="hidden" name="is_on_off" value="0">
                        <input class="form-check-input " id="is_on_off" placeholder="On/Off Menu" name="is_on_off" type="checkbox" value="1" {{ $row->is_on_off==1? 'checked':'' }}>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 is_title">
        <div class="mb-3 form-group @error('menu_title_en') has-danger @enderror">
            <label class="form-label" for="input-menu_title_en">Menu Title (EN)<span class="text-danger"></span></label>
            {!! Form::text('menu_title_en', $row->menu_title_en, [
            'class' => 'form-control',
            'id' => 'input-menu_title_en',
            'maxlength'=> 15
            ]) !!}
            <div class="error-max" style="display: none"></div>

            @error('menu_title_en')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4 is_title">
        <div class="mb-3 form-group @error('menu_title_ar') has-danger @enderror">
            <label class="form-label" for="input-menu_title_ar">Menu Title (AR) <span class="text-danger"></span></label>
            {!! Form::text('menu_title_ar', $row->menu_title_ar, [
            'class' => 'form-control',
            'id' => 'input-menu_title_ar',
            'maxlength'=> 15
            ]) !!}
            <div class="error-max" style="display: none"></div>
            @error('menu_title_ar')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-3">
        @php($lbl_theme = __('system.fields.theme'))
        <div class="mb-3 form-group @error('theme') has-danger @enderror">
            <label class="form-label" for="input-theme">{{ $lbl_theme }} <span class="text-danger">*</span></label>
            {!! Form::color('theme', $row->theme, [
            'class' => 'form-control',
            'id' => 'input-theme',
            'required' => 'true',
            ]) !!}

            @error('theme')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        @php($lbl_theme = __('system.fields.frame'))
        <div class="mb-3 form-group @error('frame') has-danger @enderror">
            <label class="form-label" for="input-theme">{{ $lbl_theme }} <span class="text-danger">*</span></label>
            {!! Form::color('frame', $row->frame_color, [
            'class' => 'form-control',
            'id' => 'input-theme',
            'required' => 'true',
            ]) !!}
            @error('frame')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        @php($lbl_theme = __('system.fields.background'))
        <div class="mb-3 form-group @error('background') has-danger @enderror">
            <label class="form-label" for="input-theme">{{ $lbl_theme }} <span class="text-danger">*</span></label>
            {!! Form::color('background', $row->background_color, [
            'class' => 'form-control',
            'id' => 'input-theme',
            'required' => 'true',
            ]) !!}
            @error('background')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- <div class="col-md-3">
        @php($lbl_icon_color = __('system.fields.icon_color'))
        <div class="mb-3 form-group @error('background') has-danger @enderror">
            <label class="form-label" for="input-theme">{{ $lbl_icon_color }} </label>
            {!! Form::color('icon_color', $row->icon_color, [
            'class' => 'form-control',
            'id' => 'input-theme',
            'required' => 'true',
            ]) !!}
            @error('icon_color')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div> -->

    <div class="col-md-3">
        @php($lbl_font_color = __('system.fields.font_color'))
        <div class="mb-3 form-group @error('frame') has-danger @enderror">
            <label class="form-label" for="input-theme">{{ $lbl_font_color }} </label>
            {!! Form::color('font_color', $row->font_color, [
            'class' => 'form-control',
            'id' => 'input-theme',

            ]) !!}
            @error('font_color')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>

</div>
{{-- <div class="row mt-5 mb-1">
    <div class="col-md-4">
        <div class="mb-3 form-group ">
            <label class="form-label" for="input-theme">Wslah Logo <span class="text-danger">*</span></label>
        </div>
    </div>
    <div class="col-md-12 d-flex justify-content-between" style="gap: 15px;">
        <div class="logo-option">
            <label for="logo1"><img src="{{asset('assets/images/wslah_white.png')}}" alt="Logo 1" width="75px" height="75px" style="background: #000;"></label>
            <label>White Logo</label>
            <input type="radio" id="logo1" {{ $row->static_logo == asset('assets/images/wslah_white.png') ? 'checked' :''}} name="static_logo" value="{{asset('assets/images/wslah_white.png')}}">
        </div>
        <div class="logo-option">
            <label for="logo2"><img src="{{asset('assets/images/wslah_colored.png')}}" alt="Logo 2" width="75px" height="75px"></label>
            <label>Colored Logo</label>
            <input type="radio" id="logo2" {{ $row->static_logo == asset('assets/images/wslah_colored.png') ? 'checked' :''}} name="static_logo" value="{{asset('assets/images/wslah_colored.png')}}">
        </div>
        <div class="logo-option">
            <label for="logo3"><img src="{{asset('assets/images/wslah_black.png')}}" alt="Logo 3" width="75px" height="75px"></label>
            <label>Black Logo</label>
            <input type="radio" id="logo3" name="static_logo" value="{{asset('assets/images/wslah_black.png')}}" {{ $row->static_logo == asset('assets/images/wslah_black.png') ? 'checked' :''}}>
        </div>
    </div>
</div> --}}

<div class="row mt-5 mb-1">
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label class="form-label" for="input-theme">Wslah Logo <span class="text-danger">*</span></label>
        </div>
    </div>
    <div class="col-lg-12 row">
        <div class="d-flex justify-content-between col-lg-6">
            <div class="logo-option d-flex row col-lg-12" style="flex-direction: row">
                <div class="col-lg-6 my-auto">
                    <label>Select Logo</label>
                    <select id="logoSelect" name="static_logo" class="form-select" data-sel="{{$row->static_logo}}">
                        <option value="{{ asset('assets/images/wslah_white.png') }}" {{ $row->static_logo == asset('assets/images/wslah_white.png') ? 'selected' : '' }}>White Logo</option>
                        <option value="{{ asset('assets/images/wslah_colored.png') }}" {{ $row->static_logo == asset('assets/images/wslah_colored.png') ? 'selected' : '' }}>Colored Logo</option>
                        <option value="{{ asset('assets/images/wslah_black.png') }}" {{ $row->static_logo == asset('assets/images/wslah_black.png') ? 'selected' : '' }}>Black Logo</option>
                    </select>
                </div>
                <div class="col-lg-6 my-auto d-flex">
                    <label class="mx-auto" for="logoSelect">
                        <img id="selectedLogo" class="p-3" src="{{ asset('assets/images/wslah_white.png') }}" alt="Selected Logo" width="150px" height="150px" style="background: {{$row->static_logo == asset('assets/images/wslah_white.png') ? '#000' : ''}};">
                    </label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between col-lg-6">
            <div class="col-lg-12 d-flex justify-content-between" style="gap: 15px;">
                <div class="logo-option d-flex row col-lg-12" style="flex-direction: row">
                    <div class="col-lg-6 my-auto">
                        <div>
                            <label>Select Social Media Icon</label>
                            <select id="socialMediaSelect" name="social_media_icon" class="form-select">
                                <option value="{{asset('assets/images/Instagram_white.png')}}" {{ $row->social_media_icon == asset('assets/images/Instagram_white.png') ? 'selected' : '' }}>Instagram - White</option>
                                <option value="{{asset('assets/images/Instagram_black.png')}}" {{ $row->social_media_icon == asset('assets/images/Instagram_black.png') ? 'selected' : '' }}>Instagram - Black</option>
                                <option value="{{asset('assets/images/x_white.png')}}" {{ $row->social_media_icon == asset('assets/images/x_white.png') ? 'selected' : '' }}>Twitter (X) - White</option>
                                <option value="{{asset('assets/images/x_black.png')}}" {{ $row->social_media_icon == asset('assets/images/x_black.png') ? 'selected' : '' }}>Twitter (X) - Black</option>
                                <option value="{{asset('assets/images/insta.gif')}}" {{ $row->social_media_icon == asset('assets/images/insta.gif') ? 'selected' : '' }}>Instagram - Story</option>
                            </select>
                        </div>
                        <style>
                            /* Style for the image preview */
                            .preview-image {
                              max-width: 100%;
                              height: auto;
                              margin-top: 10px;
                            }
                          </style>
                        {{-- for insta --}}
                        <div id="insta-profile" class="mt-2" style="display: none">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_restaurant_logo)]) }}">
                            <!-- Image preview container -->
                            <div id="insta-preview-image" class="preview-image" style="display: none;"></div>
                          </div>

                    </div>
                    <div class="col-lg-6 my-auto d-flex">
                        <label class="mx-auto" for="socialMediaSelect">
                            <img id="selectedSocialMediaIcon" class="p-3" src="{{ $row->social_media_icon }}" alt="Selected Social Media Icon" width="150px" height="150px" style="background: {{ $row->social_media_icon == asset('assets/images/Instagram_white.png') ? '#000' : '' }};">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="row mt-4">
    <div class="col-md-12">

        {{-- <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between" style="gap: 15px;">
                <div class="logo-option">
                    <label style="padding: 5px; background-color: black;"><img src="{{asset('assets/images/Instagram_white.png')}}" alt="Logo 1" width="75px" height="75px"></label>
                    <label>Instagram - White</label>
                    <input type="radio" id="logo1" {{ $row->social_media_icon == asset('assets/images/Instagram_white.png') ? 'checked' :''}} name="social_media_icon" value="{{asset('assets/images/Instagram_white.png')}}">
                </div>
                <div class="logo-option">
                    <label style="padding: 5px;"><img src="{{asset('assets/images/Instagram_black.png')}}" alt="Logo 1" width="75px" height="75px"></label>
                    <label>Instagram - Black</label>
                    <input type="radio" id="logo1" {{ $row->social_media_icon == asset('assets/images/Instagram_black.png') ? 'checked' :''}} name="social_media_icon" value="{{asset('assets/images/Instagram_black.png')}}">
                </div>
                <div class="logo-option">
                    <label style=" padding: 5px; background-color: black;"><img src="{{asset('assets/images/x_white.png')}}" alt="Logo 2" width="75px" height="75px"></label>
                    <label>Twitter (X) - White</label>
                    <input type="radio" id="logo2" {{ $row->social_media_icon == asset('assets/images/x_white.png') ? 'checked' :''}} name="social_media_icon" value="{{asset('assets/images/x_white.png')}}">
                </div>
                <div class="logo-option">
                    <label style="padding: 5px;"><img src="{{asset('assets/images/x_black.png')}}" alt="Logo 2" width="75px" height="75px"></label>
                    <label>Twitter (X) - Black</label>
                    <input type="radio" id="logo2" {{ $row->social_media_icon == asset('assets/images/x_black.png') ? 'checked' :''}} name="social_media_icon" value="{{asset('assets/images/x_black.png')}}">
                </div>
            </div>
        </div> --}}


        <div class="row">
            <div class="col-md-12">
                @php($lbl_instagram_url = __('system.fields.instagram_url'))

                <div class="form-group @error('instagram_url') has-danger @enderror">
                    <label class="form-label" for="input-instagram_url">{{ $lbl_instagram_url }} <span class="text-danger"></span></label>
                    {!! Form::text('instagram_url', $row->instagram_url, [
                    'class' => 'form-control',
                    'id' => 'input-instagram_url',
                    'required' => false,
                    ]) !!}

                    @error('instagram_url')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-md-12">
                <!-- Display the profile picture -->
                <img id="profile-picture" src="{{ $row->profile_picture_url }}" alt="Profile Picture" width="150px" height="150px">
            </div>
        </div> --}}

{{--    <div class="col-md-6">--}}
{{--        @php($lbl_twitter_url = __('system.fields.twitter_url'))--}}

{{--        <div class="mb-3 form-group @error('twitter_url') has-danger @enderror">--}}
{{--            <label class="form-label" for="input-twitter_url">{{ $lbl_twitter_url }} <span class="text-danger"></span></label>--}}
{{--            {!! Form::text('twitter_url', $row->twitter_url, [--}}
{{--            'class' => 'form-control',--}}
{{--            'id' => 'input-instagram_url',--}}
{{--            'required' => false,--}}
{{--            ]) !!}--}}

{{--            @error('twitter_url')--}}
{{--            <div class="pristine-error text-help">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}








    {{-- <div class="col-md-4">--}}
    {{-- <div class="mb-3 form-group  @error('categories') has-danger @enderror   ">--}}
    {{-- @php($lbl_social_media = __('system.fields.social_media'))--}}
    {{-- <label class="form-label" for="input-language">{{ $lbl_social_media }} <span class="text-danger">*</span></label>--}}
    {{-- @php($categories = ['Twitter','Instagram'])--}}

    {{-- {!! Form::select('social_media[]', $categories, old('social_media', $row->social_media ?? []), [--}}
    {{-- 'class' => 'form-control choice-picker-multiple w-100 ',--}}
    {{-- 'id' => 'choices-multiple-remove-button',--}}
    {{-- 'data-id' => 'choices-multiple-remove-button-ref',--}}

    {{-- 'placeholder' => $lbl_social_media,--}}
    {{-- 'data-remove' => 'false',--}}
    {{-- ]) !!}--}}
    {{-- @error('social_media')--}}
    {{-- <div class="pristine-error text-help">{{ $message }}
</div>--}}
{{-- @enderror--}}

{{-- </div>--}}
{{-- </div>--}}

</div>


{{--<div class="row mt-4">--}}
{{-- <div class="col-md-4">--}}
{{-- @php($intro_video_url = __('system.fields.intro_video_url'))--}}

{{-- <div class="mb-3 form-group @error('intro_video_url') has-danger @enderror">--}}
{{-- <label class="form-label" for="input-intro_video_url">{{ $intro_video_url }} <span class="text-danger"></span></label>--}}

{{-- <!-- Change the input type to file and add multiple and accept attributes -->--}}
{{-- {!! Form::file('intro_video_url[]', [--}}
{{-- 'class' => 'form-control',--}}
{{-- 'id' => 'input-intro_video_url',--}}
{{-- 'required' => 'true',--}}
{{-- 'multiple' => 'true',--}}
{{-- 'accept' => 'video/*',--}}

{{-- ]) !!}--}}

{{-- @error('intro_video_url')--}}
{{-- <div class="pristine-error text-help">{{ $message }}</div>--}}
{{-- @enderror--}}
{{-- </div>--}}
{{-- </div>--}}
{{--</div>--}}


{{--<div class="row mt-4">--}}
{{-- <div class="col-md-4">--}}
{{-- @php($lbl_script_code = __('system.fields.script_code'))--}}

{{-- <div class="mb-3 form-group @error('script_code') has-danger @enderror">--}}
{{-- <label class="form-label" for="input-script_code">{{ $lbl_script_code }} <span--}} {{--                        class="text-danger"></span></label>--}} {{--            {!! Form::textArea('script_code', $row->script_code, [--}} {{--                'class' => 'form-control',--}} {{--                'id' => 'input-code',--}} {{--                'required' => false,--}} {{--            ]) !!}--}} {{--            @error('script_code')--}} {{--            <div class="pristine-error text-help">{{ $message }}</div>--}}
    {{-- @enderror--}}
    {{-- </div>--}}
    {{-- </div>--}}
    {{--</div>--}}
    <div class="row mt-4">
        {{-- @php($animation_timer = ['1 sec','2 secs','3 secs','4 secs','5 secs','10 secs','15 secs','20 secs','25 secs','30 secs']) --}}
        @php($time = $row->animation_timer)
        <div class="col-md-6">
            <div class="mb-3 form-group  @error('animation_timer') has-danger @enderror">
                @php($lbl_animation_timer = __('system.fields.animation_timer'))
                <label class="form-label" for="input-language">{{ $lbl_animation_timer }} (in seconds) <span class="text-danger">*</span></label>
                @php($timeArray = explode(' ', $time))
                @php($numericTime = isset($timeArray[0]) ? intval($timeArray[0]) : 0)

                <input type="number" class="form-control" name="animation_timer" value="{{$numericTime}}" min="1">
                {{-- <select class="form-control" name="animation_timer">
                    @foreach($animation_timer as $timing)
                        <option type="{{$timing}}" {{ $time === $timing ? 'selected' : '' }}>{{$timing}}</option>
                    @endforeach
                </select> --}}
                @error('animation')
                <div class="pristine-error text-help">{{ $message }}</div>
                @enderror

            </div>
        </div>
        {{-- @php($categories = [
    'bounce', 'flash', 'pulse', 'rubberBand', 'shakeX', 'shakeY', 'headShake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat',
    'backInDown', 'backInLeft', 'backInRight', 'backInUp',
    'backOutDown', 'backOutLeft', 'backOutRight', 'backOutUp',
    'bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp',
    'bounceOut', 'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp',
    'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'fadeInTopLeft', 'fadeInTopRight', 'fadeInBottomLeft', 'fadeInBottomRight',
    'fadeOut', 'fadeOutDown', 'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig', 'fadeOutUp', 'fadeOutUpBig', 'fadeOutTopLeft', 'fadeOutTopRight', 'fadeOutBottomRight', 'fadeOutBottomLeft',
    'flip', 'flipInX', 'flipInY', 'flipOutX', 'flipOutY',
    'lightSpeedInRight', 'lightSpeedInLeft', 'lightSpeedOutRight', 'lightSpeedOutLeft',
    'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight',
    'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight',
    'hinge', 'jackInTheBox', 'rollIn', 'rollOut',
    'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp',
    'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp',
    'slideInDown', 'slideInLeft', 'slideInRight', 'slideInUp',
    'slideOutDown', 'slideOutLeft', 'slideOutRight', 'slideOutUp'
    ]) --}}

    @php($categories = [
    'bounce', 'flash', 'pulse', 'rubberBand', 'shakeX', 'shakeY', 'headShake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat',
    'backInDown', 'backInLeft', 'backInRight', 'backInUp',
    'bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp',
    'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'fadeInTopLeft', 'fadeInTopRight', 'fadeInBottomLeft', 'fadeInBottomRight',
    'flip', 'flipInX', 'flipInY',
    'rotateIn', 'rotateInDownLeft', 'rotateInUpLeft', 'rotateInUpRight',
    'jackInTheBox', 'rollIn',
    'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp',
    'slideInDown', 'slideInLeft', 'slideInRight', 'slideInUp'
])

        @php($selectedValue = $row->animation)
        <div class="col-md-6">
            <div class="mb-3 form-group  @error('categories') has-danger @enderror   ">
                @php($lbl_animation = __('system.fields.animation'))
                <label class="form-label" for="input-language">{{ $lbl_animation }} <span class="text-danger">*</span></label>
                <select class="form-control" name="animation">
                    @foreach($categories as $cate)
                        <option type="{{$cate}}" {{ $selectedValue === $cate ? 'selected' : '' }}>{{$cate}}</option>
                    @endforeach
                </select>
                @error('animation')
                <div class="pristine-error text-help">{{ $message }}</div>
                @enderror

            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-6">
        @php($lbl_script_code = __('system.fields.add_text'))

        <div class="mb-3 form-group @error('home_page_text') has-danger @enderror">
            <label class="form-label" for="input-script_code">{{ $lbl_script_code }} <span class="text-danger"></span></label>
            {!! Form::text('home_page_text', $row->home_page_text, [
            'class' => 'form-control',
            'id' => 'input-code',
            'maxlength'=> 26,
            'required' => true,
            ]) !!}

            <div class="error-max" style="display: none"></div>
            @error('home_page_text')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        @php($lbl_caption_en = __('system.fields.caption_en'))

        <div class="mb-3 form-group @error('home_page_text') has-danger @enderror">
            <label class="form-label" for="input-caption_en">{{ $lbl_caption_en }} <span class="text-danger"></span></label>
            {!! Form::text('caption_en', $row->caption_en, [
            'class' => 'form-control',
            'id' => 'input-code',
            'maxlength'=> 26

            ]) !!}
            <div class="error-max" style="display: none"></div>
            @error('caption_en')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>

</div>
</div>

{{-- <div class="col-md-4 mt-2">
    <div class="row">
        <div class="col-mb-6">
            @php($vertical_mode = __('Vertical Mode'))
            <div class="mt-4 mt-md-0">
                <label class="form-label" for="vertical_mode">{{ $vertical_mode }}</label>
                <div class="form-check form-switch form-switch-md mb-3">
                    <input type="hidden" name="vertical_mode" value="0">
                    <input class="form-check-input" id="vertical_mode" name="vertical_mode" type="checkbox" value="1" {{ $row->vertical_mode ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="col-md-4 mt-2">
    <div class="row">
        <div class="col-md-12">
            @php($vertical_mode = __('Vertical Mode'))
            @php($horizontal_mode = __('Horizontal Mode'))
            <label class="form-label">{{ __('Select Mode') }}</label>
            <div class="mt-4 mt-md-0">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="vertical_mode" id="vertical_mode" value="1" {{ $row->vertical_mode ? 'checked' : '' }}>
                    <label class="form-check-label" for="vertical_mode">{{ $vertical_mode }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="vertical_mode" id="horizontal_mode" value="0" {{ !$row->vertical_mode ? 'checked' : '' }}>
                    <label class="form-check-label" for="horizontal_mode">{{ $horizontal_mode }}</label>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <div class="col-md-4 mt-2">
    <div class="row">
        <div class="col-mb-6">
            @php($lbl_is_coming_soon = __('Coming soon mode'))
            <div class="mt-4 mt-md-0">
                <label class="form-label" for="is_coming_soon">{{ $lbl_is_coming_soon }}</label>
                <div class="form-check form-switch form-switch-md mb-3">
                    <input type="hidden" name="is_coming_soon" value="0">
                    <input class="form-check-input" id="is_coming_soon" name="is_coming_soon" type="checkbox" value="1" {{ $row->is_coming_soon == 1 ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4" id="comingSoonDateTimeFields" style="{{ $row->is_coming_soon != 1 ? 'display: none;' : '' }}">
    <div class="mb-3 form-group">
        <label class="form-label" for="input-coming_soon_date">Coming Soon Date<span class="text-danger"></span></label>
        {!! Form::date('coming_soon_date', $row->coming_soon_date, [
            'class' => 'form-control',
            'id' => 'input-coming_soon_date',
        ]) !!}
    </div>

    <div class="mb-3 form-group">
        <label class="form-label" for="input-coming_soon_time">Coming Soon Time<span class="text-danger"></span></label>
        {!! Form::time('coming_soon_time', $row->coming_soon_time, [
            'class' => 'form-control',
            'id' => 'input-coming_soon_time',
        ]) !!}
    </div>
</div> --}}


<!-- <div class="row">
    <div class="col-md-6">
        <label>Limit Characters</label>
        <input type="number" class="form-control" name="limit_characters" placeholder="Enter the limit characters" value="{{$row->limit_characters}}">
    </div>
</div> -->
