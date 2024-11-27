@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.instagram_story.menu'))
@section('content')
<div class="row">

    <div class="col-xl-12 col-sm-12">
        <div class="card">
            <div class="card-header">

                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <h4 class="card-title">{{ __('system.instagram_story.menu') }}</h4>
                        <div class="page-title-box pb-0 d-sm-flex">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('system.instagram_story.menu') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">

                    </div>
                </div>
            </div>
            <?php

     $fb_user=json_decode($row->fb_user,true);
?>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mt-1 mb-5">
                        <a href="{{route('restaurant.instagram.login')}}" class="btn btn-sm btn-primary instagram-button ">
                            <img src="{{asset('assets/icons/instagram.png')}}" style="width:20px;margin-right:10px">
                            @if(empty($row->instagram_token))Sign in with instagram @else Reconnect instagram {{$fb_user['name']}} @endif</a>
                    </div>
                </div>

            </div>
            <!-- end card -->
        </div>
    </div>
</div>
@endsection
@push('third_party_stylesheets')
<style>
.instagram-button {
  background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  font-size: 12px;
  cursor: pointer;
  text-transform: uppercase;
  font-weight: bold;
  transition: 0.3s;
  width: 240px;
  background-size: 200% 200%;  /* for smooth hover effect */
  display: flex;
  justify-content: center; /* horizontally centers */
  align-items: center;     /* vertically centers */
  /* height: 100vh;   */
}

.instagram-button:hover {
  background-position: right center; /* makes gradient shift on hover */
}

</style>
@push('third_party_scripts')
<script>

</script>


@endpush
@endpush
