const updateDateTime = () => {
    const now = new Date();
    const dateOptions = {
        weekday: "short",
        day: "numeric",
        month: "long",
        year: "numeric",
        localeMatcher: "best fit",
        hour12: true,
    };

    const arabicDate = now
        .toLocaleDateString("ar", dateOptions)
        .replace("،", "");
    const formattedDateTime = `${arabicDate}`;
    const liveDateTimeElement = document.getElementById("live_datetime");

    if (liveDateTimeElement) {
        liveDateTimeElement.textContent = formattedDateTime;
    } else {
        console.error("live_datetime element not found.");
    }
};

// Function to update the time
const updateTime = () => {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();
    const amOrPm =
        hours >= 12
            ? '<span class="pm_am">PM</span>'
            : '<span class="pm_am">AM</span>';
    const hours12 = hours % 12 || 12;
    const hours_n = (hours12 < 10 ? "0" : "") + hours12;

    // Flash the dots in the time
    const dotsVisible = seconds % 2 === 0 ? "visible" : "hidden";

    const formattedTime = `${amOrPm} <span class="time"> <span class="hour">${hours_n}</span> <span class="dots" style="visibility:${dotsVisible}";>:</span> <span class="mintues">${
        minutes < 10 ? "0" : ""
    }${minutes}</span> </span>`;

    const liveTimeElement = document.getElementById("live_time");
    if (liveTimeElement) {
        liveTimeElement.innerHTML = formattedTime;
    } else {
        console.error("live_time element not found.");
    }
};

// Video Slider
let initialData = null;

async function loadVideoSlider() {
    try {
        const response = await fetch(
            `{{ route('loadVideoSlider') }}?uuid={{ $rest->uuid }}`
        );
        const data = await response.text();

        if (initialData === null || initialData !== data) {
            $("#ajax-video-slider-container").html(data);
            $("#slider").QCslider({
                duration: 7000,
            });

            initialData = data;
        }
    } catch (error) {
        console.error(error);
    }
}

let animationTime = $('#animation_timer').val();

async function fetchDynamicData() {
    try {
        const response = await fetch("/get_dynamic_data?uuid={{ $rest->uuid }}");
        const data = await response.json();

        const newAnimationTime = data.animation_timer;
        animationTime = parseInt($('#animation_timer').val());
        if (newAnimationTime !== animationTime) {
            $('#animation_timer').val(newAnimationTime);
            updateAnimationInterval(newAnimationTime);
        }

        $(".logo img").attr("src", data.logo);

        if (data.is_on_off == 1) {
            const htmlMenu = `<div class="left-side-title">
                                    <span>${data.menu_title.en}</span>
                                    <span>${data.menu_title.ar}</span>
                                </div>`;
            $('.menushowhide').html(htmlMenu);
        } else {
            $('.menushowhide').html('');
        }

        $(".date p").text(data.date);
        $("#time12").text(data.time.time12);
        $("#timeHour").text(data.time.hour);
        $("#timeMinute").text(data.time.minutes);
        $(".logo-wasla img").attr("src", data.static_logo);
        $(".cone-desc p:first-child").text(data.cone_desc.home_page_text);
        $(".en_caption").text(data.cone_desc.en_caption);

        if (data.cone_desc.instagram_url) {
            let insta;
            if (data.cone_desc.social_media_icon == '{{asset('assets/images/insta.gif')}}') {
                insta = `<div class="image-container">
                            <div class="imgs">
                                <img src="${data.cone_desc.social_media_icon}" class="social-media-icon">
                                <img src="${data.profile_picture}" class="profile-picture">
                            </div>
                        </div>
                        <p class="social-media-description">${data.cone_desc.social_media}</p>`;
            } else {
                insta = `<img src="${data.cone_desc.social_media_icon}" width="25" height="25" style="color: blue">
                        &nbsp;
                        <p>${data.cone_desc.social_media}</p>`;
            }
            $(".it").html(insta);
        }

        if (data.cone_desc.twitter_url) {
            const twitter = `<a href="https://twitter.com/${data.cone_desc.twitter_url}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                </svg>
                                <p>&nbsp; ${data.cone_desc.name}</p>
                            </a>`;
            $(".it").html(twitter);
        }

        if (data.vertical_mode != $("#is_vertical").val()) {
            location.reload();
        }
    } catch (error) {
        console.error("Error fetching dynamic data: ", error);
    }
}

async function fetchScriptData() {
    try {
        const response = await fetch("/get_dynamic_data?uuid={{ $rest->uuid }}");
        const data = await response.json();

        if (data.script_code) {
            $(".story-img").html(data.script_code);
        }
    } catch (error) {
        console.error("Error fetching dynamic data: ", error);
    }
}


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

    } catch (error) {
        console.error("Error fetching products:", error);
    }
}

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

let intervalId;

function updateAnimationInterval(newAnimationTime) {
    clearInterval(intervalId);
    animation_time = newAnimationTime;

    function animateAndScheduleUpdate(callback, interval) {
        callback();
        intervalId = setTimeout(() => animateAndScheduleUpdate(callback, interval), interval);
    }
    animateAndScheduleUpdate(animateProducts, animation_time);
    animateAndScheduleUpdate(fetchProducts, 60 * 1000);
}

async function fetchVideos() {
    try {
        const response = await $.ajax({
            url: "{{ url('get_video_urls') }}?uuid={{ $rest->uuid }}",
            type: "get",
            data: {},
        });
        videodata = response;
        console.log("video Data:",videodata);
        videodata.forEach((video) => {
            videos.push(`{{ asset('storage/${video.file}') }}`);
        });
    } catch (error) {
        console.error("Error fetching videos:", error);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    updateDateTime();
    setInterval(updateDateTime, 1000);

    updateTime();

    loadVideoSlider();
    setInterval(loadVideoSlider, 6 * 1000);

    fetchDynamicData();
    setInterval(fetchDynamicData, animationTime);


    fetchScriptData();
    setInterval(fetchScriptData, 1860 * 1000);

    fetchAndApplyStyles();
    setInterval(fetchAndApplyStyles, 5 * 10000);

    fetchProducts();
    setInterval(fetchProducts, 1860 * 1000);
    animateProducts();

    updateAnimationInterval(2 * 1000);
});
