@extends('layouts.structure')

@section('header')
    @parent

    <script src = "{{URL::asset("js/calendar.js") }}"></script>
    <script src = "{{URL::asset("js/calendar-setup.js") }}"></script>
    <script src = "{{URL::asset("js/calendar-fa.js") }}"></script>
    <script src = "{{URL::asset("js/jalali.js") }}"></script>
    <link rel="stylesheet" href = "{{URL::asset("css/calendar-green.css") }}">
    <script src="//cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>

@stop


@section('content')

    <form action="{{route('doEditProduct', ['id' => $product->id])}}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <center class="col-xs-12" style="margin-top: 70px">

            <h5 style="padding-right: 5%;">نام محصول</h5>
            <input value="{{$product->name}}" type="text" name="name" required maxlength="100">

            <h5 style="padding-right: 5%;">قیمت محصول</h5>
            <input value="{{$product->price}}" type="number" name="price" required min="0">

            <h5 style="padding-right: 5%;">ستاره های محصول</h5>
            <input value="{{$product->star}}" type="number" name="star" required min="0">

            <div>
                <span>تاریخ شروع نمایش</span>
                <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="show_date_btn">
                <br/>
                <input type="text" value="{{$product->start_show}}" name="start_show" id="date_input_show" readonly>
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
                <input type="time" value="{{$product->start_time}}" name="start_time">
            </div>


            <div>
                <span>تاریخ شروع خرید</span>
                <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="buy_date_btn">
                <br/>
                <input type="text" value="{{$product->start_date_buy}}" name="start_date_buy" id="date_input_buy" readonly>
                <script>
                    Calendar.setup({
                        inputField: "date_input_buy",
                        button: "buy_date_btn",
                        ifFormat: "%Y/%m/%d",
                        dateType: "jalali"
                    });
                </script>
            </div>

            <div style="margin: 10px">
                <span>زمان شروع خرید</span>
                <input value="{{$product->start_time_buy}}" type="time" name="start_time_buy">
            </div>

            <h5>توضیح محصول</h5>
            <textarea id="editor1" cols="80" name="description" required>
                {!! html_entity_decode($product->description) !!}
            </textarea>

            <h5 style="padding-right: 5%;">تصاویر محصول(اختیاری)</h5>
            <input type="file" name="file" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

            <h5 style="padding-right: 5%;">آموزش محصول(اختیاری)</h5>
            <input type="file" name="attach" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

            <h5 style="padding-right: 5%;">تبلیغات محصول(اختیاری)</h5>
            <input type="file" name="trailer" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">


            <h3 style="color: red">در صورت آپلود تصاویر جدید یا فایل های آموزشی جدید یا تبلیغات جدید برای محصول، موارد قبلی حذف خواهند شد.</h3>

            <div style="margin-top: 20px">
                <input type="submit" value="ویرایش" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
            </div>

        </center>

    </form>

    <script>

        CKEDITOR.replace('editor1');

    </script>
@stop
