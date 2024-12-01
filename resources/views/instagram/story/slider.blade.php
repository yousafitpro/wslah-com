<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

    <div class="carousel-inner">

      @foreach (instagram_stories_for_store() as $item)
      <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
         @if($item->payload['media_type']=="IMAGE")
          <a><img src="{{$item->payload['media_url']}}" class="d-block w-100"  alt="{{$item->id}} slide"></a>
          @elseif ($item->payload['media_type']=="VIDEO")
          @if(isset($item->payload['media_url']))
          <video class="d-block w-100" autoplay muted loop controls>
            <source src="{{ $item->payload['media_url'] }}" type="video/mp4">
            Your browser does not support the video tag.
          </video>
          @elseif(isset($item->payload['thumbnail_url']))
          <a><img src="{{$item->payload['thumbnail_url']}}" class="d-block w-100"  alt="{{$item->id}} slide"></a>
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
