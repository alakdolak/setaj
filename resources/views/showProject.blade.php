@extends('layouts.siteStructure2')

@section('header')
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/product.css?v=1.3")}}">
@stop

@section("content")

    <div class="eachProduct row">
        <div class="pr_descript col-sm-7 col-xs-12">
            <div class="pr_descriptRow pr_title">{{$project->title}}</div>

            <div class="pr_descriptRow pr_salesman">سفارش مدرسه سراج</div>

            <div class="pr_descriptRow pr_iconesBox">
                <div class="pr_icons coinIcon"></div>
                @if($project->price == "رایگان")
                    <div>قیمت: {{$project->price}}</div>
                @else
                    <div>قیمت: {{$project->price}} سکه</div>
                @endif
            </div>

            @if(!empty($project->description))
                <div class="pr_descriptRow">
                    <div class="pr_iconesBox">
                        <div class="pr_icons folderIcon"></div>
                        <div>توضیحات:</div>
                    </div>
                    <div class="pr_description">
                        <div class="should_be_iransans">{!! $project->description !!}</div>
                    </div>
                </div>
            @endif
        </div>
        <div class="pr_picsBox col-sm-5 col-xs-12">
            <div class="pr_pics">
                <div class="pr_otherPics">
                    @foreach($project->pics as $pic)
                        <div data-url="{{$pic}}" style="background-image: url('{{$pic}}');" class="pr_eachOtherPics"></div>
                    @endforeach
                </div>
                @if(count($project->pics) > 0)
                    <div style="background-image: url('{{$project->pics[0]}}');" id="pr_mainPic" class="pr_mainPic"></div>
                @else
                    <div style="background-image: url('{{\Illuminate\Support\Facades\URL::asset("productPic/defaultPic.jpg")}}');" id="pr_mainPic" class="pr_mainPic"></div>
                @endif
            </div>
            @if($canBuy)
                <div data-toggle="modal" data-target="#confirmationModal" class="shopBtn shopDownloadBtn">انتخاب پروژه و دریافت آموزش</div>
            @else
                <a style="display: block" download href="{{route('downloadAllProjectAttaches', ["pId" => $project->id])}}" class="shopBtn downloadBtn">دانلود آموزش</a>
            @endif
        </div>

        @if(count($project->attach) > 0)

            <div class="pr_advertiseBox col-xs-12">
                <div class="pr_iconesBox" style="margin-bottom: 15px">
                    <div class="pr_icons movieIcon"></div>
                    <div>فایل های آموزشی:</div>
                </div>
                <div class="pr_advertise col-xs-12">

                    @foreach($project->attach as $pic)
                        @if($pic["type"] == "png" || $pic["type"] == "jpg" || $pic["type"] == "gif" || $pic["type"] == "bmp" || $pic["type"] == "jpeg")
                            <div class="col-xs-12">
                                <img style="width: 100%;" src="{{$pic["path"]}}">
                            </div>
                        @elseif($pic["type"] == "mp4" || $pic["type"] == "m4v")
                            <div class="col-xs-12" style="padding: 15px !important;">
                                <video style="width: 100%" controls>
                                    <source src="{{$pic["path"]}}" type="video/mp4">
                                    مرورگر شما از پخش ویدیو پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                                </video>
                            </div>
                        @elseif($pic["type"] == "mp3" || $pic["type"] == "ogg" || $pic["type"] == "m4a" || $pic["type"] == "aac")
                            <div class="col-xs-12">
                                <audio style="width: 100%;" controls>
                                    <source src="{{$pic["path"]}}" type="audio/mpeg">
                                    مرورگر شما از پخش موزیک پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                                </audio>
                            </div>
                        @elseif($pic["type"] == "pdf")
                            <div class="col-xs-12">
                                <embed style="width: 100%" src="{{$pic["path"]}}" height="800px" />
                            </div>
                        @else
                            <div class="col-xs-12">
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

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">انتخاب پروژه</h4>
                </div>
                <div class="modal-body">
                    <p>آیا از انتخاب این پروژه مطمئنید؟!</p>
                </div>
                <div class="modal-footer">
                    <button onclick="buy()" type="button" class="btn btn-success" data-dismiss="modal">بله</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                </div>
            </div>

        </div>
    </div>


    <div id="resultModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">این پروژه با موفقیت برای شما انتخاب شد</h4>
                </div>
                <div class="modal-body">
                    <p>از الآن تا روز سه‌شنبه یا چهارشنبه که با معلم راهنمایت قرار داری؛ فرصت داری تا پروژه‌ات را به اتمام برسانی. در ضمن اگر برای انجام این پروژه، به مواد اولیه خاصی احتیاج داری؛ مطمئن باش بزودی به دستت خواهد رسید</p>
                    <p>برای دسترسی به تمام فایل های آموزشی این پروژه می توانید با کلیک بر روی لینک زیر آن ها را دانلود کنید.</p>
                    <p><span>موفق باشی</span><span>&#128522;</span></p>
                    <a download href="{{route('downloadAllProjectAttaches', ["pId" => $project->id])}}">دانلود تمام فایل ها به طور یکجا</a>
                </div>
                <div class="modal-footer">
                    <button onclick="document.location.reload()" type="button" class="btn btn-danger">متوجه شدم</button>
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
                url: '{{route('buyProject')}}',
                data: {
                    id: '{{$project->id}}'
                },
                success: function (res) {

                    if(res === "nok1") {
                        alert("شما اجازه خرید این محصول را ندارید.");
                    }

                    else if(res === "nok2") {
                        alert("شما قبلا این محصول را خریداری کرده اید.");
                    }

                    else if(res === "nok3") {
                        alert("متاسفانه سکه کافی برای خریداری این پروژه ندارید.");
                    }

                    else if(res === "nok5") {
                        alert("عملیات مورد نظر غیرمجاز است.");
                    }

                    else if(res === "ok") {
                        $("#resultModalBtn").click();
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
                    id: '{{$project->id}}',
                    mode: '{{getValueInfo('projectMode')}}'
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
                    id: '{{$project->id}}',
                    mode: '{{getValueInfo('projectMode')}}'
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
