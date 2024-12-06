@extends('layouts.app')
@section('title', __('system.foods.create.menu'))
@section('content')
<div class="row">
    <div class="col-12 mt-1 mb-5">
     @include('instagram.story.index',['stories',$stories])
    </div>
</div>
@endsection

