<div class="main_width_control w-100" style="display: flex;
height: 100% !important;
flex-direction: column;">

    <style>
        body {
            height: 100vh !important;
            overflow: hidden !important;
            /* display: flex !important;
            flex-direction: column !important; */

        }

        .main_width_control{
            max-width: 100% !important;
        }

        main {
            /* padding: 5px 0.5rem !important; */
            padding: 1vh 2.5vw !important;
            height: 100% !important;
            /* flex: 1 !important;
            display: flex !important;
            flex-direction: column !important; */
            /* background: none !important; */
        }

        main .right-side .logo,
        .main .right-side .logo,
        main .left-side .left-side-content .items .item,
        main .right-side .video-container video,
        main .center-side .cone-desc,
        main .right-side .time-elem,
        main .center-side .story-img,
        .main_width_control {
            border-radius: 1.5vw !important;
        }

        main .right-side {
            grid-gap: 0rem !important;
        }

        .video-container {
            margin-top: 0px !important;
        }

        .countdown-container {
            width: 100%;
            margin: 0 auto;
        }

        /* main .left-side .left-side-content .items .item {
            width: calc(50%) !important;
            height: calc(50%) !important;
            margin-bottom: 4px !important;
            display: flex !important;
            flex-wrap: wrap !important;
            flex-direction: column !important;
            overflow: hidden !important;

        } */

        .items {
            display: flex !important;
            flex-wrap: wrap !important;
        }

        .item {
            flex: 1 0 calc(50% - 10px) !important;
            /* Adjust the width and margin as needed */
            margin-right: 10px !important;
            /* Adjust the desired gap between items */
            margin-bottom: 0px !important;
            width: calc(50% - 10px) !important;
            height: calc(50% - 10px) !important;
            /* Optional: Add margin-bottom for vertical spacing */
        }

        /* Clear the margin-right for the last item in each row */
        .item:nth-child(2n) {
            margin-right: 0 !important;
        }

        .left-side .left-side-content .items .item:nth-child(4),
        .left-side .left-side-content .items .item:nth-child(3) {
            margin-bottom: 0px !important;
        }

        main .center-side {
            /* width: 22%; */
            /* display: flex;
            flex-direction: column; */
            flex-wrap: nowrap;
        }

        main .center-side .cone-desc {
            height: 200px !important;
        }

        main .left-side .left-side-content {
            height: 100% !important;
        }

        /* @media (max-width: 1700px){ */
        main .main_width_control>div {
            padding: 7px !important;
            height: auto !important;
            margin: 5px 0 !important;
            width: 100% !important;
        }

        /* } */

        #countdown #tiles span {
            font: 600 35px 'Droid Sans', Arial, sans-serif !important;
            padding: 10px 0 !important;
        }

        main .right-side .time-elem .date #live_datetime {
            font-size: 6vw !important;
            font-size: 5vw;
            line-height: 9vw;
        }

        #countdown #tiles .label {
            margin-top: 5px !important;
            font: normal 10px 'Droid Sans', Arial, sans-serif !important;
        }

        .flip-clock-wrapper ul {
            position: relative;
            float: left;
            margin: 5px;
            width: 9vw !important;
            height: 90px;
            font-size: 80px;
            font-weight: bold;
            line-height: 87px;
            border-radius: 6px;
            background: #000;
        }

        .flip-clock-divider .flip-clock-label {
            position: absolute;
            top: 6.2em !important;
            right: -14vw !important;
            color: black;
            font-size: 18px;
            line-height: 2px;
            text-shadow: none;
        }

        .en_caption,
        .it p {
            font-size: 2vw !important;
            font-family: 'DG' !important;
        }

        main .center-side .cone-desc div>p:nth-of-type(1) {
            font-size: 3vw !important;
        }

        .social-media-description {
            font-size: 2vw !important;
        }

        .image-container {
            position: relative;
            text-align: center;
            width: 17% !important;
                /* display: inline-block; */
        }

        main .right-side .time-elem .date #live_time span.pm_am{
            font-size: 7vw !important;
            line-height: 9vw !important;
            width: auto !important;
            /* padding-right: 0 !important; */
        }
        main .right-side .time-elem .date #live_time span.time {
            font-size: 7vw !important;
            line-height: 9vw !important;
            width: auto !important;
        }

        span.time span{
            font-size: 7vw !important;
        }

        main .main_width_control>div {
            background: none !important;
        }

        .main_width_control {
            background: var(--frame-color) !important;
            border-radius: 5px;
            /* flex: 1 !important; */
            max-height: 100vh !important;
        }

        /* #live_time{
            font-size: 9vw !important;
        } */

        /* .flip-clock-divider.minutes .flip-clock-label{
            right: -14vw !important;
        }

        .flip-clock-divider.seconds .flip-clock-label {
            right: -14vw !important;
        } */
    </style>
    <!-- start left-side -->

    <!-- start right-side -->
    <div class="right-side w-100"
        style="margin: 0px 0px !important; height:14vh !important; display:flex; flex-direction:row; padding-bottom:0 !important">
        <div class="logo" id="the_logo">
            <img src="" alt="" style="max-width: 100%" />
        </div>

        <div class="countdown-container" id="countdown" style="height: 33%; display:flex;">
            {{-- <div class="countdown-timer" id="demo101"></div>
            <div class="expired-message" id="demo"></div> --}}
            <div class="clock2 w-100"></div>



            {{-- <div id="countdown" style="margin: auto">
                <div id='tiles' style="display: flex">
                    <div style="display: flex; flex-direction:column" class="main">
                        <span id="days"></span>
                        <div class="label">Days</div>
                    </div>
                    <div style="display: flex; flex-direction:column" class="main">
                        <span id="hours"></span>
                        <div class="label">Hours</div>
                    </div>
                    <div style="display: flex; flex-direction:column" class="main">
                        <span id="minutes"></span>
                        <div class="label">Minutes</div>
                    </div>
                    <div style="display: flex; flex-direction:column" class="main">
                        <span id="seconds"></span>
                        <div class="label">Seconds</div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="clock-wrap">
                <p class="expired" id="expired"><strong>Countdown expired!</strong></p>

                <div class="clock" id="clock">
                    <div class="time-block">
                        <span class="time" id="days">00</span>
                        <p class="label">Days</p>
                    </div>
                    <div class="time-block">
                        <span class="time" id="hours">00</span>
                        <p class="label">Hours</p>
                    </div>
                    <div class="time-block">
                        <span class="time" id="minutes">00</span>
                        <p class="label">Minutes</p>
                    </div>
                    <div class="time-block">
                        <span class="time" id="seconds">00</span>
                        <p class="label">Seconds</p>
                    </div>
                </div>
            </div> --}}
        </div>


    </div>
    <!-- end right-side -->

    <style>
        .#tagembed_main,
        .te_themeStart57 {
            height: auto !important;
        }
    </style>

    <div class="w-100 d-flex"
        style="flex-direction: row; max-height: 45vh; margin:0px !important; padding:1px 7px !important; gap:10px; padding-top:10px !important">
        <div class="center-side w-100" style="width: 40% !important; height: calc(100% - 10px) !important;">
            <div class="story-img w-100" style="flex: none; margin-bottom:10px !important; height: 34vh;">
            </div>
            <div class="cone-desc w-100" style="margin-top:0 !important">
                <div>
                    <p></p>
                    <p class="en_caption"></p>
                    <hr />
                    <p class="it">

                    </p>
                </div>
            </div>
        </div>

        <div class="left-side" style="width: 60% !important">
            <div class="menushowhide">
                <span></span>
                <span></span>
            </div>
            <div class="left-side-content">
                <div class="items">

                </div>
            </div>
        </div>
    </div>

    <div class="right-side w-100" style="margin: 0px 0px !important; height:25vh !important; padding-top: 0px !important; padding-bottom: 10px !important">
        <div class="video-container" id="ajax-video-slider-container" style="height: auto">
        </div>
    </div>

    <div class="right-side w-100"
        style="padding-top: 0px !important; padding-bottom: 7px !important; margin: 0px !important; height:15vh !important; max-height:15vh; overflow:hidden">
        <div class="time-elem" style="height: auto !important">
            <div class="date">
                <div class="date_width_control">
                    <div class="live_date_and_time">
                        <div id="live_datetime"></div>
                        <div id="live_time"></div>
                    </div>
                </div>
            </div>

            <div class="logo-wasla">
                <img style="width: 100%" src="" alt="" />
            </div>
        </div>
    </div>
</div>
