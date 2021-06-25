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

        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/header.css?v=1.3")}}">
        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/footer.css?v=1.4")}}">
        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/general.css?v=1.3")}}">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/v4-shims.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/chatbox.css")}}">
{{--        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/login.css?v=1.4")}}">--}}

        <style>
            .should_be_iransans {
                font-family: IRANSans !important;
                font-weight: normal;
            }
            .should_be_iransans p {
                font-family: IRANSans !important;
                font-weight: normal;
            }
            .should_be_iransans div {
                font-family: IRANSans !important;
                font-weight: normal;
            }
            .should_be_iransans a {
                font-family: IRANSans !important;
                font-weight: normal;
            }
            .should_be_iransans span {
                font-family: IRANSans !important;
                font-weight: normal;
            }
        </style>

        {{--the style of login--}}
{{--        <style>--}}
{{--            .loginBody {--}}
{{--                width: 300px;--}}
{{--                background-color: white;--}}
{{--                padding: 25px;--}}
{{--                position: absolute;--}}
{{--                bottom: -5%;--}}
{{--                left: 50%;--}}
{{--                transform: translate(-50%, -50%);--}}
{{--                border-radius: 12px;--}}
{{--                border-bottom: 12px solid #04C582;--}}
{{--            }--}}

{{--            .loginTitle {--}}
{{--                width: 100%;--}}
{{--                margin: 0 0 25px;--}}
{{--                padding: 0 0 15px 0;--}}
{{--                border-bottom: 2px solid #f9f9f9;--}}
{{--                display: flex;--}}
{{--                justify-content: center;--}}
{{--            }--}}

{{--            .loginTitleImg {--}}
{{--                width: 75%;--}}
{{--                height: 90px;--}}
{{--                background-image: url(../../../public/images/login.png);--}}
{{--                background-size: 100%;--}}
{{--                background-repeat: no-repeat;--}}
{{--            }--}}

{{--            .loginInputDiv {--}}
{{--                background-color: #f9f9f9;--}}
{{--                height: 30px;--}}
{{--                padding: 5px 5px 5px 15px;--}}
{{--                border-top: 4px solid #e9e9e9;--}}
{{--                border-right: 4px solid #e9e9e9;--}}
{{--                border-radius: 5px;--}}
{{--                margin: 0 0 20px 0;--}}
{{--            }--}}

{{--            .loginInput {--}}
{{--                width: 80%;--}}
{{--                background-color: #f9f9f9;--}}
{{--                border: none;--}}
{{--                height: 30px;--}}
{{--                float: left;--}}
{{--                padding: 5px 10px;--}}
{{--            }--}}

{{--            .loginIconDiv {--}}
{{--                width: 15%;--}}
{{--                height: 30px;--}}
{{--                float: right;--}}
{{--                border-left: 1.5px solid #e9e9e9;--}}
{{--                padding-left: 5px;--}}
{{--            }--}}

{{--            .loginIcon {--}}
{{--                width: 100%;--}}
{{--                line-height: 30px;--}}
{{--                font-size: 1.35em;--}}
{{--                text-align: center;--}}
{{--                color: #04C582;--}}
{{--            }--}}

{{--            .rememberMe {--}}
{{--                display: inline-block;--}}
{{--                font-size: 0.7em;--}}
{{--                font-weight: 500;--}}
{{--                color: #cecece;--}}
{{--                margin: 0 25px 0px 0;--}}
{{--            }--}}

{{--            .loginBtnDiv {--}}
{{--                display: flex;--}}
{{--                justify-content: center;--}}
{{--                margin-bottom: 35px;--}}
{{--                margin-top: 35px;--}}
{{--            }--}}

{{--            .loginBtn {--}}
{{--                width: 50%;--}}
{{--                background-color: #04C582;--}}
{{--                padding: 5px 20px;--}}
{{--                font-size: 1.5em;--}}
{{--                font-weight: 600;--}}
{{--                color: white;--}}
{{--                height: 30px;--}}
{{--                line-height: 25px;--}}
{{--                border-radius: 5px;--}}
{{--                text-align: center;--}}
{{--                cursor: pointer;--}}
{{--            }--}}

{{--            .loginDownArrow {--}}
{{--                position: absolute;--}}
{{--                bottom: 5px;--}}
{{--                left: 50%;--}}
{{--                transform: translate(-50%);--}}
{{--                font-size: 6.5em;--}}
{{--            }--}}

{{--            .loginDownArrowIcon {--}}
{{--                line-height: 0;--}}
{{--                color: #04C582;--}}
{{--            }--}}

{{--            .loginErr {--}}
{{--                font-size: 0.9em;--}}
{{--                font-weight: 600;--}}
{{--                text-align: center;--}}
{{--                color: red;--}}
{{--            }--}}


{{--            @media only screen and (max-width:350px) {--}}
{{--                .loginBody {--}}
{{--                    width: 240px;--}}
{{--                }--}}
{{--            }--}}

{{--        </style>--}}
        {{--end of the style of login--}}
    @show
</head>

<body style="font-family: IRANSans; direction: rtl">

@include("layouts.header")

@yield("content")

@if(!\Illuminate\Support\Facades\Auth::check())

{{--    <div class="loginBody">--}}
{{--        <div class="loginTitle">--}}
{{--            <div class="loginTitleImg"></div>--}}
{{--        </div>--}}

{{--        <form id="loginForm" action="{{route('doLogin')}}" method="post">--}}
{{--            {{csrf_field()}}--}}
{{--            <div>--}}
{{--                <div class="loginInputDiv">--}}
{{--                    <div class="loginIconDiv">--}}
{{--                        <i class="fa fa-user loginIcon" aria-hidden="true"></i>--}}
{{--                    </div>--}}
{{--                    <input class="loginInput" name="username" type="text" placeholder="نام کاربری">--}}
{{--                </div>--}}
{{--                <div class="loginInputDiv">--}}
{{--                    <div class="loginIconDiv">--}}
{{--                        <i class="fa fa-lock loginIcon" aria-hidden="true"></i>--}}
{{--                    </div>--}}
{{--                    <input onkeyup="handleEnter(event)" class="loginInput" name="password" type="password" placeholder="رمز عبور">--}}
{{--                </div>--}}
{{--                <div class="relative">--}}
{{--                    <input name="remember" class="absolute" type="checkbox">--}}
{{--                    <div class="rememberMe">مرا به خاطر بسپار</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="loginBtnDiv">--}}
{{--                <div class="loginBtn">ورود</div>--}}
{{--            </div>--}}
{{--            <div class="loginErr">--}}
{{--                <p id="loginErr"></p>--}}
{{--            </div>--}}
{{--        </form>--}}

{{--        <div class="loginDownArrow">--}}
{{--            <i class="fa fa-lock fa-sort-desc loginDownArrowIcon" aria-hidden="true"></i>--}}
{{--        </div>--}}
{{--    </div>--}}

@endif

@include("layouts.footer")
@if(\Illuminate\Support\Facades\Auth::check())
    @include("layouts.support")
@endif

</body>
