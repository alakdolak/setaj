@extends("layouts.siteStructure2")


@section("header")
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/contactUs.css?v=1")}}">
@stop

@section("content")

    <div class="row contactUsBody">
        <p style="color: black">عملیات مورد نظر با موفقیت انجام شد.</p>
        <p style="color: black">کد پیگیری شما {{$ref}} می باشد.</p>
    </div>

@stop
