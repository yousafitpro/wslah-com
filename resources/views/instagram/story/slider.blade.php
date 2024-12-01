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
  </style>
<div id="carouselExampleIndicators" class="carousel slide {{$rest->animation_type=="fade-in"?'carousel-fade':''}}" data-ride="carousel" data-interval="{{(int)$rest->animation_duration*1000}}">

    <div class="carousel-inner">

      @foreach (instagram_stories_for_store() as $item)
      <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
         @if($item->payload['media_type']=="IMAGE")

          <a><img src="{{$item->payload['media_url']}}" class="d-block w-100 {{$rest->animation_type=="fade-in"?'fade-in':''}}"  alt="{{$item->id}} slide"></a>
          @elseif ($item->payload['media_type']=="VIDEO")
          @if(isset($item->payload['media_url']))

          <video class="d-block w-100 {{$rest->animation_type=="fade-in"?'fade-in':''}}" autoplay  loop controls>
            <source src="{{ $item->payload['media_url'] }}" type="video/mp4">
            Your browser does not support the video tag.
          </video>
          @elseif(isset($item->payload['thumbnail_url']))
          <a><img src="{{$item->payload['thumbnail_url']}}" class="d-block w-100 {{$rest->animation_type=="fade-in"?'fade-in':''}}"  alt="{{$item->id}} slide"></a>
          @endif
          @else
          @endif
        </div>
      @endforeach

    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
