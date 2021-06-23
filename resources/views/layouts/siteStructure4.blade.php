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

        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/card.css?v=1.3")}}">
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

    @yield("content")

    @include("layouts.footer")

    @if(\Illuminate\Support\Facades\Auth::check())
        @include("layouts.support")
    @endif

</body>
