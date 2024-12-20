<!DOCTYPE html>
<html>

<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8" />
    {{-- <meta name="viewport" content="width=device-width , initial-scale=1, shrink-to-fit=no" /> --}}
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="project" />
    <!-- Link style CSS -->
    <link rel="stylesheet" href="{{ asset('menu/css/index.css') }}" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="{{ asset('menu/css/swiper-bundle.min.css') }}" />

    <link rel="shortcut icon" href="{{ asset(config('app.favicon_icon')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    {{--    @include('menu.partials._style') --}}
    <div id="refreshed-style"></div>

    <style>
        .te_themeStart55 .te_tb_mo_slider_next_arrow,
        .te_themeStart55 .te_tb_mo_slider_pre_arrow {
            display: none !important;
        }

        .te_themeStart55 .te_tb_mo_slider_next_arrow,
        .te_themeStart55 .te_tb_mo_slider_pre_arrow {
            display: none !important;
        }

        .transition {
            transition: all 1s;
        }

        .transition.fading {
            opacity: 0;
        }

        .transition.fading1 {
            opacity: 1;
        }

        /* new */

        .clock-wrap {
            margin: 2% 0;
        }

        .expired {
            display: none;
            text-align: center;
            font-size: 2rem;
            padding: 1em;
        }

        .expired.show {
            display: block;
        }

        .clock {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .clock .time-block .time {
            background: #222;
            border-radius: 5px;
            color: #efefef;
            display: flex;
            flex-direction: column;
            width: 100px;
            text-align: center;
            margin: 10px;
        }

        .clock .time-block .label {
            color: black;
            margin: 0;
        }

        .clock .time-block .time {
            padding: 0.2em 0 0 0;
            font-size: 60px;
            font-family: "arb-fonts", sans-serif;
        }

        .countdown-container {
            font-family: Arial, sans-serif;
            text-align: center;
            flex: 2
        }

        .countdown-timer {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            display: inline-block;
        }

        .expired-message {
            font-size: 24px;
            font-weight: bold;
            color: #ff0000;
            margin-top: 20px;
        }

        .clock-wrap .time {
            position: relative;
            font-size: 60px;
            font-family: "arb-fonts", sans-serif;
            background: #222;
            border-radius: 5px;
            color: #efefef;
            display: flex;
            flex-direction: column;
            width: 100px;
            text-align: center;
            margin: 10px;
        }

        .clock-wrap .time::before,
        .clock-wrap .time::after {
            content: '';
            height: 50%;
            width: 100%;
            background: linear-gradient(to bottom, #bdb8b833, transparent);
            position: absolute;
            top: 0;
        }

        .clock-wrap .time::after {
            background: linear-gradient(to top, #bdb8b833, transparent);
            bottom: 0;
        }

        .image-container {
  position: relative;
  text-align: center;
  width: 25%
  /* display: inline-block; */
}

.social-media-description{
    width: 50%;
}

.it{
    margin: 3% 0px !important;
}

.imgs {
  position: relative;
  display: inline-block;
  width: 100%;
}

.social-media-icon {
  color: blue;
  width: 100% !important;
  display: inline-block;
  vertical-align: middle;
}

.profile-picture {
    position: absolute;
    top: 50.25%;
    left: 49.35%;
    transform: translate(-50%, -50%);
    padding: 1px;
    width: 86% !important;
    /* height: 86% !important; */
    object-fit: cover;
    border-radius: 100%;
    height: auto;
    /* max-height: 100%; */
    object-fit: cover;
}

.social-media-description {
  position: relative;
  z-index: 1;
  display: inline-block;
  vertical-align: middle;
}

body{
    max-width: 100% !important;
    overflow-x: hidden !important;
    max-height: 100vh;
    overflow-y: hidden;
}
    </style>

    <link rel="stylesheet" type="text/css" href="{{ asset('qc.slider.css') }}">
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery.js"></script> --}}

</head>

<body>
    <main style="">
        <input type="hidden" name="" id="is_vertical" value="{{$is_vertical}}">
        <input type="hidden" id="animation_timer" value="{{ $animation_timer }}">
        @if ($is_vertical == 1)
            @include('menu.vertical')
        @else
            @include('menu.horizontal')
        @endif
    </main>
    <script src="{{ asset('menu/js/script.js') }}"></script>
    <!-- Swiper JS -->
    <script src="{{ asset('menu/js/swiper-bundle.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Function to update the date and time
        function updateDateTime() {
            const now = new Date();
            const dateOptions = {
                weekday: 'short',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                localeMatcher: 'best fit',
                hour12: true,
            };

            // Get the date string in Arabic and remove the comma
            const arabicDate = now.toLocaleDateString('ar', dateOptions).replace('،', '');
            const formattedDateTime = `${arabicDate}`;
            document.getElementById('live_datetime').textContent = formattedDateTime;
        }

        // Update the date and time initially
        updateDateTime();

        // Update the date and time every second (1000 milliseconds)
        setInterval(updateDateTime, 1000);
    </script>
    <script>
        // Function to update the time
        function updateTime() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();
            const amOrPm = hours >= 12 ? '<span class="pm_am">PM</span>' : '<span class="pm_am">AM</span>';
            const hours12 = hours % 12 || 12;
            var hours_n = (hours12 < 10 ? '0' : '') + hours12;

            // Flash the dots in the time
            const dotsVisible = seconds % 2 === 0 ? 'visible' : 'hidden';

            const formattedTime =
                `${amOrPm} <span class="time"> <span class="hour">${hours_n}</span> <span class="dots" style="visibility:${dotsVisible}";>:</span> <span class="mintues">${(minutes < 10 ? '0' : '')}${minutes}</span> </span>`;
            document.getElementById('live_time').innerHTML = formattedTime;
        }

        // Update the time initially
        updateTime();
        setInterval(updateTime, 1000);
    </script>

    <script>
        $(document).ready(function() {
            var reloadInterval = 6 * 60 * 60 * 1000;

            setTimeout(function() {
                location.reload(true); // Reload the page, forcing a full reload from the server
            }, reloadInterval);
        });
    </script>

    <script type="text/javascript" src="{{ asset('qcslider.jquery.js?v1.4.3') }}"></script>
    {{-- <script type="text/javascript">
        $(document).ready(function($) {
            $("#slider").QCslider({
                duration: 7000,

            });
        });
    </script> --}}
    <script type="text/javascript">
    // create a public var
    var initialData = null;

    function loadVideoSlider() {
        $.ajax({
            url: "{{ route('loadVideoSlider') }}?uuid={{ $rest->uuid }}",
            type: 'GET',
            success: function (data) {
                console.log(initialData !== data);
                if (initialData === null) {
                    // Store the initial data
                    initialData = data;
                    $('#ajax-video-slider-container').html(data);
                    $("#slider").QCslider({
                        duration: 7000,
                    });
                } else if (initialData !== data) {
                    // Update the view only if the data has changed
                    $('#ajax-video-slider-container').html(data);
                    $("#slider").QCslider({
                        duration: 7000,
                    });

                    // Update the initial data for subsequent comparisons
                    initialData = data;
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    $(document).ready(function ($) {
        loadVideoSlider(); // Initial load

        // Optionally, you can use setInterval to automatically update the slider content
        setInterval(function () {
            loadVideoSlider();
        }, 6 * 1000); // Refresh every 60 seconds (adjust as needed)
    });
    </script>

    <script>
        // var isLiteCode = document.querySelectorAll(".tagembed-socialwall");
        // isLiteCode.forEach(t => {
        //     if (t && t.getAttribute("view-url")) {
        //     } else if (t && !t.getAttribute("view-url")) {
        //         var i = function(t, e) {
        //         }(window, void 0);
        //         i.init();
        //     }
        // });
    </script>
    <script>
        var animation_time = $('#animation_timer').val();

        function fetchDynamicData() {
            $.ajax({
                url: "/get_dynamic_data",
                method: "GET",
                data: {
                    uuid: "{{ $rest->uuid }}"
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    var newAnimationTime = data.animation_timer;
                    animation_time = parseInt($('#animation_timer').val());
                    if (newAnimationTime !== animation_time) {
                        // reload page
                        console.log(newAnimationTime, animation_time);
                        // return false;
                        // location.reload();
                        $('#animation_timer').val(newAnimationTime);  // Update the displayed animation time if needed
                        updateAnimationInterval(newAnimationTime);
                    }

                    $(".logo img").attr("src", data.logo);
                    if (data.is_on_off == 1) {
                        html_menu = '<div class="left-side-title">' +
                            '<span>' + data.menu_title.en + '</span>' +
                            '<span>' + data.menu_title.ar + '</span>' +
                            '</div>'
                        $('.menushowhide').html(html_menu)
                    } else {
                        $('.menushowhide').html('')
                    }
                    $(".date p").text(data.date);
                    $("#time12").text(data.time.time12);
                    $("#timeHour").text(data.time.hour);
                    $("#timeMinute").text(data.time.minutes);

                    $(".logo-wasla img").attr("src", data.static_logo);

                    $(".cone-desc p:first-child").text(data.cone_desc.home_page_text);
                    $(".en_caption").text(data.cone_desc.en_caption);

                    if (data.cone_desc.instagram_url) {
                        if (data.cone_desc.social_media_icon == '{{asset('assets/images/insta.gif')}}') {
                            // var insta = '<img src="' + data.cone_desc.social_media_icon +
                            // '" style="color: blue; width:20%"> &nbsp; <p>' + data.cone_desc
                            // .social_media + '</p>'

                            // var insta = '<div style="position: relative; text-align: center;">' +
                            //                 '<img src="' + data.cone_desc.social_media_icon + '" style="color: blue; width:20%; display: inline-block; vertical-align: middle;">' +
                            //                 '<img src="' + data.profile_picture + '" style="color: blue; width:20%; display: inline-block; vertical-align: middle;">' +
                            //                 '<p style="position: relative; z-index: 1; display: inline-block; vertical-align: middle;">' + data.cone_desc.social_media + '</p>' +
                            //             '</div>';

                            var insta = '<div class="image-container">' +
                                '<div class="imgs">' +
                                    '<img src="' + data.cone_desc.social_media_icon + '" class="social-media-icon">' +
                                    '<img src="' + data.profile_picture + '" class="profile-picture">' +
                                '</div>' +
                                '</div>'+
                                '<p class="social-media-description">' + data.cone_desc.social_media + '</p>';


                        } else {
                            var insta = '<img src="' + data.cone_desc.social_media_icon +
                            '" width="25" height="25" style="color: blue"> &nbsp; <p>' + data.cone_desc
                            .social_media + '</p>'
                        }
                        $(".it").html(insta);
                    }
                    if (data.cone_desc.twitter_url) {
                        var twitter = '<a href="https://twitter.com/' + data.cone_desc.twitter_url +
                            '" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16"> <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/> </svg></a> <p>&nbsp; ' +
                            data.cone_desc.name + '</p>'
                        $(".it").html(twitter);
                    }

                    if (data.vertical_mode != $("#is_vertical").val()) {
                        // refresh page
                        location.reload();
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log("Error fetching dynamic data: " + textStatus);
                }
            });
        }

        fetchDynamicData();
        setInterval(fetchDynamicData, animation_time);
        // setInterval(fetchDynamicData, 30 * 1000);
    </script>
    <script>
        // var animation_time = {{ $animation_timer }};

        function fetchScriptData() {

            $.ajax({
                url: "/get_dynamic_data",
                method: "GET",
                data: {
                    uuid: "{{ $rest->uuid }}"
                },
                dataType: "json",
                success: function(data) {
                    if (data.script_code) {
                        $(".story-img").html(data.script_code);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log("Error fetching dynamic data: " + textStatus);
                }
            });
        }

        fetchScriptData();
        setInterval(fetchScriptData, 1860 * 1000);
    </script>
    <script>
        function fetchAndApplyStyles() {
            $.ajax({
                url: "/?store_id={{ $rest->id }}",
                method: "GET",
                dataType: "json",
                data: {
                    uuid: "{{ $rest->uuid }}"
                },
                success: function(data) {
                    var styleContent = `
                    :root {
                        --body_color1: #f0eabe;
                        --body_color2: #bfead7;
                        --primary-color: ${data.primary_color};
                        --background-color: ${data.background_color};
                        --frame-color: ${data.frame_color};
                        --primary_color: ${data.font_color};
                    }
                    main {
                        background: var(--background-color);
                    }
                    main .main_width_control>div
                        background: var(--frame-color) !important;
                    }
                    main .left-side .left-side-title {
                       background-color: var(--primary-color);
                    }

                    main .left-side .left-side-content .items .item .item-desc {
                        background-color: var(--primary-color);
                    }

                    main .center-side .cone-desc {
                        background-color: var(--primary-color);
                    }


                    main .right-side .time-elem {
                        background-color: var(--primary-color);
                    }

                    main .right-side .logo {
                        background-color: var(--primary-color);
                    }

                    .hide {
                        display: none;
                        transition: opacity 0.5s;
                        opacity: 0;
                    }

                    .show {
                        opacity: 1;
                        transition: opacity 0.5s;
                    }
                `;

                    $("#refreshed-style").html("<style>" + styleContent + "</style>");
                },
                error: function() {
                    console.log("Error fetching styles data.");
                }
            });
        }

        fetchAndApplyStyles();
        setInterval(fetchAndApplyStyles, 5000);
    </script>
    <script>
        let products = [];
        let rest = [];
        let currentIndex = 0;
        async function fetchProducts() {
            try {
                const response = await fetch("{{ url('get_foods_data') }}?uuid={{ $rest->uuid }}");

                if (!response.ok) {
                    throw new Error(`Failed to fetch products (${response.status}): ${response.statusText}`);
                }

                const data = await response.json();
                products = data.foods;
                rest = data.rest;
                updateUI();

            } catch (error) {
                console.error("Error fetching products:", error);
            }
        }

        function updateUI() {}
        fetchProducts();



        function animateBatch(startIndex, endIndex) {
            const itemsContainer = document.querySelector('.items');
            itemsContainer.innerHTML = '';

            for (let i = startIndex; i <= endIndex; i++) {
                const product = products[i];
                const animationClass = rest.animation;

                if (product) {
                    const {
                        name,
                        price,
                        food_image,
                        is_display
                    } = product;
                    const currencySymbol = '<span>{{ config('app.currency_symbol') }}</span>';
                    const imgSrc = food_image ? `{{ asset('storage') }}/${food_image}` : '';

                    const priceHTML = is_display === 1 && price ?
                        `<p class="price">${price} <span>${currencySymbol}</span></p>` : '';
                    const nameHTML = is_display === 1 && name ? `<p>${name}</p>` : '';

                    const itemHTML = `
                    <div class="item itemImgSwiper animate__animated animate__${animationClass}">
                        <div class="item-img wrapper swiper-wrapper">
                            ${food_image ? `<img src="${imgSrc}" alt="" class="slide swiper-slide" />` : ''}
                        </div>
                        ${priceHTML || nameHTML ? `
                                <div class="item-desc">
                                    ${priceHTML}
                                    ${nameHTML}
                                </div>
                            ` : ''}
                    </div>
                `;

                    itemsContainer.insertAdjacentHTML('beforeend', itemHTML);
                }
            }
        }



        function animateProducts() {
            const batchSize = 4;
            const endIndex = currentIndex + batchSize - 1;

            animateBatch(currentIndex, endIndex);

            currentIndex += batchSize;
            if (currentIndex >= products.length) {
                currentIndex = 0;
            }
        }

        fetchProducts();
        animateProducts();
        // animation_time = $('#animation_timer').val();
        // setInterval(() => {
        //     fetchProducts();
        //     animateProducts();
        // }, animation_time);

        var intervalId;  // Global variable to store the interval ID

        // function updateAnimationInterval(newAnimationTime) {
        //     clearInterval(intervalId);  // Clear the existing interval
        //     animation_time = newAnimationTime;  // Update the animation time

        //     intervalId = setInterval(() => {
        //         fetchProducts();
        //         animateProducts();
        //     }, animation_time);
        // }

        function updateAnimationInterval(newAnimationTime) {
            clearInterval(intervalId);  // Clear the existing interval
            animation_time = newAnimationTime;  // Update the animation time

            function update() {
                // fetchProducts();
                animateProducts();

                // Schedule the next execution
                intervalId = setTimeout(update, animation_time);
            }

            // Initial execution
            update();

            function update1() {
                fetchProducts();

                // Schedule the next execution
                intervalId = setTimeout(update1, 60 * 1000);
            }

            // Initial execution
            update1();
        }

        updateAnimationInterval(1000);


        // }, 5000);
    </script>


    <script>

        var video_count = 0;
        var videos = [];
        // var sequentialVideo;
        sequentialVideo = document.getElementById("sequential-video");


        async function fetchVideos1() {
            try {
                const response = await $.ajax({
                    url: "{{ url('get_video_urls') }}?uuid={{ $rest->uuid }}",
                    type: "get",
                    data: {},
                });
                videodata = response;
                // base_url = 'storage/';
                // var videoUrls = videodata.map(video => video.file);

                videodata.forEach((video) => {
                    videos.push(`{{ asset('storage/${video.file}') }}`);
                });

            } catch (error) {
                console.error("Error fetching videos1:", error);
            }
        }

        fetchVideos1();

        function playNextVideo() {

            if (video_count < videos.length) {
                sequentialVideo.src = videos[video_count];
                sequentialVideo.play();
            } else {
                // All videos have played, reset and play first video
                video_count = 0;
                sequentialVideo.src = videos[video_count];
                sequentialVideo.play();
            }

        }

        sequentialVideo.addEventListener("ended", function() {
            video_count++;
            playNextVideo();
        });

        function refreshVideo() {
            setInterval(function() {
                sequentialVideo.load();
                playNextVideo();

                video_count++;

                sequentialVideo.classList.remove('fading');
                setTimeout(() => {
                    sequentialVideo.classList.add('fading');
                }, (9 * 1000));

            }, 30 * 1000);
            // 25000
        }

        refreshVideo();

        function tttttt() {
            setInterval(function() {
                fetchVideos1();
            }, 20000);
        }
        tttttt();
    </script>



    <script>
        var timeHour = document.getElementById("timeHour");
        var timeMinute = document.getElementById("timeMinute");
        var time12 = document.getElementById("time12");
        var timeSpace = document.getElementById("timeSpace");

        function refreshTime() {
            timeHour.innerHTML = moment().format("hh");
            timeMinute.innerHTML = moment().format("mm");
            time12 = moment().format("A")
            if (timeSpace.style.visibility === "hidden") {
                timeSpace.style.visibility = "visible";
            } else {
                timeSpace.style.visibility = "hidden";
            }
        }
        setInterval(refreshTime, 700);
        let items = document.querySelectorAll(
            "main .left-side .left-side-content .items .item"
        );

        function hideAll() {
            for (let i = 0; i < items.length; i++) {
                items[i].classList.add("hide");
            }
        }

        let count = 0;
        setInterval(() => {
            if (count * 4 >= items.length) {
                count = 0
            }
            if (count === 0) {
                hideAll();
                for (let i = 0; i < 4; i++) {
                    items[i].classList.remove("hide");
                }
                count = 1;
                return;
            }
            if (count === 1) {
                hideAll();
                if (items.length < 8) {
                    for (let i = 4; i < items.length; i++) {
                        items[i].classList.remove("hide");
                    }
                    count = 0;
                    return;
                } else {
                    // show count item
                    for (let i = 4; i < 8; i++) {
                        items[i].classList.remove("hide");
                    }
                    count = 2;
                    return;
                }
            }
            if (count === 2) {
                hideAll();
                if (items.length < 12) {
                    // show count item
                    for (let i = 8; i < items.length; i++) {
                        items[i].classList.remove("hide");
                    }
                    count = 0;
                    return;
                } else {
                    // show count item
                    for (let i = 8; i < 12; i++) {
                        items[i].classList.remove("hide");
                    }
                    count = 3;
                    return;
                }
            }
            if (count === 3) {
                hideAll();
                if (items.length < 16) {
                    // show count item
                    for (let i = 12; i < items.length; i++) {
                        items[i].classList.remove("hide");
                    }
                    count = 0;
                    return;
                } else {
                    // show count item
                    for (let i = 12; i < 16; i++) {
                        items[i].classList.remove("hide");
                    }
                    count = 4;
                    return;
                }
            }
            if (count === 4) {
                hideAll();
                if (items.length < 20) {
                    // show count item
                    for (let i = 16; i < items.length; i++) {
                        items[i].classList.remove("hide");
                    }
                    count = 0;
                    return;
                } else {
                    // show count item
                    for (let i = 16; i < 20; i++) {
                        items[i].classList.remove("hide");
                    }
                    count = 5;
                    return;
                }
            }
            if (count === 5) {
                hideAll();
                if (items.length < 24) {
                    // show count item
                    for (let i = 20; i < items.length; i++) {
                        items[i].classList.remove("hide");
                    }
                    count = 0;
                    return;
                } else {
                    // show count item
                    for (let i = 20; i < 24; i++) {
                        items[i].classList.remove("hide");
                    }
                    count = 6;
                    return;
                }
            }
        }, 5000);

        var swiper = new Swiper(".itemImgSwiper", {
            slidesPerView: 1,
            loop: true,
            spaceBetween: 0,
            effect: "fade",
            autoplay: {
                delay: 2000,
                disableOnInteraction: true,
            },
        });
        document.getElementById('sequential-video').play();
    </script>

    @include('custom_js')

</body>

</html>
