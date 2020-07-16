@extends("layouts.siteStructure2")


@section("header")

    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/choosePlan.css")}}">
@stop

@section("content")

    <div class="choosePlane row">
        <div class="col-xs-4">
            <div onclick="document.location.href = '{{route('showAllProjects')}}'" class="planes projects">
                <div class="planeText">انتخاب پروژه‌ها</div>
            </div>
        </div>
        <div class="col-xs-4">
            <div onclick="document.location.href = '{{route('showAllServices')}}'" class="planes Services">
                <div class="planeText">پروژه‌های همیاری</div>
            </div>
        </div>
        <div class="col-xs-4">
            <div onclick="document.location.href = '{{route('showAllProducts')}}'" class="planes Products">
                <div class="planeText">خرید محصولات</div>
            </div>
        </div>
    </div>

@stop
