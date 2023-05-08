@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Upcube</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <style>
        .datetime {
            color: #fff;
            background: #4846f0;
            font-family: "Segoe UI", sans-serif;
            padding: 15px 10px;
            border: 3px solid #2E94E3;
            border-radius: 5px;
            /* -webkit-box-reflect: below 1px linear-gradient(transparent, rgba(255, 255, 255, 0.1)); */
            transition: 0.5s;
            transition-property: background, box-shadow;
            position: relative;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .datetime:hover {
            background: #2E94E3;
            box-shadow: 0 0 30px #2E94E3;
        }
        .date, .time span:not(:last-child) {
            font-weight: 600;
            text-align: center;
            letter-spacing: 3px;
        }
        .date {
            font-size: 20px;
            /* margin-bottom:20px; */
        }
        .time {
            font-size: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .time span:not(:last-child) {
            position: relative;
            margin: 0 6px;
        }
        .time span:last-child {
            background: #2E94E3;
            font-size: 30px;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 10px;
            padding: 0 5px;
            border-radius: 3px;
        }
        .timeInFormContainer {
            font-weight: 600;
            text-align: center;
            letter-spacing: 3px;
            margin-top:20px;
        }
        .formTimeIn {
            margin-top: 200px;
        }
        .custom-btn {
            font-size: 24px;
            font-weight: bold;
            height: 70px;
            margin: 10px 0;
        }
        .form-control {
            padding: 15px;
        }
        .timeInOutLogs textarea {
            pointer-events: none;
            resize: none;
            height:200px;
        }
    </style>

    <!--digital clock start-->
    <div class="row">
        <div class="col-12">
            <div class="datetime">
                <div class="date">
                    <span id="dayname">Day</span>,
                    <span id="month">Month</span>
                    <span id="daynum">00</span>,
                    <span id="year">Year</span>
                </div>
                <div class="time">
                    <span id="hour">00</span>:
                    <span id="minutes">00</span>:
                    <span id="seconds">00</span>
                    <span id="period">AM</span>
                </div>
                <div class="date">
                    <span>Philippines</span>
                </div>
                <div class="aux_container" style="display: flex; align-items: left;">
                    <p id="aux_duration" style="font-size:24px;font-weight:bold;margin-right: 8px;">Aux Duration: 0 second</p>
                    <i class="ri ri-information-fill" style="font-size: 1.5em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Aux Duration is the time of your short breaks accumulated within a day. Example: Taking restroom breaks."></i>
                </div>                
                <div class="timeInFormContainer">
                    <form class="form-control" id="timeInForm" action="{{ route('dashboard.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="button" class="btn btn-primary custom-btn w-100 mb-3" name="time_in" id="time_in" data-attribute="1" value="Time In" />
                                <input type="button" class="btn btn-secondary custom-btn w-100" name="time_out" id="time_out" data-attribute="2" value="Time Out" />
                            </div>
                            <div class="col-md-4">
                                <input type="button" class="btn btn-success custom-btn w-100 mb-3" name="break_out" id="break_out" data-attribute="3" value="Break Out" {{ $result ? '' : 'disabled' }} />
                                <input type="button" class="btn btn-secondary custom-btn w-100" name="break_in" id="break_in" data-attribute="4" value="Break In" {{ $result ? '' : 'disabled' }} />
                            </div>
                            <div class="col-md-4">
                                <input type="button" class="btn btn-warning custom-btn w-100 mb-3" name="aux_in" id="aux_in" data-attribute="5" value="Aux In" {{ $result ? '' : 'disabled' }} />
                                <input type="button" class="btn btn-secondary custom-btn w-100" name="aux_out" id="aux_out" data-attribute="6" value="Aux Out" {{ $result ? '' : 'disabled' }} />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Move here if not approved --}}
    </div>
    <!--digital clock end-->

    <!-- Time In/Out Logs -->
    <div class="row mt-4 mb-4 timeInOutLogs">
        <div class="col-12 text-center">
            {{-- <p style="background-color:yellow;text-align:center;">Hello</p> --}}
            <textarea class="form-control" name="attendance_logs" id="attendance_logs"></textarea>
        </div>
    </div>
    <!-- Time In/Out Logs end -->

</div>
<!-- end row -->
</div>

</div>

<script type="text/javascript">

    Number.prototype.pad = function(digits){
        for(var n = this.toString(); n.length < digits; n = '0' + n);
        return n;
    }

    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

    // Init Vars
    var time_in = $("#time_in");
    var time_out = $("#time_out");
    var break_out = $("#break_out");
    var break_in = $("#break_in");
    var aux_in = $("#aux_in");
    var aux_out = $("#aux_out");


    function updateClock(){
        var now = new Date();
        var localTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
        var dname = localTime.getDay(),
            mo = localTime.getMonth(),
            dnum = localTime.getDate(),
            yr = localTime.getFullYear(),
            hou = localTime.getHours(),
            min = localTime.getMinutes(),
            sec = localTime.getSeconds(),
            pe = "AM";
        if(hou >= 12){
            pe = "PM";
        }
        if(hou == 0){
            hou = 12;
        }
        if(hou > 12){
            hou = hou - 12;
        }
        var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
        var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
        for(var i = 0; i < ids.length; i++)
            document.getElementById(ids[i]).firstChild.nodeValue = values[i];
        return {
            dayName: week[dname],
            month: months[mo],
            dayNum: dnum.pad(2),
            year: yr,
            hour: hou.pad(2),
            minutes: min.pad(2),
            seconds: sec.pad(2),
            period: pe,
        };
    }
    function restoreClock() {
        var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
        for (var i = 0; i < ids.length; i++) {
            var value = localStorage.getItem(ids[i]);
            if (value !== null) {
                document.getElementById(ids[i]).firstChild.nodeValue = value;
            }
        }
    }
    function initClock(){
        restoreClock();
        updateClock();
        setInterval(updateClock, 1000);
    }
    // Call the initClock function immediately
    initClock();
    // Also call the initClock function when the window is loaded
    window.onload = initClock;

    function enableBreakOutButton() {
        document.getElementById("break_out").disabled = false;
    }
    function enableBreakInButton() {
        document.getElementById("break_in").disabled = false;
    }

    // Aux In / Out
    let auxTimerRunning = false;
    let seconds = 0;
    let auxInterval;


    function startAuxTimer() {
        if (!auxTimerRunning) {
            const startTime = new Date().getTime(); // Get the current time in milliseconds
            localStorage.setItem("auxStartTime", startTime); // Save the start time in localStorage
            auxTimerRunning = true;

            // Get the saved aux_duration from localStorage
            const auxDurationData = JSON.parse(localStorage.getItem("auxDuration"));
            if (auxDurationData) {
                seconds = auxDurationData.duration;
            }
        }
    }
    function stopAuxTimer() {
        if (auxTimerRunning) {
            // Save the current duration before stopping the timer
            const startTime = parseInt(localStorage.getItem("auxStartTime"));
            const now = new Date().getTime();
            auxDuration += Math.floor((now - startTime) / 1000);
            auxTimerRunning = false;
        }
    }

    // Save aux_duration to localStorage
    function saveAuxDuration() {
        let expirationDate = new Date();
        expirationDate.setDate(expirationDate.getDate() + (expirationDate.getHours() >= 22 ? 1 : 0)); // Set the expiration date to the same day if before 10 PM, otherwise the next day
        expirationDate.setHours(22, 0, 0, 0); // Set the expiration time to 10 PM
        const auxDurationData = {
            duration: seconds,
            expiration: expirationDate.getTime()
        };
        localStorage.setItem("auxDuration", JSON.stringify(auxDurationData));
    }
    // Load aux_duration from localStorage
    function loadAuxDuration() {
        const auxDurationData = JSON.parse(localStorage.getItem("auxDuration"));

        if (auxDurationData) {
            const now = new Date();
            const day = now.getDay();
            const isWeekday = day >= 1 && day <= 5; // Check if the current day is a weekday (Monday to Friday)

            if (isWeekday && now.getTime() < auxDurationData.expiration) {
                auxDuration = auxDurationData.duration;
                updateTimer();
            } else {
                // If the value has expired or it's not a weekday, remove it from localStorage
                localStorage.removeItem("auxDuration");
            }
        }
    }
    // Call this function when the page loads
    loadAuxDuration();    

    function updateTimer() {
        let hours = Math.floor(seconds / 3600);
        let minutes = Math.floor(seconds / 60);
        let remainingSeconds = seconds % 60;

        if (hours > 0) {
            document.getElementById("aux_duration").innerHTML = "Aux Duration: " + hours + " hours" + minutes + " minutes " + remainingSeconds + " seconds";
        } else if (minutes > 0) {
            document.getElementById("aux_duration").innerHTML = "Aux Duration: " + minutes + " minutes " + remainingSeconds + "  seconds";
        } else {
            document.getElementById("aux_duration").innerHTML = "Aux Duration: " + remainingSeconds + " seconds";
        }

        if (auxTimerRunning) {
            auxDuration++;
            saveAuxDuration();
        }
        saveAuxDuration();
    }
    function enableAuxInButton() {
        document.getElementById("aux_in").disabled = false;
    }
    function enableAuxOutButton() {
        document.getElementById("aux_out").disabled = false;
        stopAuxTimer(); // Stop the timer when the Aux Out button is enabled
    }

    // let accumulatedDuration = 0;
    let shouldRunTimer = false;
    // Load accumulatedDuration from localStorage
    let accumulatedDuration = parseInt(localStorage.getItem("accumulatedDuration")) || 0;

    function calculateDuration() {
        if (shouldRunTimer) { // Check if the timer should be running
            const startTime = localStorage.getItem("auxStartTime");
            if (startTime) {
                const now = new Date().getTime();
                seconds = Math.floor((now - startTime) / 1000) + accumulatedDuration;
                updateTimer();
            }
        }
    }

    setInterval(calculateDuration, 1000); // Update the duration every second

    function resetTimer() {
        seconds = 0;
        updateTimer();
    }
    function checkResetTime() {
        var now = new Date();
        var localTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
        const resetHour = 22; // 10 PM
        const currentHour = localTime.getHours();

        if (currentHour === resetHour && localTime.getMinutes() === 0 && localTime.getSeconds() === 0) {
            resetTimer();
        }
    }

    // Call checkResetTime every second
    setInterval(checkResetTime, 1000);

    function disableAuxInButton() {
        aux_in.attr("disabled", true);
    }

    function stopAuxTimer() {
        clearInterval(auxInterval);
    }

    function handleButtonClick(loginType, buttonId, auxDuration) {
        event.preventDefault();

        var loginTypeNames = {
            1: "Time In",
            2: "Time Out",
            3: "Break Out",
            4: "Break In",
            5: "Aux In",
            6: "Aux Out"
        };

        var dateData = updateClock();
        var data = {
            "_token": "{{ csrf_token() }}",
            loginType: loginType,
            auxDuration: auxDuration,
            dayName: dateData.dayName,
            month: dateData.month,
            dayNum: dateData.dayNum,
            year: dateData.year,
            hour: dateData.hour,
            minutes: dateData.minutes,
            seconds: dateData.seconds,
            period: dateData.period,
        };

        // Add the auxDuration to the data object if it's an Aux In or Aux Out event
        if (loginType === 5 || loginType === 6) {
            data.auxDuration = auxDuration;
        }
 
        var dateData = updateClock();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('dashboard.store') }}",
            type: "POST",
            data: data,
            beforeSend: function () {
                $('#' + buttonId).val('Please wait..');
                $('#' + buttonId).attr('disabled', true);
            },
            success: function (response) {
                // alert('Success');
                if(response.responseData !== "") {
                    alert(response.responseData);
                    // Enable the Other buttons button if a "Time In" event is successful
                    if (loginType === 1) {
                        document.getElementById("break_out").disabled = false;
                        document.getElementById("break_in").disabled = false;
                        document.getElementById("aux_in").disabled = false;
                        document.getElementById("aux_out").disabled = false;
                    }
                    // Enable the Other buttons if a "Time Out" event is successful
                    if (loginType === 2) {
                        document.getElementById("break_out").disabled = true;
                        document.getElementById("break_in").disabled = true;
                        document.getElementById("aux_in").disabled = true;
                        document.getElementById("aux_out").disabled = true;
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.status);
                console.log('Error: ' + textStatus + ' - ' + errorThrown);
            },
            complete: function () {
                $('#' + buttonId).removeAttr('disabled');
                $('#' + buttonId).val(loginTypeNames[loginType]);
            }
        });
    }

    // document.getElementById("aux_in").addEventListener("click", function() {
    //     const canStartTimer = true;
    //     if (canStartTimer) {
    //         enableAuxOutButton();
    //         enableAuxInButton(); // Save the Aux In record to the database
    //         // Add your server call to save the Aux In event here
    //         if (!auxTimerRunning) {
    //             enableAuxInButton(); // Start the timer when the Aux In button is clicked
    //             handleButtonClick(5, 'aux_in', auxDuration); // Add this line to handle the button click
    //         }
    //     }
    // });

    // document.getElementById("aux_out").addEventListener("click", function() {
    //     // if (auxTimerRunning) {
    //     //     enableAuxOutButton(); // Stop the timer when the Aux Out button is clicked
    //     //     handleButtonClick(6, 'aux_out', auxDuration); // Add this line to handle the button click
    //     // }
    //     enableAuxInButton();
    //     enableAuxOutButton(); // Save the Aux Out record to the database along with the timer duration
    //     // Add your server call to save the Aux Out event and duration here
    //     if (timerRunning) {
    //         clearInterval(timer);
    //         timerRunning = false;

    //         // Save the current duration before stopping the timer
    //         const startTime = localStorage.getItem("auxStartTime");
    //         const now = new Date().getTime();
    //         accumulatedDuration += Math.floor((now - startTime) / 1000);

    //         // Save accumulatedDuration to localStorage
    //         localStorage.setItem("accumulatedDuration", accumulatedDuration);

    //         // Save the Aux Out record to the database along with the timer duration
    //         // Add your server call to save the Aux Out event and duration here
    //         this.disabled = true;
    //         enableAuxInButton();
    //         shouldRunTimer = false;
    //     }
    // });



    // Time in
    time_in.click(function (event) {
        var loginType = $(this).data("attribute");
        handleButtonClick(loginType, 'time_in');
    });
    // Time Out
    time_out.click(function (event) {
        var loginType = $(this).data("attribute");
        handleButtonClick(loginType, 'time_out');
    });
    // Break Out
    break_out.click(function (event) {
        var loginType = $(this).data("attribute");
        handleButtonClick(loginType, 'break_out');
    });
    // Break In
    break_in.click(function (event) {
        var loginType = $(this).data("attribute");
        handleButtonClick(loginType, 'break_in');
    });
    // Aux In
    aux_in.click(function (event) {
        var loginType = $(this).data("attribute");
        handleButtonClick(loginType, 'aux_in', seconds);
        startAuxTimer(); // Add this line to start the timer when the Aux In button is clicked
        if (shouldRunTimer) {
            clearInterval(auxInterval); // Clear any existing interval
            auxInterval = setInterval(function () {
                seconds++; // <- Replace auxDuration with seconds 
                displayAuxTimer(seconds); // <- Replace auxDuration with seconds
            }, 1000);
        }
    });

    // Aux Out
    aux_out.click(function (event) {
        var logoutType = $(this).data("attribute");
        handleButtonClick(logoutType, 'aux_out', auxDuration);
        shouldRunTimer = false; // Add this line to set shouldRunTimer to false when the Aux Out button is clicked
        stopAuxTimer(); // Add this line to stop the timer when the Aux Out button is clicked
        disableAuxOutButton();
        enableAuxInButton();
    });


</script>

@endsection
