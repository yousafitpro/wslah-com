<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.css'><link rel="stylesheet" href="{{asset('assets/style.css')}}">
<script src='https://momentjs.com/downloads/moment.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.js'></script>
{{-- <script  src="{{asset('assets/script.js')}}"></script> --}}

<script>
    $(document).ready(function() {
        // Variable to store the interval ID
        var intervalId;

        var countDownDate;

        var the_resturant_id = '{{ $rest->uuid }}';

        // Function to check coming soon status
        function checkComingSoon() {
            $.ajax({
                url: "{{ route('check_coming_soon') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data.is_admin) {
                        $('#countdown').hide();
                        return false;
                    }
                    // Clear the existing interval if it's running
                    if (intervalId) {
                        clearInterval(intervalId);
                    }

                    if (data.status) {
                        $('#the_logo').hide();
                        $('#countdown').show();
                        var currentUrl = window.location.href;

                        if (data.url !== currentUrl) {
                            window.location.href = data.url;
                        }


                        // Function to update countdown
                        function updateCountdown() {

                            var date = new Date(data.date.date);

                            if (countDownDate === new Date(date).getTime()) {
                                return false;
                            }

                            let clock;

                            countDownDate = new Date(date).getTime();

                            var now = new Date().getTime();
                            var distance = countDownDate - now;
                            diff = distance/1000;


                            if (diff <= 0) {
                            // If remaining countdown is 0
                            clock = (".clock2").FlipClock(0, {
                                clockFace: "DailyCounter",
                                countdown: true,
                                autostart: false
                            });
                            console.log("Date has already passed!")

                            } else {
                            // Run countdown timer
                            clock = $(".clock2").FlipClock(diff, {
                                clockFace: "DailyCounter",
                                countdown: true,
                                callbacks: {
                                stop: function() {
                                    console.log("Timer has ended!")
                                }
                                }
                            });

                            // Check when timer reaches 0, then stop at 0
                            setTimeout(function() {
                                checktime();
                            }, 1000);

                            function checktime() {
                                t = clock.getTime();
                                if (t <= 0) {
                                clock.setTime(0);
                                }
                                setTimeout(function() {
                                checktime();
                                }, 1000);
                            }
                            }

                            if (distance <= 0) {
                                clearInterval(intervalId);
                                data.status = false;
                                window.location.href = '{{ route('myrest') }}';
                            }
                        }

                        // Initial update
                        updateCountdown();

                        // Set interval to update countdown every second
                        intervalId = setInterval(updateCountdown, 5 * 1000);
                    } else {
                        // Show logo or handle other actions when not in coming soon mode
                        $('#the_logo').show();
                        $('#countdown').hide();
                        var currentUrl = window.location.href.trim().replace(/\/$/,
                        ''); // Remove trailing slash
                        var targetUrl = '{{ route('myrest') }}'.trim().replace(/\/$/,
                        ''); // Remove trailing slash

                        console.log(currentUrl, targetUrl);
                        if (currentUrl !== targetUrl) {
                            console.log('redirecting', currentUrl, targetUrl);
                            if (!data.is_admin) {
                                window.location.href = targetUrl;
                            }
                        }
                    }
                }
            });
        }

        // Initial check
        // checkComingSoon();

        // Periodically check every 5 minutes (adjust the interval as needed)
        setInterval(checkComingSoon, 5 * 1000);

        function addLeadingZeros(time) {
            return ('0' + time).slice(-2);
        }
    });
</script>

<style>

    .clock2{
        display: flex;
        margin: auto;
    }

    .flip-clock-wrapper ul{
        position: relative;
        float: left;
        margin: 5px;
        width: 4vw;
        height: 90px;
        font-size: 80px;
        font-weight: bold;
        line-height: 87px;
        border-radius: 6px;
        background: #000;
    }

    .flip-clock-dot {
        left: 0 !important;
        float: none !important
    }

    .flip-clock-label {
        /* display: none !important */
    }

    /* .flip-clock-divider{
        float: left;
        display: inline-block;
        position: relative;
        width: 53px;
        height: 100px;
    } */

    .flip-clock-wrapper {
    font: normal 11px "Helvetica Neue", Helvetica, sans-serif !important;
    -webkit-user-select: none;
    width: auto !important
}

.flip-clock-divider .flip-clock-label{
    position: absolute;
    top: 6em;
    right: -5vw;
    color: black;
    font-size: 18px;
    line-height: 2px;
    text-shadow: none;
}

/* .flip-clock-divider.minutes .flip-clock-label{
    right: -5vw !important;
}

.flip-clock-divider.seconds .flip-clock-label {
    right: -5vw !important;
} */

.inn{
    line-height: 100px;
}

    #countdown #tiles {
        position: relative;
        z-index: 1;
    }

    #countdown #tiles span {

        font: 600 4vw 'Droid Sans', Arial, sans-serif;
        text-align: center;
        color: #ffffff;
        background-color: #ffffff;
        background-image: -webkit-linear-gradient(top, #676767, #000000);
        background-image: -moz-linear-gradient(top, #676767, #000000);
        background-image: -ms-linear-gradient(top, #676767, #000000);
        background-image: -o-linear-gradient(top, #676767, #000000);
        /* border-top: 1px solid #fff; */
        border-radius: 6px;
        text-shadow: 0px 0px 5px rgba(0, 0, 0, 0.7);
        margin: 0 7px;
        padding: 20px;
        display: inline-block;
        position: relative;
    }

    #countdown #tiles .main {
        width: 100%;
    }

    #countdown #tiles span:after {
        content: "";
        width: 100%;
        height: 1px;
        background: #7d7d7dfc;
        border-top: 1px solid #4f4e4e;
        display: block;
        position: absolute;
        top: 48%;
        left: 0;
    }

    #countdown .labels {
        width: 100%;
        height: 25px;
        text-align: center;
    }

    #countdown #tiles .label {
        /* width: 25%; */
        margin-top: 10px;
        font: normal 15px 'Droid Sans', Arial, sans-serif;
        /* color: black; */
        /* text-shadow: 1px 1px 0px #000; */
        text-align: center;
        text-transform: uppercase;
        display: inline-block;
    }
</style>
