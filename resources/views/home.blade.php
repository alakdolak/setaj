<html>
<head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/v4-shims.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/general.css")}}">
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/myFont.css")}}">
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/home.css")}}">
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/login.css")}}">
</head>
<body>
<div class="homeBodyDiv">
    <div class="homePic">

        @if($reminder != -1)
            <div class="nextEvent">
                <div class="nextEventLogoDiv">
                    <div class="nextEventLogo"></div>
                </div>
                <div class="nextEventTextDiv">
                    <div class="nextEventText">شروع برنامه‌ی بعدی:</div>
                    <div class="nextEventTime">{{$reminder["day"]}} روز - {{$reminder["time"]}} ساعت</div>
                </div>
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Auth::check())
            <div class="homeLoginBtn" onclick="document.location.href = '{{route('choosePlan')}}'">
                <div class="homeLoginBtnText">
                    ورود به ســــــایت
                </div>
            </div>
        @else
            <div class="homeLoginBtn" onclick="showLogin()">
                <div class="homeLoginBtnText">
                    ورود به ســــــایت
                </div>
            </div>
        @endif

    </div>
{{--    onmouseleave="hideLogin()"--}}
    <div class="loginBody hidden">
        <div class="loginTitle">
            <div class="loginTitleImg"></div>
        </div>

        <form id="loginForm" action="{{route('doLogin')}}" method="post">

            {{csrf_field()}}
            <div>
                <div class="loginInputDiv">
                    <div class="loginIconDiv">
                        <i class="fa fa-user loginIcon" aria-hidden="true"></i>
                    </div>
                    <input class="loginInput" name="username" type="text" placeholder="نام کاربری">
                </div>
                <div class="loginInputDiv">
                    <div class="loginIconDiv">
                        <i class="fa fa-lock loginIcon" aria-hidden="true"></i>
                    </div>
                    <input class="loginInput" name="password" type="password" placeholder="رمز عبور">
                </div>
                <div class="relative">
                    <input name="remember" class="absolute" type="checkbox">
                    <div class="rememberMe">مرا به خاطر بسپار</div>
                </div>
            </div>
            <div class="loginBtnDiv">
                <div class="loginBtn">ورود</div>
            </div>
            <div style="text-align: center;">
                <p id="loginErr"></p>
            </div>
            <div class="loginDownArrow">
                <i class="fa fa-lock fa-sort-desc loginIcon loginDownArrowIcon" aria-hidden="true"></i>
            </div>
        </form>
    </div>
</div>

    <script>

        function showLogin() {
            $(".homePic").addClass("blur");
            $(".loginBody").removeClass("hidden");
        }
        function hideLogin() {
            $(".homePic").removeClass("blur");
            $(".loginBody").addClass("hidden");
        }

        $(document).ready(function () {

            setTimeout(function () {
                document.location.reload();
            }, 1000 * 60 * 5);

            @if(isset($loginErr))
                $("#loginErr").append('{{$loginErr}}');
                showLogin();
            @endif

            $(".loginBtn").on("click", function () {
                $("#loginForm").submit();
            });

        });

    </script>
</body>
</html>
