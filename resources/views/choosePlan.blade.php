@extends("layouts.siteStructure2")


@section("header")

    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/choosePlan.css")}}">
@stop

@section("content")

    <div class="choosePlane">
        <div onclick="document.location.href = '{{route('showAllProjects')}}'" class="planes projects">
            <div class="planeText">معرفی پروژه‌ها</div>
        </div>
        <div onclick="document.location.href = '{{route('showAllServices')}}'" class="planes Services">
            <div class="planeText">پروژه‌های خدماتی</div>
        </div>
        <div onclick="document.location.href = '{{route('showAllProducts')}}'" class="planes Products">
            <div class="planeText">معرفی محصولات</div>
        </div>
    </div>

@stop
