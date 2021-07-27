@extends("layouts.siteStructure2")


@section("header")
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/contactUs.css?v=1")}}">
@stop

@section("content")

    <center class="row contactUsBody">
        <img width="100px" style="margin-top: 150px" src="{{\Illuminate\Support\Facades\URL::asset("images/del.png")}}">
        <h3 style="color: black; width: 400px; text-align: justify; margin-top: 100px">تراکنش شما با خطا رو به رو شده است. اگرمبلغ از حساب شما کم شده است، تا 24 ساعت آینده به حساب شما واریز خواهد شد.</h3>
    </center>

@stop
