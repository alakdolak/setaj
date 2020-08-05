@extends('layouts.siteStructure2')

@section('header')
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/product.css?v=1.4")}}">

@stop

@section("content")


{{--    <div class="zoomContainer __web-inspector-hide-shortcut__" style="-webkit-transform: translateZ(0);position:absolute;left:950.9091186523438px;top:336.8181915283203px;height:345.682px;width:345.682px;">--}}
{{--        <div class="zoomLens" style="background-position: 0px 0px; float: right; overflow: hidden; z-index: 999; transform: translateZ(0px); opacity: 0.4; zoom: 1; width: 141.244px; height: 157.447px; background-color: transparent; cursor: crosshair; border: 2.5px solid rgb(239, 86, 97); background-repeat: no-repeat; position: absolute; left: 78.8805px; top: 188.239px; display: none;">&nbsp;</div>--}}
{{--        <div class="zoomWindowContainer" style="width: 523px;">--}}
{{--            <div style="overflow: hidden; background-position: -284.152px -699px; text-align: center; background-color: rgb(255, 255, 255); width: 523px; height: 583px; float: left; background-size: 1280px 1280px; z-index: 100; border: 1px solid rgb(136, 136, 136); background-repeat: no-repeat; position: absolute; background-image: url(&quot;https://dkstatics-public.digikala.com/digikala-products/121470106.jpg?x-oss-process=image/resize,w_1280/quality,q_80&quot;); top: -138.659px; left: -523px; display: none;" class="zoomWindow">&nbsp;</div>--}}
{{--        </div>--}}
{{--    </div>--}}


    <div class="eachProduct row">

        <div class="pr_descript col-sm-7 col-xs-12">
            <div class="pr_descriptRow pr_title">{{$product->name}}</div>
            <div class="pr_descriptRow pr_salesman">فروشنده: {{$product->owner}}</div>
            <div class="pr_descriptRow pr_iconesBox">
                <div class="pr_icons coinIcon"></div>
                <div>قیمت: {{$product->price}} سکه</div>
            </div>
            <div class="pr_descriptRow pr_iconesBox">
                <div class="pr_icons starIcon"></div>
                <div>ستاره ی دریافتی: {{$product->star}}</div>
            </div>
            @if(!empty($product->description))
                <div class="pr_descriptRow">
                    <div class="pr_iconesBox">
                        <div class="pr_icons folderIcon"></div>
                        <div>توضیحات:</div>
                    </div>
                    <div class="pr_description">
                        <div class="should_be_iransans">{!! $product->description !!}</div>
                    </div>
                </div>
            @endif

            @if(count($product->trailer) > 0)
{{--                <div class="pr_advertiseBox">--}}
                <div class="pr_descriptRow">
                    <div class="pr_iconesBox" style="margin-bottom: 7px">
                        <div class="pr_icons movieIcon"></div>
                        <div>تبلیغات:</div>
                    </div>
{{--                    <div class="pr_advertise pr_advertise_product col-xs-12">--}}
                    <div class="pr_advertise col-xs-12" style="margin-right: 0 !important;">

                        @foreach($product->trailer as $pic)
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
                        @endforeach

                    </div>
                </div>
            @endif

        </div>

        <div class="pr_picsBox col-sm-5 col-xs-12">
            <div class="pr_pics pr_productPics">
                <div class="pr_otherPics">
                    @foreach($product->pics as $pic)
                        <div data-url="{{$pic}}" style="background-image: url('{{$pic}}');" class="pr_eachOtherPics"></div>
                    @endforeach
                </div>
                @if(count($product->pics) > 0)
                    <div style="background-image: url('{{$product->pics[0]}}');" id="pr_mainPic" class="pr_mainPic"></div>
                @else
                    <div style="background-image: url('{{\Illuminate\Support\Facades\URL::asset("productPic/defaultPic.jpg")}}');" id="pr_mainPic" class="pr_mainPic"></div>
                @endif
            </div>
            @if($product->user_id == \Illuminate\Support\Facades\Auth::user()->id)
                <div class="shopBtn doneBtn">شما قادر به خرید محصول خود نیستید</div>
            @else
{{--                @if($canBuy)--}}
                    <div data-toggle="modal" data-target="#confirmationModal" class="shopBtn shopDownloadBtn">خرید و دریافت محصول</div>
{{--                @else--}}
{{--                    <div class="shopBtn doneBtn">شما امکان خرید ندارید</div>--}}
{{--                @endif--}}
            @endif
        </div>

        @if(count($product->attach) > 0)

            <div class="pr_advertiseBox col-xs-12">
                <div class="pr_iconesBox">
                    <div class="pr_icons movieIcon"></div>
                    <div>فایل های آموزشی:</div>
                </div>
                <div class="pr_advertise col-xs-12">

                    @foreach($product->attach as $pic)
                        @if($pic["type"] == "png" || $pic["type"] == "jpg" || $pic["type"] == "gif" || $pic["type"] == "bmp" || $pic["type"] == "jpeg")
                            <div class="eachAdvType col-xs-12">
                                <img style="width: 100%;" src="{{$pic["path"]}}">
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
                    @endforeach

                </div>
            </div>

        @endif

    </div>

    <div id="confirmationModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div id="confirmationModalDialog" class="modal-content">
                <div class="modal-header">
                    <button id="closeConfirmationModalBtn" type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">آیا از خرید این محصول مطمئنید؟!</h4>
                </div>
                <div class="modal-body">
                    <p>وضعیت شما پس از خرید این محصول به شرح زیر است:</p>
                    <p>تعداد ستاره های فعلی شما {{\Illuminate\Support\Facades\Auth::user()->stars}}  است که با توجه به خرید این محصول به {{\Illuminate\Support\Facades\Auth::user()->stars + $product->star}}  ارتقا پیدا خواهد کرد.</p>
                    <p>تعداد خریدهای باقی مانده:{{$myReminder}}</p>
                </div>
                <div class="modal-footer">
                    <button onclick="buy()" type="button" class="btn btn-success">بله</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    <div class="alert alert-warning hidden" role="alert">شما اجازه خرید این محصول را ندارید.</div>
                </div>
            </div>

            <div id="confirmationModalDialogAlert" class="modal-content alertDiv hidden">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div id="alertText"></div>
                </div>
            </div>
        </div>
    </div>


    <div id="resultModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">خرید شما با موفقیت ثبت شد</h4>
                </div>
                <div class="modal-body">
                    <p>بزودی محصول شما به دستتان خواهد رسید.</p>
                    <p><span>متشکر از مشارکت شما</span><span>&#128522;</span></p>
                </div>
                <div class="modal-footer">
                    <button onclick="document.location.href = '{{route('profile')}}'" type="button" class="btn btn-danger">متوجه شدم</button>
                </div>
            </div>

        </div>
    </div>

    <button class="hidden" id="resultModalBtn" data-toggle="modal" data-target="#resultModal"></button>

    <script>

        $(".thumb-wrapper").on('click', function () {

            $("#my_gallery").removeClass('remodal-is-closed').addClass('remodal-is-opened');

        });

        function buy() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('buyProduct')}}',
                data: {
                    id: '{{$product->id}}'
                },
                success: function (res) {

                    if(res === "ok") {
                        $("#closeConfirmationModalBtn").click();
                        $("#resultModalBtn").click();
                    }
                    else {

                        if(res === "nok1") {
                            $("#alertText").empty().append("<div>شما اجازه خرید این محصول را ندارید</div>");
                        }
                        else if(res === "nok2") {
                            $("#alertText").empty().append("<div>این محصول قبلا به فروش رسیده است و شما اجازه خرید مجدد آن را ندارد.</div>");
                        }
                        else if(res === "nok3") {
                            $("#alertText").empty().append("<div>متاسفانه سکه کافی برای خریداری این پروژه ندارید</div>");
                        }
                        else {
                            $("#alertText").empty().append("<div>عملیات مورد نظر غیرمجاز است</div>");
                        }

                        $("#confirmationModalDialog").addClass("hidden");
                        $("#confirmationModalDialogAlert").removeClass("hidden");
                    }

                }
            });
        }

        $(document).ready(function () {

            $(".pr_eachOtherPics").on("click", function () {

                $("#pr_mainPic").css("background-image", "url('" + $(this).attr('data-url') + "')");

            });

        });

        function bookmark() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('bookmark')}}',
                data: {
                    id: '{{$product->id}}',
                    mode: '{{getValueInfo('productMode')}}'
                },
                success: function (res) {
                    if(res === "ok")
                        $("#bookmark").removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
                    else
                        $("#bookmark").removeClass('glyphicon-heart').addClass('glyphicon-heart-empty');
                }
            });

        }

        function like() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('like')}}',
                data: {
                    id: '{{$product->id}}',
                    mode: '{{getValueInfo('productMode')}}'
                },
                success: function (res) {
                    if(res === "ok")
                        $("#like").removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
                    else
                        $("#like").removeClass('glyphicon-heart').addClass('glyphicon-heart-empty');
                }
            });

        }

    </script>
@stop
