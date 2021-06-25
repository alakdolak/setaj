@extends('layouts.structure')

@section('header')
    @parent

    <style>
        th, td {
            text-align: right;
        }

        .calendar {
            z-index: 1000000000000 !important;
        }

        input {
            text-align: center;
        }

    </style>

    <script src = {{URL::asset("js/calendar.js") }}></script>
    <script src = {{URL::asset("js/calendar-setup.js") }}></script>
    <script src = {{URL::asset("js/calendar-fa.js") }}></script>
    <script src = {{URL::asset("js/jalali.js") }}></script>
    <link rel="stylesheet" href = {{URL::asset("css/calendar-green.css") }}>
    <script src="//cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>

@stop

@section('content')

    <form action="{{route('doEditProject', ['id' => $project->id])}}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <center class="col-xs-12" style="margin-top: 70px">

            <h5 style="padding-right: 5%;">نام پروژه</h5>
            <input value="{{$project->title}}" type="text" name="name" required maxlength="100">

            <h5 style="padding-right: 5%;">هزینه پروژه</h5>
            <input value="{{$project->price}}" type="number" name="price" required min="0">

            <h5 style="padding-right: 5%;">ظرفیت</h5>
            <input value="{{$project->capacity}}" type="number" name="capacity" required>
            <p>اگر می خواهید ظرفیت این پروژه بی نهایت باشد، 1- را وارد نمایید.</p>

            <div style="margin: 10px">
                <span>زمان شروع خرید</span>
                <input type="time" name="start_reg_time" value="{{$project->start_reg_time}}">
            </div>

            <div>
                <span>تاریخ شروع امکان خرید</span>
                <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="date_btn">
                <br/>
                <input value="{{$project->start_reg}}" type="text" name="start_reg" id="date_input" readonly>
                <script>
                    Calendar.setup({
                        inputField: "date_input",
                        button: "date_btn",
                        ifFormat: "%Y/%m/%d",
                        dateType: "jalali"
                    });
                </script>
            </div>

            <div>
                <span>تاریخ اتمام امکان خرید</span>
                <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="end_date_btn">
                <br/>
                <input value="{{$project->end_reg}}" type="text" name="end_reg" id="end_date_input" readonly>
                <script>
                    Calendar.setup({
                        inputField: "end_date_input",
                        button: "end_date_btn",
                        ifFormat: "%Y/%m/%d",
                        dateType: "jalali"
                    });
                </script>
            </div>

            <div>
                <span>تاریخ شروع نمایش</span>
                <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="show_date_btn">
                <br/>
                <input value="{{$project->start_show}}" type="text" name="start_show" id="date_input_show" readonly>
                <script>
                    Calendar.setup({
                        inputField: "date_input_show",
                        button: "show_date_btn",
                        ifFormat: "%Y/%m/%d",
                        dateType: "jalali"
                    });
                </script>
            </div>

            <div style="margin: 10px">
                <span>زمان شروع نمایش</span>
                <input type="time" name="start_time" value="{{$project->start_time}}">
            </div>

            <h5>توضیح پروژه</h5>
            <textarea id="editor1" cols="80" name="description" required>
                {!! html_entity_decode($project->description) !!}
            </textarea>

            <h5 style="padding-right: 5%;">تصاویر پروژه(اختیاری)</h5>
            <input type="file" name="file" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

            <h5 style="padding-right: 5%;">فایل های آموزش پروژه(اختیاری)</h5>
            <input type="file" name="attach" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

            <h3 style="color: red">در صورت آپلود تصاویر جدید یا فایل های آموزشی جدید برای پروژه، موارد قبلی حذف خواهند شد.</h3>

            <div style="margin-top: 20px">
                <input type="submit" value="ویرایش" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
            </div>

        </center>

    </form>

    <script>

        CKEDITOR.replace('editor1');

    </script>

@stop
