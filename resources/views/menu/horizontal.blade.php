<div class="main_width_control">

    <!-- start left-side -->
    <div class="left-side">
        <div class="menushowhide">
            <span></span>
            <span></span>
        </div>
        <div class="left-side-content">
            <div class="items">

            </div>
        </div>
    </div>
    <div class="center-side" style="height: 100%">
        <div class="story-img" style="height: 75% !important">
            @include('instagram.story.slider')
        </div>
        <div class="cone-desc" style="height: 24% !important; margin-top:auto">
            <div>
                <p></p>
                <p class="en_caption"></p>
                <hr />
                <p class="it">

                </p>
            </div>
        </div>
    </div>

    <!-- start right-side -->
    <div class="right-side">
        <div class="logo" id="the_logo" style="height: 33%">
            <img src="" alt="" />
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

        {{-- <div class="video-container" style="height: 45%"> --}}



        <div class="time-elem" style="height: 25%">
            <div class="date" style="
        ">
                <div class="date_width_control">
                    <div class="live_date_and_time">
                        <div id="live_datetime" class="text-center" style="display: block"></div>
                        <div id="live_time"></div>
                    </div>
                </div>
            </div>

            <div class="logo-wasla">
                <img style="width: 100%" src="" alt="" />
            </div>
        </div>
    </div>
    <!-- end right-side -->
</div>
