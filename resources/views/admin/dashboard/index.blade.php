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
                <div class="timeInFormContainer">
                    <form method="POST" class="form-control" id="timeInForm" action="{{ route('dashboard.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="button" class="btn btn-primary custom-btn w-100 mb-3" name="time_in" id="time_in" data-attribute="" value="Time In" />
                                <input type="button" class="btn btn-secondary custom-btn w-100" name="time_out" id="time_out" data-attribute="" value="Time Out" />
                            </div>
                            <div class="col-md-6">
                                <input type="button" class="btn btn-success custom-btn w-100 mb-3" name="break_out" id="break_out" value="Break Out" />
                                <input type="button" class="btn btn-secondary custom-btn w-100" name="break_in" id="break_in" value="Break In" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Time In/Out Form -->
        {{-- <div class="datetime formTimeIn">
            <div class="col-12">
                <form method="POST" class="form-control">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="button" class="btn btn-primary custom-btn w-100 mb-3" name="time_in" id="time_in" value="Time in" />
                            <input type="button" class="btn btn-secondary custom-btn w-100" name="time_out" id="time_out" value="Time out" />
                        </div>
                        <div class="col-md-6">
                            <input type="button" class="btn btn-success custom-btn w-100 mb-3" name="break_out" id="break_out" value="Break Out" />
                            <input type="button" class="btn btn-secondary custom-btn w-100" name="break_in" id="break_in" value="Break In" />
                        </div>
                    </div>
                </form>
            </div>
        </div> --}}
        <!--Time In/Out end-->
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
        Number.prototype.pad = function(digits){
            for(var n = this.toString(); n.length < digits; n = 0 + n);
            return n;
        }
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
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
    // Init Vars
    var time_in = $("#time_in");
    var time_out = $("#time_out");
    var break_out = $("#break_out");
    var break_in = $("#break_in");
    function handleButtonClick(loginType, buttonId) {
        event.preventDefault();
        var dateData = updateClock();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('dashboard.store') }}",
            type: "POST",
            data: {
                loginType: loginType,
                dayName: dateData.dayName,
                month: dateData.month,
                dayNum: dateData.dayNum,
                year: dateData.year,
                hour: dateData.hour,
                minutes: dateData.minutes,
                seconds: dateData.seconds,
                period: dateData.period,
            },
            beforeSend: function () {
                $('#' + buttonId).val('Please wait..');
                $('#' + buttonId).attr('disabled', true);
            },
            success: function (response) {
                // alert('Success');
                if(response.responseData !== "") {
                    alert(response.responseData);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.status);
                console.log('Error: ' + textStatus + ' - ' + errorThrown);
            },
            complete: function () {
                $('#' + buttonId).removeAttr('disabled');
                $('#' + buttonId).val(loginType.charAt(0).toUpperCase() + loginType.slice(1).replace('_', ' '));
            }
        });
    }
    // Time in
    time_in.click(function (event) {
        handleButtonClick('time_in', 'time_in');
    });
    // Time Out
    time_out.click(function (event) {
        handleButtonClick('time_out', 'time_out');
    });
    // Break Out
    break_out.click(function (event) {
        handleButtonClick('break_out', 'break_out');
    });
    // Break In
    break_in.click(function (event) {
        handleButtonClick('break_in', 'break_in');
    });
</script>



@endsection
