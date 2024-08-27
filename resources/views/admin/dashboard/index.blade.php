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
                    background: #0170A8;
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

                .date,
                .time span:not(:last-child) {
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
                    background: #0170A8;
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
                    margin-top: 20px;
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

                #preloader-row .custom-loader {
                    /* Start Center Items on Table */
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    padding: 10px;
                    /* End Center Items on Table */
                    width: 50px;
                    height: 12px;
                    background:
                        radial-gradient(circle closest-side, #0170A8 90%, #0000) 0% 50%,
                        radial-gradient(circle closest-side, #0170A8 90%, #0000) 50% 50%,
                        radial-gradient(circle closest-side, #0170A8 90%, #0000) 100% 50%;
                    background-size: calc(100%/3) 100%;
                    background-repeat: no-repeat;
                    animation: d7 1s infinite linear;
                }

                @keyframes d7 {
                    33% {
                        background-size: calc(100%/3) 0%, calc(100%/3) 100%, calc(100%/3) 100%
                    }

                    50% {
                        background-size: calc(100%/3) 100%, calc(100%/3) 0%, calc(100%/3) 100%
                    }

                    66% {
                        background-size: calc(100%/3) 100%, calc(100%/3) 100%, calc(100%/3) 0%
                    }
                }
            </style>

            <!--digital clock start-->
            <div class="container">
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
                            {{-- <div class="aux_container" style="display: flex; align-items: left;">
                            <p id="aux_duration" style="font-size:24px;font-weight:bold;margin-right: 8px;">Aux Duration: 0 second</p>
                            <i class="ri ri-information-fill" style="font-size: 1.5em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Aux Duration is the time of your short breaks accumulated within a day. Example: Taking restroom breaks."></i>
                        </div>                 --}}
                            <div class="text-center mt-4">
                                <h3 class="font-bold text-white mb-3">Aux History</h3>
                                <!-- Small modal -->
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#auxHistoryModal">Open History</button>

                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal fade bs-example-modal-xl" id="auxHistoryModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Aux History</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="auxDatas">
                                        <thead class="font-bold">
                                            <tr>
                                                <th>Date</th>
                                                <th>Shift</th>
                                                <th>Time Started</th>
                                                <th>Time Stopped</th>
                                                <th>Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($auxRecords !== '')
                                                @foreach ($auxRecords as $auxRecord)
                                                    <tr>
                                                        <td scope="row">{{ $auxRecord->formatted_created_at }}</td>
                                                        <td>{{ $auxRecord->formatted_weekday }} Shift</td>
                                                        <td>{{ $auxRecord->formatted_login }}</td>
                                                        <td>{{ $auxRecord->formatted_logout ?? '' }}</td>
                                                        <td>{{ $auxRecord->formatted_duration ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        <div class="alert alert-warning text-center" role="alert">
                                                            No record found.
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="timeInFormContainer">
                    <form class="form-control" id="timeInForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="button" class="btn btn-primary custom-btn w-100 mb-3" name="time_in"
                                    id="time_in" data-attribute="1" value="Time In" />
                                <input type="button" class="btn btn-secondary custom-btn w-100" name="time_out"
                                    id="time_out" data-attribute="2" value="Time Out" {{ $result ? '' : 'disabled' }} />
                            </div>
                            <div class="col-md-4">
                                <input type="button" class="btn btn-success custom-btn w-100 mb-3" name="break_out"
                                    id="break_out" data-attribute="3" value="Break Out" {{ $result ? '' : 'disabled' }} />
                                <input type="button" class="btn btn-secondary custom-btn w-100" name="break_in"
                                    id="break_in" data-attribute="4" value="Break In" {{ $result ? '' : 'disabled' }} />
                            </div>
                            <div class="col-md-4">
                                <input type="button" class="btn btn-warning custom-btn w-100 mb-3" name="aux_in"
                                    id="aux_in" data-attribute="5" value="Aux In" {{ $result ? '' : 'disabled' }} />
                                <input type="button" class="btn btn-secondary custom-btn w-100" name="aux_out"
                                    id="aux_out" data-attribute="6" value="Aux Out" {{ $result ? '' : 'disabled' }} />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">Attendance Records for <b>{{ $currentMonth }}</b>
                                    <i class="ri ri-information-fill" style="font-size: 1.5em;" data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-original-title="Here is the reference of your attendance records for the month of May. Note: Every month the record will be archived."></i>
                                </h2>

                                <div class="table-responsive">
                                    <table class="table mb-0" id="attendanceDatas">
                                        <thead class="font-bold">
                                            <tr>
                                                <th>Date</th>
                                                <th>Shift</th>
                                                <th>Time of Shift of User</th>
                                                <th>Type
                                                    <i class="ri ri-information-fill" style="font-size: 1.5em;"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="Note: If you click the 'Time out' button it will set to 'Log Out' status. Same goes to 'OT Out', 'Break In'."></i>
                                                </th>
                                                <th>Log In Time</th>
                                                <th>Log Out Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="preloader-row" style="display:none;">
                                                <td colspan="12">
                                                    <div class="custom-loader" style="display: inline-block;"></div>
                                                </td>
                                            </tr>
                                            @if ($attendanceRecords !== '')
                                                @foreach ($attendanceRecords as $record)
                                                    <tr>
                                                        <td scope="row"> {{ $record->formatted_created_at }} </td>
                                                        <td> {{ $record->formatted_weekdays }} Shift</td>
                                                        <td> No data yet. </td>
                                                        <td> {{ $record->formatted_logintype }} </td>
                                                        <td> {{ $record->formatted_login }} </td>
                                                        <td> {{ $record->formatted_logout }} </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        <div class="alert alert-warning text-center" role="alert">
                                                            No record found.
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers"
                                        id="datatable-buttons_paginate">
                                        <ul class="pagination pagination-rounded">
                                            {!! $links !!}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        Number.prototype.pad = function(digits) {
            for (var n = this.toString(); n.length < digits; n = '0' + n);
            return n;
        }

        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
            "November", "December"
        ];
        const week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

        // Init Vars
        var time_in = $("#time_in");
        var time_out = $("#time_out");
        var break_out = $("#break_out");
        var break_in = $("#break_in");
        var aux_in = $("#aux_in");
        var aux_out = $("#aux_out");
        let saveDataFlag = true;

        function updateClock() {
            var now = new Date();
            var localTime = new Date(now.toLocaleString('en-US', {
                timeZone: 'Asia/Manila'
            }));
            var dname = localTime.getDay(),
                mo = localTime.getMonth(),
                dnum = localTime.getDate(),
                yr = localTime.getFullYear(),
                hou = localTime.getHours(),
                min = localTime.getMinutes(),
                sec = localTime.getSeconds(),
                pe = "AM";

            // Call the resetAuxDuration function to reset the auxDuration at 10 PM to 8 AM Philippine time
            // resetAuxDuration();

            if (hou >= 12) {
                pe = "PM";
            }
            if (hou == 0) {
                hou = 12;
            }
            if (hou > 12) {
                hou = hou - 12;
            }
            var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
            var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
            for (var i = 0; i < ids.length; i++)
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

        function initClock() {
            restoreClock();
            updateClock();
            setInterval(updateClock, 1000);
        }
        // Call the initClock function immediately
        initClock();
        // Also call the initClock function when the window is loaded
        window.onload = initClock;

        function enableTimeOutButton() {
            time_out.prop('disabled', false);
        }

        function enableBreakOutButton() {
            break_out.prop('disabled', false);
        }

        function enableBreakInButton() {
            break_in.prop('disabled', false);
        }

        // Aux In / Out
        let auxTimerRunning = false;
        let seconds = 0;
        let auxTimerInterval;
        // auxDuration = 0;

        // Disable / Enable Aux Button
        function disableAuxOutButton() {
            aux_out.prop('disabled', true);
        }

        function enableAuxInButton() {
            aux_in.prop('disabled', false);
        }
        // End Disable / Enable Aux Button

        // If Aux In Button is clicked
        function startAuxTimer() {
            if (!auxTimerRunning) {
                // Get the saved aux_duration from localStorage
                const auxDurationData = JSON.parse(localStorage.getItem("auxDuration"));
                if (auxDurationData) {
                    seconds = auxDurationData.duration;
                }

                auxTimerRunning = true;
                saveDataFlag = true; // Enable saving data to localStorage

                // Set up a function to be called every second (1000 milliseconds)
                auxTimerInterval = setInterval(() => {
                    seconds++; // Increment the seconds counter
                    if (saveDataFlag) { // Check if the data should be saved
                        localStorage.setItem("auxDuration", JSON.stringify({
                            duration: seconds
                        })); // Save the updated duration in localStorage
                    }
                    updateTimer(); // Update the timer display
                }, 1000);
            }
        }

        function stopAuxTimer() {
            if (auxTimerRunning) {
                clearInterval(auxTimerInterval); // Clear the setInterval, stopping the timer
                auxTimerRunning = false;
                saveDataFlag = false; // Stop saving data to localStorage

                // Reload the stored duration from localStorage
                const auxDurationData = JSON.parse(localStorage.getItem("auxDuration"));
                if (auxDurationData) {
                    seconds = auxDurationData.duration;
                } else {
                    seconds = 0;
                }
            }
        }

        function updateTimer() {
            let hours = Math.floor(seconds / 3600);
            let minutes = Math.floor((seconds % 3600) / 60);
            let remainingSeconds = seconds % 60;

            if (hours > 0) {
                document.getElementById("aux_duration").innerHTML = "Aux Duration: " + hours + " hours " + minutes +
                    " minutes " + remainingSeconds + " seconds";
            } else if (minutes > 0) {
                document.getElementById("aux_duration").innerHTML = "Aux Duration: " + minutes + " minutes " +
                    remainingSeconds + " seconds";
            } else {
                document.getElementById("aux_duration").innerHTML = "Aux Duration: " + remainingSeconds + " seconds";
            }
        }
        // Load aux_duration from localStorage
        // function loadAuxDuration() {
        //     const auxDurationData = JSON.parse(localStorage.getItem("auxDuration"));
        //     if (auxDurationData) {
        //         const now = new Date();
        //         const day = now.getDay();
        //         const isWeekday = day >= 1 && day <= 5; // Check if the current day is a weekday (Monday to Friday)

        //         if (isWeekday) {
        //             seconds = auxDurationData.duration;
        //             updateTimer();
        //         } else {
        //             // If it's not a weekday, remove the value from localStorage
        //             localStorage.removeItem("auxDuration");
        //         }
        //     } else {
        //         // If there's no data in localStorage, initialize the timer with 0 seconds
        //         seconds = 0;
        //         updateTimer();
        //     }
        // }

        // Call this function when the page loads
        // loadAuxDuration();

        function resetAuxDuration() {
            // Get the current time in the Philippine timezone
            var now = new Date().toLocaleString("en-US", {
                timeZone: "Asia/Manila"
            });
            var hour = new Date(now).getHours();

            // Check if the current time is between 10 PM (22:00) and 8 AM (08:00)
            if (hour >= 22 || hour < 8) {
                // Reset the auxDuration
                localStorage.setItem("auxDuration", JSON.stringify({
                    duration: 0
                }));
            }
        }

        function enableAuxOutButton() {
            document.getElementById("aux_out").disabled = false;
            stopAuxTimer(); // Stop the timer when the Aux Out button is enabled
        }

        // let accumulatedDuration = 0;
        let shouldRunTimer = false;
        // Load accumulatedDuration from localStorage
        // let accumulatedDuration = parseInt(localStorage.getItem("accumulatedDuration")) || 0;

        // function calculateDuration() {
        //     if (shouldRunTimer) { // Check if the timer should be running
        //         const startTime = localStorage.getItem("auxStartTime");
        //         if (startTime) {
        //             const now = new Date().getTime();
        //             seconds = Math.floor((now - startTime) / 1000) + accumulatedDuration;
        //             updateTimer();
        //         }
        //     }
        // }

        // setInterval(calculateDuration, 1000); // Update the duration every second

        function resetTimer() {
            seconds = 0;
            updateTimer();
        }

        function checkResetTime() {
            var now = new Date();
            var localTime = new Date(now.toLocaleString('en-US', {
                timeZone: 'Asia/Manila'
            }));
            const resetHour = 22; // 10 PM
            const currentHour = localTime.getHours();

            if (currentHour === resetHour && localTime.getMinutes() === 0 && localTime.getSeconds() === 0) {
                resetTimer();
            }
        }
        // Call checkResetTime every second
        setInterval(checkResetTime, 1000);

        // Handle All Request
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
                beforeSend: function() {
                    $('#' + buttonId).val('Please wait..');
                    $('#' + buttonId).attr('disabled', true);
                },
                success: function(response) {
                    // alert('Success');
                    if (response.responseData !== "") {
                        alert(response.responseData);
                        // Enable the Other buttons button if a "Time In" event is successful
                        if (loginType === 1) {
                            time_out.removeAttr('disabled');
                            break_out.removeAttr('disabled');
                            break_in.removeAttr('disabled');
                            aux_in.removeAttr('disabled');
                            aux_out.removeAttr('disabled');
                        }
                        // Enable the Other buttons if a "Time Out" event is successful
                        if (loginType === 2) {
                            time_out.attr('disabled', 'disabled');
                            break_out.attr('disabled', 'disabled');
                            break_in.attr('disabled', 'disabled');
                            aux_in.attr('disabled', 'disabled');
                            aux_out.attr('disabled', 'disabled');
                        }
                        // Time In | Time Out | Break Out | Break In
                        if (loginType === 1 || loginType === 2 || loginType === 3 || loginType === 4) {
                            refreshTable();
                        }
                        // Aux In and Aux Out
                        if (loginType === 5 || loginType === 6) {
                            refreshAuxHistoryTable();
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.status);
                    console.log('Error: ' + textStatus + ' - ' + errorThrown);
                },
                complete: function() {
                    $('#' + buttonId).removeAttr('disabled');
                    $('#' + buttonId).val(loginTypeNames[loginType]);
                }
            });
        }
        // Time in
        time_in.click(function(event) {
            var loginType = $(this).data("attribute");
            handleButtonClick(loginType, 'time_in');
        });
        // Time Out
        time_out.click(function(event) {
            var loginType = $(this).data("attribute");
            handleButtonClick(loginType, 'time_out');
        });
        // Break Out
        break_out.click(function(event) {
            var loginType = $(this).data("attribute");
            handleButtonClick(loginType, 'break_out');
        });
        // Break In
        break_in.click(function(event) {
            var loginType = $(this).data("attribute");
            handleButtonClick(loginType, 'break_in');
        });
        // Aux In
        aux_in.click(function(event) {
            var loginType = $(this).data("attribute");
            handleButtonClick(loginType, 'aux_in', seconds);
            startAuxTimer(); // Add this line to start the timer when the Aux In button is clicked
            shouldRunTimer = true; // Set shouldRunTimer to true when the Aux In button is clicked
        });
        // Aux Out
        aux_out.click(function(event) {
            var logoutType = $(this).data("attribute");
            handleButtonClick(logoutType, 'aux_out', seconds);
            stopAuxTimer();
            shouldRunTimer =
                false; // Add this line to set shouldRunTimer to false when the Aux Out button is clicked
        });
        // Attendance Records
        function refreshTable() {
            $.ajax({
                url: "{{ route('dashboard.table-data') }}", // Fetch data from the new route
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    // Show the preloader before the request starts
                    $('#preloader-row').show();
                },
                success: function(response) {
                    // Assuming 'data' is an array of objects, each containing the row data
                    let tableRows = '';
                    $.each(response.data, function(index, row) {
                        tableRows += `
                                <tr id="preloader-row" style="display:none;">
                                        <td colspan="12">
                                            <div class="custom-loader" style="display: inline-block;"></div>
                                        </td>
                                    </tr>
                                <tr>
                                    <td scope="row">${row.formatted_created_at}</td>
                                    <td>${row.formatted_weekdays}</td>
                                    <td>No data yet.</td>
                                    <td>${row.formatted_logintype}</td>
                                    <td>${row.formatted_login}</td>
                                    <td>${row.formatted_logout}</td>
                                </tr>`;
                    });

                    // Replace the table body with the new data
                    $('#attendanceDatas tbody').html(tableRows);
                },
                complete: function() {
                    // Hide the preloader after the request is completed
                    $('#preloader-row').hide();
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
        // Aux Records
        function refreshAuxHistoryTable() {
            $.ajax({
                url: "{{ route('dashboard.aux-history-data') }}", // Fetch data from the new route
                type: 'GET',
                dataType: 'json',
                // beforeSend: function() {
                //     // Show the preloader before the request starts
                //     $('#preloader-row').show();
                // },
                success: function(response) {
                    // Assuming 'data' is an array of objects, each containing the row data
                    let tableRows = '';
                    $.each(response.data, function(index, row) {
                        let logout = row.formatted_logout ? row.formatted_logout : '';
                        let duration = row.formatted_duration ? row.formatted_duration : '';
                        tableRows += `<tr>
                                    <td scope="row">${row.formatted_created_at}</td>
                                    <td>${row.formatted_weekday} Shift</td>
                                    <td>${row.formatted_login}</td>
                                    <td>${logout}</td>
                                    <td>${duration}</td>
                                </tr>`;
                    });

                    // Replace the table body with the new data
                    $('#auxDatas tbody').html(tableRows);

                    $('#auxHistoryModal').modal('show');

                    // alert(response.json);
                },
                // complete: function() {
                //     // Hide the preloader after the request is completed
                //     $('#preloader-row').hide();
                // },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
    </script>

@endsection
