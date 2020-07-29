@extends('layouts.structure')

@section('header')
    @parent

    <style>
        th, td {
            text-align: center;
            padding: 7px;
            border: 1px solid #444;
        }

    </style>


    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/calendar-setup.js") }}></script>
    <script src= {{URL::asset("js/calendar-fa.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>
    <link rel="stylesheet" href="{{URL::asset('css/standalone.css')}}">
    <link rel="stylesheet" href= {{URL::asset("css/calendar-green.css") }}>

@stop

@section('content')

    <div class="col-sm-12" style="margin-top: 100px">

        <center>

            <h3>
                <a href="{{route('unDoneProjectsReportExcel', ['gradeId' => $gradeId])}}">دریافت فایل اکسل</a>
            </h3>

            <div>
                <span>پروژه مورد نظر</span>
                <select id="mySelect" onchange="filter(this.value)">
                    <option value="-1">همه</option>
                    @foreach($allTitles as $title)
                        <option value="{{$title}}">{{$title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-xs-12" style="margin-top: 5px; direction: rtl">

                <div style="display: inline-block; width: auto; margin-right: 10%; margin-left: 5%; float: right;">
                    <span style="float: right; margin-top: 6%;">    از تاریخ:   </span>
                    <label style="">
                        <input type="button"
                               style="border: none;  margin-top: 5%; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;"
                               id="date_btn_Start">
                    </label>
                    <input type="text" style="max-width: 200px" class="form-detail"
                           id="date_input_start" onchange="start()" readonly>

                    <script>
                        Calendar.setup({
                            inputField: "date_input_start",
                            button: "date_btn_Start",
                            ifFormat: "%Y/%m/%d",
                            dateType: "jalali"
                        });
                    </script>
                </div>

                <div style="display: inline-block; width: auto; margin-left: 5%; float: right">
                    <span style="float: right; margin-top: 6%;">تا تاریخ:</span>
                    <label style="">
                        <input type="button"
                               style="border: none;  margin-top: 5%; width: 30px;  height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;"
                               id="date_btn_end">
                    </label>
                    <input type="text" style="max-width: 200px" class="form-detail"
                           id="date_input_end" onchange="end()" readonly>

                    <script>
                        Calendar.setup({
                            inputField: "date_input_end",
                            button: "date_btn_end",
                            ifFormat: "%Y/%m/%d",
                            dateType: "jalali"
                        });
                    </script>
                </div>

            </div>

            <h3 style="margin-top: 100px"><span>تعداد کل: </span><span>&nbsp;</span><span id="totalCount">{{count($projects)}}</span></h3>

            <table style="margin-top: 40px">
                <tr>
                    <td>ردیف</td>
                    <td>نام کاربر</td>
                    <td>نام پروژه</td>
                    <td>تاریخ پذیرش پروژه</td>
                    <td>عملیات</td>
                </tr>

                <?php $i = 1; ?>
                @foreach($projects as $project)
                    <tr class="myTr" data-value="{{$project->title}}" id="myTr_{{$project->id}}">
                        <td>{{$i}}</td>
                        <td>{{$project->name}}</td>
                        <td>{{$project->title}}</td>
                        <td>{{$project->Bdate . '    ساعت     ' . $project->time}}</td>
                        <td><button class="btn btn-danger" onclick="deleteBuyProject('{{$project->id}}')">بازپس گیری پروژه</button></td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </table>
        </center>

    </div>

    <script>

        function filter(id) {

            if(id == -1) {
                $(".myTr").removeClass('hidden');
            }
            else {
                $(".myTr").addClass('hidden').each(function () {

                    if($(this).attr("data-value") == id)
                        $(this).removeClass("hidden");

                });

            }

            doChange();

        }

        function deleteBuyProject(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteBuyProject')}}',
                data: {
                    id: id,
                },
                success: function (res) {

                    if(res === "ok")
                        $("#myTr_" + id).remove();

                }
            });

        }


        var start_time;
        var examsStartValue = [];
        var examsEndValue = [];
        var stateValue = [];
        var end_time;
        var exams = {!! json_encode($projects) !!} ;

        for (j = 0; j < exams.length; j++) {
            examsEndValue[j] = 1;
            examsStartValue[j] = 1;
            stateValue[j] = 1;
        }

        function start() {
            start_time = document.getElementById('date_input_start').value;
            start_time = start_time.split('/');
            changeStartTime()
        }

        function end() {
            end_time = document.getElementById('date_input_end').value;
            end_time = end_time.split('/');
            changeEndTime();
        }

        function changeStartTime() {

            for (i = 0; i < exams.length; i++) {

                day = parseInt((exams[i].date.split("-")[2]));
                month = parseInt((exams[i].date.split("-")[1]));
                year = parseInt((exams[i].date.split("-")[0]));

                if (year == start_time[0]) {
                    if (month == start_time[1]) {
                        if (day >= start_time[2]) {
                            examsStartValue[i] = 1;
                        }
                        else {
                            examsStartValue[i] = 0;
                        }
                    }
                    else if (month > start_time[1]) {
                        examsStartValue[i] = 1;
                    }
                    else {
                        examsStartValue[i] = 0;
                    }
                }
                else if (year > start_time[0]) {
                    examsStartValue[i] = 1;
                }
                else {
                    examsStartValue[i] = 0;
                }
            }

            filter($("#mySelect").val());
        }

        function changeEndTime() {
            for (i = 0; i < exams.length; i++) {

                day = parseInt((exams[i].date.split("-")[2]));
                month = parseInt((exams[i].date.split("-")[1]));
                year = parseInt((exams[i].date.split("-")[0]));

                if (year == end_time[0]) {
                    if (month == end_time[1]) {
                        if (day <= end_time[2]) {
                            examsEndValue[i] = 1;
                        }
                        else {
                            examsEndValue[i] = 0;
                        }
                    }
                    else if (month < end_time[1]) {
                        examsEndValue[i] = 1;
                    }
                    else {
                        examsEndValue[i] = 0;
                    }
                }
                else if (year < end_time[0]) {
                    examsEndValue[i] = 1;
                }
                else {
                    examsEndValue[i] = 0;
                }
            }

            filter($("#mySelect").val());
        }

        function doChange() {

            var x = 0;

            for (i = 0; i < exams.length; i++) {

                if(!$("#myTr_" + exams[i].id).hasClass('hidden')) {

                    if (examsStartValue[i] + examsEndValue[i] + stateValue[i] != 3) {
                        $("#myTr_" + exams[i].id).addClass("hidden");
                    }
                    else {
                        x++;
                    }
                }

            }

            $("#totalCount").empty().append(x);
        }

    </script>

@stop
