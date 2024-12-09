<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    .fade-in {
      opacity: 0;                    /* Start invisible */
      animation: fadeIn 1.5s ease-in forwards;  /* Apply the fadeIn animation */
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }
    .carousel-fade .carousel-item {
 opacity: 0;
 transition-duration: .6s;
 transition-property: opacity;
}

.carousel-fade  .carousel-item.active,
.carousel-fade  .carousel-item-next.carousel-item-left,
.carousel-fade  .carousel-item-prev.carousel-item-right {
  opacity: 1;
}

.carousel-fade .active.carousel-item-left,
.carousel-fade  .active.carousel-item-right {
 opacity: 0;
}

.carousel-fade  .carousel-item-next,
.carousel-fade .carousel-item-prev,
.carousel-fade .carousel-item.active,
.carousel-fade .active.carousel-item-left,
.carousel-fade  .active.carousel-item-prev {
 transform: translateX(0);
 transform: translate3d(0, 0, 0);
}
.carousel-item{

    width: 97% !important;

}
.carousel_video{
    border-top-right-radius: 12px !important;
    border-bottom-right-radius: 12px !important;

}
  </style>
<div id="carouselExampleIndicators" class="carousel slide  fade_in_dev {{$rest->animation_type=="fade-in"?'carousel-fade':''}}" data-ride="carousel" data-interval="{{(int)$rest->animation_duration*1000}}">

    <div class="carousel-inner">
<?php
$number_of_posts = isset($number_of_posts) ? $number_of_posts : null;
?>
      @foreach (instagram_stories_for_store($number_of_posts) as $item)
      <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
         @if($item->payload['media_type']=="IMAGE")

          <a href="{{$item->payload['media_url']}}" target="_blank"><img src="{{$item->payload['media_url']}}" class="d-block w-100 {{$rest->animation_type=="fade-in"?'fade-in':''}}"  alt="{{$item->id}} slide"></a>
          @elseif ($item->payload['media_type']=="VIDEO")
          @if(isset($item->payload['media_url']))

          <a href="{{$item->payload['media_url']}}" target="_blank">
            <video class="d-block w-100 carousel_video fade_in_dev {{$rest->animation_type=="fade-in"?'fade-in':''}}"  autoplay muted  loop >
                <source src="{{ $item->payload['media_url'] }}" type="video/mp4">
                Your browser does not support the video tag.
              </video>
          </a>

          @elseif(isset($item->payload['thumbnail_url']))
          <a><img src="{{$item->payload['thumbnail_url']}}" class="d-block w-100 fade_in_dev {{$rest->animation_type=="fade-in"?'fade-in':''}}"  alt="{{$item->id}} slide"></a>
          @endif
          @else
          @endif
        </div>
      @endforeach

    </div>
    {{-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a> --}}
  </div>
