@extends("layouts.siteStructure2")


@section("header")
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/contactUs.css?v=1")}}">
@stop

@section("content")

    <center class="row contactUsBody">
        <img width="150px" src="{{\Illuminate\Support\Facades\URL::asset('images/correct2.png')}}">
        <h3 style="color: black">عملیات مورد نظر با موفقیت انجام شد.</h3>
        <h3 style="color: black">کد پیگیری شما {{$ref}} می باشد.</h3>
        <h3 style="color: black">مشخصات محصول شما:</h3>
        <p style="color: black">نام محصول: {{$name}}</p>
        <p style="color: black">کد محصول: {{$code}}</p>
        <p style="color: black">فروشنده: {{$owner}}</p>
        <p style="color: black">تاریخ انجام تراکنش: {{$date[0] . '/' . $date[1] . '/' . $date[2]}}</p>
    </center>

@stop
