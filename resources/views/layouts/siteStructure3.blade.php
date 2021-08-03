<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->


<head>
    @section('header')

        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta charset="utf-8" />
        <meta name="_token" content="{{ csrf_token() }}"/>
        <link href="{{URL::asset('css/myFont.css')}}" rel="stylesheet">

        <link rel="icon" href="{{\Illuminate\Support\Facades\URL::asset("images/logo.png")}}" sizes="16x16" type="image/png">

        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/card.css?v=1.7")}}">
        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/banner.css?v=1.3")}}">
        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/header.css?v=1.3")}}">
        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/footer.css?v=1.4")}}">
        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/general.css?v=1.3")}}">
        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/choosePlan.css?v=1.7")}}">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/v4-shims.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/chatbox.css")}}">

    @show
</head>

<body style="font-family: IRANSans; direction: rtl">

@include("layouts.header")
@yield("banner")

<center>

    @if(!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->level != 1)

        @if($grade != 9)
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 9}}'" class="btn btn-default">اول دبستان</button>
        @else
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 9}}'" class="btn btn-default" style="background-color: #0b4d3f; color: white">اول دبستان</button>
        @endif

        @if($grade != 4)
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 4}}'" class="btn btn-default">دوم دبستان</button>
        @else
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 4}}'" class="btn btn-default" style="background-color: #0b4d3f; color: white">دوم دبستان</button>
        @endif

        @if($grade != 5)
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 5}}'" class="btn btn-default">سوم دبستان</button>
        @else
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 5}}'" class="btn btn-default" style="background-color: #0b4d3f; color: white">سوم دبستان</button>
        @endif

        @if($grade != 6)
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 6}}'" class="btn btn-default">چهارم دبستان</button>
        @else
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 6}}'" class="btn btn-default" style="background-color: #0b4d3f; color: white">چهارم دبستان</button>
        @endif

        @if($grade != 7)
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 7}}'" class="btn btn-default">پنجم دبستان</button>
        @else
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 7}}'" class="btn btn-default" style="background-color: #0b4d3f; color: white">پنجم دبستان</button>
        @endif

        @if($grade != 8)
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 8}}'" class="btn btn-default">ششم دبستان</button>
        @else
            <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 8}}'" class="btn btn-default" style="background-color: #0b4d3f; color: white">ششم دبستان</button>
        @endif

        {{--            @if($grade != 3)--}}
        {{--                <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 3}}'" class="btn btn-default">هفتم</button>--}}
        {{--            @else--}}
        {{--                <button onclick="document.location.href = '{{route(Route::current()->getName()) . '/' . 3}}'" class="btn btn-default" style="background-color: #0b4d3f; color: white">هفتم</button>--}}
        {{--            @endif--}}

    @endif
</center>

@if(isset($tags))
    <div class="filterBorder">
        <div class="filterBox">
            <div id="allTags" class="tagFilter filterTag selectedTag" data-status="1" data-filter="-1">همه موارد</div>
            @foreach($tags as $tag)
                <div data-status="0" class="tagFilter filterTag" data-filter="{{$tag->id}}">{{$tag->name}}</div>
            @endforeach
        </div>
    </div>

@endif


@yield("content")

@include("layouts.footer")

@if(\Illuminate\Support\Facades\Auth::check())
    @include("layouts.support")
@endif

<script>

    function checkBanners() {

        $(".weekContainer").removeClass("hidden").each(function () {

            var allow = false;

            $(this).find(".myItem").each(function () {

                if(allow)
                    return;

                if(!$(this).hasClass("hidden"))
                    allow = true;

            });

            if(!allow)
                $(this).addClass("hidden");
        });

    }

    $(document).ready(function () {

        $(".tagFilter").on('click', function () {

            var status = $(this).attr("data-status");
            $(".tagFilter").attr("data-status", "0").removeClass("selectedTag");

            var selectedTag;

            if(status == "0") {
                $(this).attr("data-status", "1").addClass("selectedTag");
                selectedTag = $(this).attr("data-filter");
            }
            else {
                $(this).attr("data-status", "0").removeClass("selectedTag");
                selectedTag = -2;
            }

            if(selectedTag == "-1") {

                if(status == "0") {
                    $(".myItem").removeClass("hidden");
                }
                else {
                    $(".myItem").addClass("hidden");
                }
                return checkBanners();
            }

            $(".myItem").addClass("hidden").each(function () {

                if($(this).attr("data-tag").includes("-" + selectedTag + "-")) {
                    $(this).removeClass("hidden");
                }

            });

            checkBanners();

        });


    });

</script>

</body>
