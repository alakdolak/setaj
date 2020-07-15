@extends('layouts.siteStructure2')

@section('header')
    @parent

    <style>
        .eachProduct {
            margin: 50px 12% 0 !important;
        }
        .pr_pics {
            display: flex;
        }
        .pr_mainPic {
            height: 320px;
            border: 3px solid #acacac;
            width: 74%;
        }
        .pr_otherPics{
            width: 22%;
            margin-left: 5%;
        }
        .pr_eachOtherPics{
            height: 70px;
            border: 3px solid #acacac;
            margin: 0 0 13px 0;
        }
        .pr_eachOtherPics:last-child{
            margin-bottom: 0;
        }
        .shopBtn{
            color: white;
            background-color: #68cda5;
            border-bottom: 5px solid #48c291;
            box-shadow: 5px 5px 5px;
            border-radius: 7px;
            padding: 15px 30px;
            margin-top: 35px;
            font-size: 1.75em;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
        }
        .shopBtn:hover {
            background-color: #48c291;
        }
        .pr_descript{
            font-size: 1.3em;
            font-weight: 500;
            color: #a4a4a4;
        }
        .pr_descriptRow{
            min-height: 50px;
            padding: 7px 20px;
            border-bottom: 2px solid #acacac;
        }
        .pr_descriptRow:nth-child(1), .pr_descriptRow:last-child{
            border-bottom: 0;
        }
        .pr_iconesBox {
            display: flex;
            align-items: center;
        }
        .pr_description {
            margin-right: 40px;
            text-align: justify;
        }
        .pr_title{
            background-color: #f26c4f;
            color: white;
            font-size: 1.1em;
            font-weight: 700;
            display: flex;
            align-items: center;
        }
        .pr_salesman{
            display: flex;
            align-items: center;
            font-weight: 600;
        }
        .pr_icons{
            width: 30px;
            height: 30px;
            background-size: 100%;
            background-repeat: no-repeat;
            margin-left: 10px;
        }
        .folderIcon{
            background-image: url(../images/folder.png);
        }
        .movieIcon{
            background-image: url(../images/movie.png);
        }
        .pr_advertiseBox {
            margin-top: 50px;
            padding: 0 !important;
            font-size: 1.3em;
            font-weight: 500;
            color: #a4a4a4;
        }
        .pr_advertise {
            margin-right: 40px;
            text-align: justify;
            border: 2px solid #a4a4a4;
            border-radius: 7px;
            padding: 5px 15px;
        }

    </style>

@stop

@section("content")

    <div class="eachProduct row">
        <div class="pr_descript col-lg-7 col-xs-12">
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
            <div class="pr_descriptRow">
                <div class="pr_iconesBox">
                    <div class="pr_icons coinIcon"></div>
                    <div>توضیحات:</div>
                </div>
                <div class="pr_description">
                    <div>{!! $product->description !!}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-xs-12" style="padding-right: 0 !important;">
            <div class="pr_pics">
                <div class="pr_otherPics">
                    @foreach($product->pics as $pic)
                        <div data-url="{{$pic}}" style="background-image: url('{{$pic}}'); background-size: contain; cursor:pointer;" class="pr_eachOtherPics"></div>
                    @endforeach
                </div>
                <div style="background-image: url('{{$product->pics[0]}}'); background-size: contain;" id="pr_mainPic" class="pr_mainPic"></div>
            </div>
            @if($canBuy)
                <div onclick="buy()" class="shopBtn">خرید محصول</div>
            @endif
            <div class="eachProduct row">

                <div class="col-lg-4 col-xs-12">

                    <div class="pr_pics">
                        <div class="pr_mainPic"></div>
                        <div class="pr_otherPics"></div>
                    </div>
                    <div class="shopBtn"></div>
                    </div>
            </div>
        </div>

        @if(count($product->attach) > 0)

            <div class="pr_advertiseBox col-lg-12">
                <div class="pr_iconesBox">
                    <div class="pr_icons coinIcon"></div>
                    <div>فایل های آموزشی:</div>
                </div>
                <div class="pr_advertise row">

                    @foreach($product->attach as $pic)
                        @if($pic["type"] == "png" || $pic["type"] == "jpg" || $pic["type"] == "gif" || $pic["type"] == "bmp" || $pic["type"] == "jpeg")
                            <center class="col-xs-12">
                                <img style="width: 250px; margin: 10px; float: right" src="{{$pic["path"]}}">
                            </center>
                        @elseif($pic["type"] == "mp4")
                            <center class="col-xs-12">
                                <video width="320" height="240" controls>
                                    <source src="{{$pic["path"]}}" type="video/mp4">
                                    مرورگر شما از پخش ویدیو پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                                </video>
                            </center>
                        @elseif($pic["type"] == "mp3")
                            <center class="col-xs-12">
                                <audio controls>
                                    <source src="{{$pic["path"]}}" type="audio/mpeg">
                                    مرورگر شما از پخش موزیک پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                                </audio>
                            </center>
                        @elseif($pic["type"] == "pdf")
                            <center class="col-xs-12">
                                <embed src="{{$pic["path"]}}" width="800px" height="800px" />
                            </center>
                        @else
                            <center class="col-xs-12">
                                <a href="{{$pic["path"]}}" download>دانلود فایل</a>
                            </center>
                        @endif
                    @endforeach

                </div>
            </div>

        @endif


        @if(count($product->trailer) > 0)

            <div class="pr_advertiseBox col-lg-12">
                <div class="pr_iconesBox">
                    <div class="pr_icons coinIcon"></div>
                    <div>تبلیغات:</div>
                </div>
                <div class="pr_advertise row">

                    @foreach($product->trailer as $pic)
                        @if($pic["type"] == "png" || $pic["type"] == "jpg" || $pic["type"] == "gif" || $pic["type"] == "bmp" || $pic["type"] == "jpeg")
                            <center class="col-xs-12">
                                <img style="width: 250px; margin: 10px; float: right" src="{{$pic["path"]}}">
                            </center>
                        @elseif($pic["type"] == "mp4")
                            <center class="col-xs-12">
                                <video width="320" height="240" controls>
                                    <source src="{{$pic["path"]}}" type="video/mp4">
                                    مرورگر شما از پخش ویدیو پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                                </video>
                            </center>
                        @elseif($pic["type"] == "mp3")
                            <center class="col-xs-12">
                                <audio controls>
                                    <source src="{{$pic["path"]}}" type="audio/mpeg">
                                    مرورگر شما از پخش موزیک پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                                </audio>
                            </center>
                        @elseif($pic["type"] == "pdf")
                            <center class="col-xs-12">
                                <embed src="{{$pic["path"]}}" width="800px" height="800px" />
                            </center>
                        @else
                            <center class="col-xs-12">
                                <a href="{{$pic["path"]}}" download>دانلود فایل</a>
                            </center>
                        @endif
                    @endforeach

                </div>
            </div>

        @endif
    </div>


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

                    if(res === "nok1") {
                        $("#buyErr").empty().append("شما اجازه خرید این محصول را ندارید.");
                    }

                    else if(res === "nok2") {
                        $("#buyErr").empty().append("شما قبلا این محصول را خریداری کرده اید.");
                    }

                    else if(res === "nok3") {
                        $("#buyErr").empty().append("متاسفانه سکه کافی برای خریداری این پروژه ندارید.");
                    }

                    else if(res === "nok5") {
                        $("#buyErr").empty().append("عملیات مورد نظر غیرمجاز است.");
                    }

                    else if(res === "ok") {
                        document.location.href = '{{route('myProducts')}}';
                    }

                }
            });
        }

        $(document).ready(function () {

            $(".pr_eachOtherPics").on("click", function () {

                $("#pr_mainPic").css("background-image", "url('" + $(this).attr('data-url') + "')").css("background-size", "contain");

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
