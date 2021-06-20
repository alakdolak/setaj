@extends('layouts.siteStructure2')

@section('header')
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/product.css?v=1.4")}}">

    <style>
        .uploadBody {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 30em;
            height: 34em;
            margin-top: -17em;
            margin-left: -15em;
            background-color: white;
            border-radius: 7px;
            border-bottom: 15px solid #04c582;
        }
        .uploadBorder {
            width: 100%;
            height: -webkit-fill-available;
            border-top: 40px solid #f9f9f9;
            border-bottom: 40px solid #f9f9f9;
            border-radius: 7px;
        }
        .uploadHeader {
            width: 60%;
            height: 70px;
            background-color: #ffc20e;
            margin: -40px auto 0;
            border-radius: 0 0 10px 10px;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }
        .uploadHeader_images {
            width: 50px;
            height: 40px;
            background-repeat: no-repeat;
            /*background-size: 100% 100%;*/
            background-size: contain;
        }
        .uploadHeader_img1 {
            background-image: url("../../public/images/uploadPics/sound.png");
        }
        .uploadHeader_img2 {
            background-image: url("../../public/images/uploadPics/pic.png");
        }
        .uploadHeader_img3 {
            background-image: url("../../public/images/uploadPics/video.png");
        }
        .uploadHeader_img4 {
            background-image: url("../../public/images/uploadPics/file.png");
        }
        .uploadBtn {
            width: 80%;
            height: 60px !important;
            line-height: 60px;
            background-image: linear-gradient(to bottom right, #ffc438, red) !important;
            border: none !important;
            border-radius: 100px !important;
            box-shadow: 0px 0px 20px 5px #ff8900;
            color: white;
            padding: 0px !important;
            min-height: 0px !important;
            margin: 35px;
            font-size: 1.75em;
            font-weight: 500;
            text-align: center;
        }
        .uploadDescript {
            padding: 50px 35px 0;
            text-align: center;
        }
        .uploadTitleText {
            font-size: 1.5em;
            font-weight: 700;
            padding: 10px;
        }
        .uploadfooter_image {
            width: 65px;
            height: 65px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 70px auto 0px;
            background-color: #f9f9f9;
            border-radius: 50%;
            box-shadow: 0px 0px 10px 2px #fff;
        }
        .uploadfooter_img1 {
            background-image: url("../../public/images/uploadPics/laptop.png");
            width: 50px;
            height: 35px;
            background-repeat: no-repeat;
            background-size: contain;
        }
</style>

    <script src="{{\Illuminate\Support\Facades\URL::asset('dropzone/dropzone.js')}}"></script>
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("dropzone/dropzone.css")}}">
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
                @if($canAddAdv)
                    <div onclick="$('#advId').val({{$project->pbId}})" data-toggle="modal" data-target="#advModal" class="shopBtn shopDownloadBtn">افزودن تبلیغ</div>
                    @if($canAddFile)
                        <div data-toggle="modal" data-target="#contentModal" class="shopBtn shopDownloadBtn">افزودن محتوا</div>
                    @endif
                @endif
                <a style="display: block" download href="{{route('downloadAllProjectAttaches', ["pId" => $project->id])}}" class="shopBtn downloadBtn">دانلود آموزش</a>
            @endif

            @if($advStatus == 1)
                <p>تبلیغ شما به تایید معلم راهنما رسید.</p>
            @elseif($advStatus == 0)
                <p>تبلیغ شما در حال بررسی توسط معلم راهنما می باشد.</p>
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
                                <audio style="width: 100%;" controls>
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
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">انتخاب پروژه</h4>
                </div>
                <div class="modal-body">
                    <p>آیا از انتخاب این پروژه مطمئنید؟!</p>
                </div>
                <div class="modal-footer">
                    <button onclick="buy()" type="button" class="btn btn-success">بله</button>
                    <button type="button" id="closeConfirmationModalBtn" class="btn btn-danger" data-dismiss="modal">انصراف</button>
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

    <div id="advModal" class="modal fade" role="dialog">
        <div class="uploadBody">
            <div class="uploadBorder">
                <div class="uploadHeader">
                    <div class="uploadHeader_images uploadHeader_img1"></div>
                    <div class="uploadHeader_images uploadHeader_img2"></div>
                    <div class="uploadHeader_images uploadHeader_img3"></div>
                    <div class="uploadHeader_images uploadHeader_img4"></div>
                </div>
                <div class="uploadDescript">
                    <div class="uploadTitleText">بارگزاری فایل تبلیغ</div>
                    <div>فایل های خود را اینجا بکشـــید و <br>یا فایل خود را با کلیک انتخاب کنید</div>
                    <form action="{{route('addAdv')}}" class="dropzone uploadBtn" id="my-awesome-dropzone">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$project->pbId}}">
                    </form>
                </div>
                <div class="uploadfooter_image">
                    <div class="uploadfooter_img1"></div>
                </div>

            </div>
        </div>
{{--        <div class="modal-dialog">--}}
{{--            <div id="confirmationModalDialog" class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
{{--                    <h4 class="modal-title">انتخاب پروژه</h4>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <p>آیا از انتخاب این پروژه مطمئنید؟!</p>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button onclick="buy()" type="button" class="btn btn-success">بله</button>--}}
{{--                    <button type="button" id="closeConfirmationModalBtn" class="btn btn-danger" data-dismiss="modal">انصراف</button>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div id="confirmationModalDialogAlert" class="modal-content alertDiv hidden">--}}
{{--                <div class="modal-body">--}}
{{--                    <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
{{--                    <div id="alertText"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

    <div id="contentModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">افزودن محتوا</h4>
                </div>

                <form action="{{route('addAdv')}}" class="dropzone" id="my-awesome-dropzone">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$project->pbId}}">
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success">بله</button>
                    <button type="button" id="closeContentModalBtn" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                </div>
            </div>

            <div class="modal-content alertDiv hidden">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                    <button onclick="document.location.href = '{{route('profile')}}'" type="button" class="btn btn-danger">متوجه شدم</button>
                </div>
            </div>

        </div>
    </div>

    <button class="hidden" id="resultModalBtn" data-toggle="modal" data-target="#resultModal"></button>

    <script>

        Dropzone.options.myAwesomeDropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            accept: function(file, done) {
                done();
            }
        };

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

                    if(res === "ok") {
                        $("#closeConfirmationModalBtn").click();
                        $("#resultModalBtn").click();
                    }
                    else {

                        if(res === "nok1") {
                            $("#alertText").empty().append("<div>شما اجازه خرید این محصول را ندارید</div>");
                        }
                        else if(res === "nok2") {
                            $("#alertText").empty().append("<div>شما قبلا این محصول را خریداری کرده اید</div>");
                        }
                        else if(res === "nok9") {
                            $("#alertText").empty().append("<div>حتما باید یه عینی بخری</div>");
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

    </script>
@stop

