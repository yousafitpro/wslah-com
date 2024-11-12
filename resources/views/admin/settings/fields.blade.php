
<div class="row">
    <div class="col-md-4 form-group">
        @php($lbl_app_dark_logo = __('system.fields.logo'))
        <label class="form-label d-block" for="app_name">{{ $lbl_app_dark_logo }} <span class="text-danger">*</span></label>
        <div class="d-flex align-items-center ">
            <div class='mx-3 '>
                <img data-src="{{ asset(config('app.dark_sm_logo')) }}" alt="" class=" preview-image lazyload" style="max-width:100%;">

            </div>

            <input type="file" name="app_dark_logo" id="app_dark_logo" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_app_dark_logo)]) }}"
                data-preview='.preview-image'>
            <label for="app_dark_logo" class="mb-0">
                <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                    {{ $lbl_app_dark_logo }}
                </div>
            </label>

        </div>
        @error('app_dark_logo')
            <div class="pristine-error text-help px-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        @php($lbl_app_light_logo = __('system.fields.app_dark_logo'))
        <label class="form-label d-block" for="app_name">{{ $lbl_app_light_logo }}</label>
        <div class="d-flex align-items-center ">
            <div class='mx-3 '>
                <img src="{{ asset(config('app.ligth_sm_logo')) }}" class=" preview-image_2 lazyload" style="max-width:100%;">


            </div>
            <input type="file" name="app_light_logo" id="app_light_logo" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_app_light_logo)]) }}"
                data-preview='.preview-image_2'>
            <label for="app_light_logo" class="mb-0">
                <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                    {{ __('system.crud.select') }} {{ $lbl_app_light_logo }}
                </div>
            </label>

        </div>
        @error('app_light_logo')
            <div class="pristine-error text-help px-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        @php($lbl_app_favicon_logo = __('system.fields.app_favicon_logo'))
        <label class="form-label d-block" for="app_name">{{ $lbl_app_favicon_logo }} <span class="text-danger">*</span></label>
        <div class="d-flex align-items-center ">
            <div class='mx-3 '>
                <img data-src="{{ asset(config('app.favicon_icon')) }}" alt="" class="avatar-xl  preview-image_21 lazyload">


            </div>
            <input type="file" name="app_favicon_logo" id="app_favicon_logo" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_app_favicon_logo)]) }}"
                data-preview='.preview-image_21'>
            <label for="app_favicon_logo" class="mb-0">
                <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                    {{ $lbl_app_favicon_logo }}
                </div>
            </label>

        </div>
        @error('app_favicon_logo')
            <div class="pristine-error text-help px-3">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2 mt-5">
        <div class="row">
            <div class="col-mb-6">
                @php($lbl_is_coming_soon = __('Coming soon mode'))
                <div class="mt-4 mt-md-0">
                    <label class="form-label" for="is_coming_soon">{{ $lbl_is_coming_soon }}</label>
                    <div class="form-check form-switch form-switch-md mb-3">
                        <input type="hidden" name="is_coming_soon" value="0">
                        <input class="form-check-input" id="is_coming_soon" name="is_coming_soon" type="checkbox" value="1" {{ $setting->is_coming_soon == 1 ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 mt-5 row" id="comingSoonDateTimeFields" style="{{ $setting->is_coming_soon != 1 ? 'display: none;' : '' }}">
        <div class="mb-3 col-md-4 form-group">
            <label class="form-label" for="input-coming_soon_date">Coming Soon Date<span class="text-danger"></span></label>
            {!! Form::date('coming_soon_date', $setting->coming_soon_date, [
                'class' => 'form-control',
                'id' => 'input-coming_soon_date',
            ]) !!}
        </div>

        <div class="mb-3 col-md-4 form-group">
            <label class="form-label" for="input-coming_soon_time">Coming Soon Time<span class="text-danger"></span></label>
            {!! Form::time('coming_soon_time', $setting->coming_soon_time, [
                'class' => 'form-control',
                'id' => 'input-coming_soon_time',
            ]) !!}
        </div>

        {{-- select a store --}}
        {{-- select field --}}
        <div class="mb-3 col-md-4 form-group">
            <label class="form-label" for="input-store">Select Store<span class="text-danger"></span></label>
            <select class="form-select" id="input-store" name="store_id">
                @foreach ($stores as $store_id => $store_name)
                    <option value="{{ $store_id }}" {{ $setting->store_id == $store_id ? 'selected' : '' }}>{{ $store_name }}</option>
                @endforeach
            </select>
        </div>


    </div>

{{--    <div class="row mt-4">--}}
{{--        <div class="col-md-4">--}}
{{--            @php($intro_video_url = __('system.fields.intro_video_url'))--}}

{{--            <div class="mb-3 form-group @error('intro_video_url') has-danger @enderror">--}}
{{--                <label class="form-label" for="input-intro_video_url">{{ $intro_video_url }} <span--}}
{{--                            class="text-danger">*</span></label>--}}
{{--                {!! Form::text('intro_video_url', config('app.intro_video_url'), [--}}
{{--                    'class' => 'form-control',--}}
{{--                    'id' => 'input-intro_video_url',--}}
{{--                    'required' => 'true',--}}
{{--                ]) !!}--}}

{{--                @error('intro_video_url')--}}
{{--                <div class="pristine-error text-help">{{ $message }}</div>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

</div>
