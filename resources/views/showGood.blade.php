@extends('layouts.siteStructure2')

@section('header')
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/product.css?v=1.5")}}">
@stop

@section("content")

    <div class="eachProduct row">

        <div class="pr_descript col-sm-7 col-xs-12">
            <div class="pr_descriptRow pr_title">{{$good->name}}</div>
            <div class="pr_descriptRow pr_salesman">فروشنده: {{$good->owner}}</div>
            <div class="pr_descriptRow pr_iconesBox">
                <div class="pr_icons coinIcon"></div>
                <div>قیمت: {{$good->price}} تومان</div>
            </div>
            <div class="pr_descriptRow pr_iconesBox">
                <div class="pr_icons folderIcon"></div>
                <div>کد محصول: {{$good->code}} </div>
            </div>
            @if(!empty($good->description))
                <div class="pr_descriptRow">
                    <div class="pr_iconesBox">
                        <div class="pr_icons folderIcon"></div>
                        <div>توضیحات:</div>
                    </div>
                    <div class="pr_description">
                        <div class="should_be_iransans">{!! $good->description !!}</div>
                    </div>
                </div>
            @endif

            @if($good->adv != null)
                <div class="pr_descriptRow">
                    <div class="pr_iconesBox" style="margin-bottom: 7px">
                        <div class="pr_icons movieIcon"></div>
                        <div>تبلیغات:</div>
                    </div>
                    <div class="pr_advertise col-xs-12" style="margin-right: 0 !important;">

                        <?php
                            $pic["path"] = $good->adv;
                            $tmp = explode(".", $good->adv);
                            $pic["type"] = $tmp[count($tmp) - 1];
                        ?>
                        @if($pic["type"] == "png" || $pic["type"] == "jpg" || $pic["type"] == "gif" || $pic["type"] == "bmp" || $pic["type"] == "jpeg")
                            <div class="eachAdvType col-xs-12">
                                <img style="width: 100%; float: right" src="{{$pic["path"]}}">
                            </div>
                        @elseif($pic["type"] == "mp4" || $pic["type"] == "m4v")
                            <div class="eachAdvType col-xs-12">
                                <video style="width: 100%" controls>
                                    <source src="{{$pic["path"]}}" type="video/mp4">
                                    مرورگر شما از پخش ویدیو پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                                </video>
                            </div>
                        @elseif($pic["type"] == "mp3" || $pic["type"] == "ogg" || $pic["type"] == "m4a" || $pic["type"] == "aac" || $pic["type"] == "amr")
                            <div class="eachAdvType col-xs-12">
                                <audio style="width: 100%" controls>
                                    <source src="{{$pic["path"]}}" type="audio/mpeg">
                                    مرورگر شما از پخش موزیک پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                                </audio>
                            </div>
                        @elseif($pic["type"] == "pdf")
                            <div class="eachAdvType col-xs-12">
                                <embed style="width: 100% !important;" src="{{$pic["path"]}}" width="800px" height="800px" />
                            </div>
                        @else
                            <div class="eachAdvType col-xs-12">
                                <a href="{{$pic["path"]}}" download>دانلود فایل</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="pr_picsBox col-sm-5 col-xs-12">
            <div class="pr_pics">
                <div class="pr_otherPics">
                    @foreach($good->pics as $pic)
                        <div data-url="{{$pic}}" style="background-image: url('{{$pic}}');" class="pr_eachOtherPics"></div>
                    @endforeach
                </div>
                @if(count($good->pics) > 0)
                    <div style="background-image: url('{{$good->pics[0]}}');" id="pr_mainPic" class="pr_bigPic"></div>
                @else
                    <div style="background-image: url('{{\Illuminate\Support\Facades\URL::asset("productPic/defaultPic.png")}}');" id="pr_mainPic" class="pr_bigPic"></div>
                @endif
            </div>

            @if($canBuy)
                @if(\Illuminate\Support\Facades\Auth::check())
                    <div data-toggle="modal" data-target="#confirmationModal" class="shopBtn shopDownloadBtn">خرید و دریافت محصول</div>
                @else
                    <div data-toggle="modal" data-target="#loginModal" class="shopBtn shopDownloadBtn">خرید و دریافت محصول</div>
                @endif
            @else
                <div class="shopBtn doneBtn">شما امکان خرید ندارید</div>
            @endif

        </div>

    </div>

    <div data-toggle="modal" id="sendModalBtn" data-target="#sendModal" class="hidden"></div>
    <div data-toggle="modal" id="loginModalBtn" data-target="#loginModal" class="hidden"></div>
    <div data-toggle="modal" id="signUpModalBtn" data-target="#signUpModal" class="hidden"></div>
    <div data-toggle="modal" id="verificationModalBtn" data-target="#verificationModal" class="hidden"></div>

    <div id="confirmationModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog">
            <div id="confirmationModalDialog" class="modal-content">
                <div class="modal-header">
                    <button id="closeConfirmationModalBtn" type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">آیا از خرید این محصول مطمئنید؟!</h4>
                </div>
                <div class="modal-footer">
                    <button onclick="chooseSendMethod()" type="button" class="btn btn-success">بله</button>
                    <button type="button" id="closeConfirmationModalBtn" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    <div class="alert alert-warning hidden" role="alert">شما اجازه خرید این محصول را ندارید.</div>
                </div>
            </div>
        </div>
    </div>

    <div id="sendModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog">
            <div id="confirmationModalDialog" class="modal-content">
                <div class="modal-header">
                    <button id="closeConfirmationModalBtn" type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">لطفا نحوه ارسال مرسوله را مشخص نمایید.</h4>
                    <label for="post">از طریق پست ارسال شود.</label>
                    <input type="radio" id="post" value="post" name="sendMethod">
                    <label for="come">به طور حضوری روز شنبه به مدرسه میام و میگیرم.</label>
                    <input type="radio" checked id="come" value="come" name="sendMethod">
                    <div id="addressDiv" class="hidden">
                        <label for="address">آدرس پستی</label>
                        <textarea id="address"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="buy()" type="button" class="btn btn-success">بله</button>
                    <button type="button" id="closeSendModalBtn" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    <div id="alertText" class="alertText acceptAlertText"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="loginModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog">
            <center class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">وارد شوید</h4>
                    <p style="margin-top: 10px">نام کاربری/شماره همراه</p>
                    <input type="text" required id="username" name="username">
                    <p>کدملی</p>
                    <input onkeypress="validate(event)" id="password" type="text" required name="password">
                </div>
                <div class="modal-footer">
                    <center>
                        <p>حساب کاربری ندارد؟</p>
                        <p style="cursor: pointer" onclick="$('#closeLoginModalBtn').click(); $('#signUpModalBtn').click()">ثبت نام کنید</p>
                    </center>
                    <button onclick="login()" class="btn btn-success">تایید</button>
                    <button id="closeLoginModalBtn" type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                </div>
            </center>
        </div>
    </div>

    <div id="signUpModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <center class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ثبت نام کنید</h4>
                    <p style="margin-top: 10px">کد ملی</p>
                    <input onkeypress="validate(event)" type="tel" name="nid" id="nid">
                    <p>نام</p>
                    <input type="text" name="name" id="name">
                    <p>نام خانوادگی</p>
                    <input type="text" name="last_name" id="last_name">
                    <p>شماره همراه</p>
                    <input onkeypress="validate(event)" type="tel" name="phone" id="phone">
                </center>
                <div class="modal-footer">
                    <button onclick="getVerificationCode()" type="button" class="btn btn-success">تایید</button>
                    <button id="closeSignUpBtn" type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    <div id="alertText2" class="alertText acceptAlertText"></div>
                </div>
            </div>

        </div>
    </div>

    <div id="verificationModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <center class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">کد ارسال شده را وارد نمایید</h4>
                    <input onkeypress="validate(event)" type="tel" name="code" id="code">

                    <div id="reminderTimeDiv">
                        <p style="margin-top: 10px">زمان باقی مانده برای ارسال مجدد کد</p><div style="margin-top: 10px" id="reminder_time"></div>
                    </div>

                    <div id="resendDiv" style="margin-top: 20px"></div>

                </center>
                <div class="modal-footer">
                    <button onclick="verify()" type="button" class="btn btn-success">تایید</button>
                    <button type="button" id="closeVerifyModalBtn" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                </div>
            </div>

        </div>
    </div>

    <script>

        var isLogin = "{{(\Illuminate\Support\Facades\Auth::check()) ? "true" : "false"}}";

        $(".thumb-wrapper").on('click', function () {

            $("#my_gallery").removeClass('remodal-is-closed').addClass('remodal-is-opened');

        });

        var token = "";
        var phone = "";

        function chooseSendMethod() {
            $("#closeConfirmationModalBtn").click();
            $("#sendModalBtn").click();
        }

        function login() {

            var username = $("#username").val();
            var password = $("#password").val();

            if(username.length === 0 || password.length === 0)
                return;

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('secondLogin')}}',
                data: {
                    username: username,
                    password: password
                },
                success: function (res) {

                    if(res === "ok")
                        document.location.reload();
                    else
                        alert("نام کاربری و یا رمزعبور اشتباه است.");
                }
            });


        }

        function getVerificationCode() {

            var phone = $("#phone").val();
            var nid = $("#nid").val();
            var name = $("#name").val();
            var lastname = $("#last_name").val();

            if(phone.length === 0 || nid.length === 0 ||
                name.length === 0 || lastname.length === 0) {
                $("#alertText2").empty().append("<p>لطفا تمام اطلاعات لازم را وارد نمایید.</p>");
                return;
            }

            $("#alertText2").empty().append("<p>در حال بررسی اطلاعات، لطفا شکیبا باشید.</p>");

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('getVerificationCode')}}',
                data: {
                    phone: phone,
                    nid: nid,
                    name: name,
                    last_name: lastname
                },
                success: function (res) {

                    res = JSON.parse(res);

                    if(res.status === "ok") {
                        token = res.token;
                        checkTime();
                        $("#closeSignUpBtn").click();
                        $("#verificationModalBtn").click();
                        $("#alertText2").empty();
                    }
                    else
                        $("#alertText2").empty().append("<p>" + res.msg + "</p>");
                }
            });
        }

        function resend() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('resend')}}',
                data: {
                    token: token,
                    phone: phone
                },
                success: function (res) {

                    if(res === "nok") {
                        alert("عملیات مورد نظر غیرمجاز است.");
                        return;
                    }

                    $("#reminderTimeDiv").css("visibility", "visible");
                    token = res;
                    total_time = 300;
                    c_minutes = parseInt(total_time / 60);
                    c_seconds = parseInt(total_time % 60);
                    $("#resendDiv").empty();
                    checkTime();
                }
            });
        }

        function verify() {

            var code = $("#code").val();
            if(code.length === 0)
                return;

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('verify')}}',
                data: {
                    token: token,
                    code: code
                },
                success: function (res) {

                    if(res === "ok") {
                        $("#closeVerifyModalBtn").click();
                        document.location.reload();
                    }
                    else {
                        alert("کد وارد شده صحیح نیست.");
                    }

                }
            });
        }

        function buy() {

            if(isLogin === "false") {
                $("#closeConfirmationModalBtn").click();
                $("#loginModalBtn").click();
                return;
            }

            var addr = $("#address").val();
            if(addr.length === 0) {
                $("#alertText").empty().append("<p>لطفا آدرس پستی را وارد نمایید.</p>");
                return;
            }

            $("#alertText").empty().append("<p>در حال اتصال به درگاه پرداخت، لطفا شکیبا باشید.</p>");

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('buyGood', ['goodId' => $good->id])}}',
                data: {
                    sendMethod: $("input[name='sendMethod']:checked").val(),
                    address: addr
                },
                success: function (res) {

                    if(res === "nok1")
                        $("#alertText").empty().append("<p>زمان شروع خرید محصول مورد نظر هنوز فرا نرسیده است.</p>");
                    else if(res === "nok2")
                        $("#alertText").empty().append("<p>این محصول قبلا به فروش رسیده است و شما اجازه خرید مجدد آن را ندارد.</p>");
                    else if(res === "nok3")
                        $("#alertText").empty().append("<p>عملیات مورد نظر غیرمجاز است</p>");
                    else
                        window.location.href = res;
                }
            });
        }

        $(document).ready(function () {

            $(".pr_eachOtherPics").on("click", function () {

                $("#pr_mainPic").css("background-image", "url('" + $(this).attr('data-url') + "')");

            });

            $("input[name='sendMethod']").on("change", function () {
                if($("input[name='sendMethod']:checked").val() === "post")
                    $("#addressDiv").removeClass('hidden');
                else
                    $("#addressDiv").addClass('hidden');
            });

        });

        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode( key );
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }

        var total_time = 300;
        var c_minutes = parseInt(total_time / 60);
        var c_seconds = parseInt(total_time % 60);

        function checkTime() {

            document.getElementById("reminder_time").innerHTML =  c_seconds + " : " + c_minutes;

            if (total_time <= 0)
                setTimeout("showResendBtn()", 1);
            else {
                total_time--;
                c_minutes = parseInt(total_time / 60);
                c_seconds = parseInt(total_time % 60);
                setTimeout("checkTime()", 1000);
            }
        }

        function showResendBtn() {

            var newElement = "<center>";
            newElement += "<input onclick='resend()' type='submit' value='ارسال مجدد کد فعال سازی'>";
            newElement += "</center>";

            $("#reminderTimeDiv").css("visibility", "hidden");
            $("#resendDiv").append(newElement);
        }

    </script>
@stop
