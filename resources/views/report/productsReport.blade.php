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

    <div class="col-md-12" style="margin-top: 100px">

        <div class="row" style="margin-bottom: 5%;">
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
        </div>

        <center>

            <table style="margin-top: 20px">
                <tr>
                    <td>فروشنده</td>
                    <td>خریدار</td>
                    <td>محصول</td>
                    <td>تاریخ انجام معامله</td>
                </tr>

                <?php $i = 0; ?>
                @foreach($products as $product)
                    <tr id="{{$i}}">

                        <td>{{$product->seller}}</td>
                        <td>{{$product->buyer}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->date}}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </table>
        </center>

    </div>


    <script>

        var start_time;
        var examsStartValue = [];
        var examsEndValue = [];
        var stateValue = [];
        var end_time;
        var exams = {!! json_encode($products) !!} ;

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
            doChange();
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
            doChange();
        }

        function doChange() {
            for (i = 0; i < exams.length; i++) {
                if (examsStartValue[i] + examsEndValue[i] + stateValue[i] == 3) {
                    document.getElementById(i).style.display = '';
                }
                else {
                    document.getElementById(i).style.display = 'none';
                }
            }
        }

    </script>

@stop
