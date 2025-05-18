$(document).ready(function () {
    // const loading = $("#successLoading");
    // const day = $("#days");
    // const hour = $("#hours");
    // const minute = $("#minutes");
    // const second = $("#seconds");
    // const test = $("#test");

    // const examDate = moment('2023-07-27', 'YYYY-MM-DD');

    // var today;
    // var days;
    // var hours;
    // var minutes;
    // var seconds;
    // function setDueDate() {
    //     today = moment();
    //     days = examDate.diff(today, 'days');
    //     hours = examDate.diff(today, 'hours') % 24;
    //     minutes = examDate.diff(today, 'minutes') % 60;
    //     seconds = examDate.diff(today, 'seconds') % 60;
    //     day.html(days.toString().padStart(2, '0'));
    //     hour.html(hours.toString().padStart(2, '0'));
    //     minute.html(minutes.toString().padStart(2, '0'));
    //     second.html(seconds.toString().padStart(2, '0'));
    //     $("#today").html(today.format("DD MMM YYYY"))
    //     $("#examDate").html(examDate.format("DD MMM YYYY"))
    //     if (today.format('DD-MM-YYYY') == examDate.format('DD-MM-YYYY')) {
    //         day.html('00');
    //         hour.html('00');
    //         minute.html('00');
    //         second.html('00');
    //         clearInterval(timeInterval);
    //     }
    // }
    // setDueDate()
    // const timeInterval = setInterval(setDueDate, 1000);
    var j_startTime = {};
    var j_endTime = {};
    var j_totalDuration = {};
    var j_currentTime = {};
    var j_function = {};
    var j_timeInterval = {};
    var j_join_at = {};

    j_totalDuration[1] = 59;
    j_join_at = '1690353756';

    j_startTime[1] = moment.unix(j_join_at);
    j_endTime[1] = j_startTime[1].clone().add(j_totalDuration[1], 'minutes');

    $("#startAt1").html(j_startTime[1].format('hh:mm:ss'));
    $("#endAt1").html(j_endTime[1].format('hh:mm:ss'));


    j_function[1] = function () {
        let examMinutes;
        let examSeconds;
        let loading;
        j_currentTime[1] = moment()
        if (j_currentTime[1].isAfter(j_endTime[1])) {
            $("#remainMinutes1").html(j_totalDuration[1].toString().padStart(2, '0'));
            $("#remainSeconds1").html('0'.padStart(2, '0'));
            clearInterval(j_timeInterval[1]);
            $("#joinExamBtn1").remove();
            $("#timeOver1").removeClass('d-none');
            $("#timeLoader1").css('width', '100%');

        } else {
            examMinutes = j_currentTime[1].diff(j_startTime[1], 'minutes') % 60;
            examSeconds = j_currentTime[1].diff(j_startTime[1], 'seconds') % 60;
            loading = ((j_currentTime[1].diff(j_startTime[1], 'seconds') * 100) / (j_totalDuration[1] * 60)).toFixed(2) + '%';
            $("#timeLoader1").css('width', loading);
            $("#remainMinutes1").html(examMinutes.toString().padStart(2, '0'));
            $("#remainSeconds1").html(examSeconds.toString().padStart(2, '0'));
        }

    }
    j_function[1]();

    j_timeInterval[1] = setInterval(j_function[1], 1000);
});