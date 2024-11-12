<div class="item @if($key > 3) hide @endif itemImgSwiper animate__animated animate__wobble">

    <div class="item-img wrapper swiper-wrapper">
        @if(!empty($product->food_image))
        <img src="{{ getFileUrl($product->food_image) }}" alt="" class="slide swiper-slide" />
        @endif
    </div>
    @if(!empty($product->price) || !empty($product->name))
    <div class="item-desc">
        <p class="price">{{ $product->price }} <span>{{config('app.currency_symbol')}}</span></p>
        <p>{{ $product->name }}</p>
    </div>
    @endif
</div>