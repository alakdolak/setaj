@extends("layouts.siteStructure2")


@section("header")
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/contactUs.css?v=1")}}">
@stop

@section("content")

    <div class="row contactUsBody">
        <p style="color: black">تراکنش شما با خطا رو به رو شده است. اگرمبلغ از حساب شما کم شده است، تا 24 ساعت آینده به حساب شما واریز خواهد شد.</p>
    </div>

@stop
