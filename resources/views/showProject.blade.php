@extends('layouts.siteStructure2')

@section('header')
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/product.css")}}">

@stop

@section("content")

    <div class="eachProduct row">
        <div class="pr_descript col-sm-7 col-xs-12">
            <div class="pr_descriptRow pr_title">{{$project->title}}</div>

            <div class="pr_descriptRow pr_salesman">سفارش مدرسه سراج</div>

            <div class="pr_descriptRow pr_iconesBox">
                <div class="pr_icons coinIcon"></div>
                <div>قیمت: {{$project->price}} سکه</div>
            </div>

            <div class="pr_descriptRow">
                <div class="pr_iconesBox">
                    <div class="pr_icons coinIcon"></div>
                    <div>توضیحات:</div>
                </div>
                <div class="pr_description">
                    <div>{!! $project->description !!}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-xs-12" style="padding-right: 0 !important;">
            <div class="pr_pics">
                <div class="pr_otherPics">
                    @foreach($project->pics as $pic)
                        <div data-url="{{$pic}}" style="background-image: url('{{$pic}}'); background-size: contain; cursor:pointer;" class="pr_eachOtherPics"></div>
                    @endforeach
                </div>
                @if(count($project->pics) > 0)
                    <div style="background-image: url('{{$project->pics[0]}}'); background-size: contain;" id="pr_mainPic" class="pr_mainPic"></div>
                @else
                    <div style="background-image: url('{{\Illuminate\Support\Facades\URL::asset("productPic/defaultPic.jpg")}}'); background-size: contain;" id="pr_mainPic" class="pr_mainPic"></div>
                @endif
            </div>
            @if($canBuy)
                <div data-toggle="modal" data-target="#confirmationModal" class="shopBtn shopDownloadBtn">انتخاب و دریافت پروژه</div>
            @else
                <a style="display: block" download href="{{route('downloadAllProjectAttaches', ["pId" => $project->id])}}" class="shopBtn downloadBtn">دریافت پروژه</a>
            @endif
        </div>

        @if(count($project->attach) > 0)

            <div class="pr_advertiseBox col-sm-12">
                <div class="pr_iconesBox">
                    <div class="pr_icons coinIcon"></div>
                    <div>فایل های آموزشی:</div>
                </div>
                <div class="pr_advertise row">

                    @foreach($project->attach as $pic)
                        @if($pic["type"] == "png" || $pic["type"] == "jpg" || $pic["type"] == "gif" || $pic["type"] == "bmp" || $pic["type"] == "jpeg")
                            <div class="col-xs-12">
                                <img style="width: 250px; margin: 10px; float: right" src="{{$pic["path"]}}">
                            </div>
                        @elseif($pic["type"] == "mp4")
                            <div class="col-xs-12">
                                <video width="320" height="240" controls>
                                    <source src="{{$pic["path"]}}" type="video/mp4">
                                    مرورگر شما از پخش ویدیو پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                                </video>
                            </div>
                        @elseif($pic["type"] == "mp3")
                            <div class="col-xs-12">
                                <audio controls>
                                    <source src="{{$pic["path"]}}" type="audio/mpeg">
                                    مرورگر شما از پخش موزیک پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                                </audio>
                            </div>
                        @elseif($pic["type"] == "pdf")
                            <div class="col-xs-12">
                                <embed src="{{$pic["path"]}}" width="800px" height="800px" />
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
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">نتیجه خرید</h4>
                </div>
                <div class="modal-body">
                    <p>این پروژه با موفقیت برای شما انتخاب شد.</p>
                    <p>بزودی معام راهنما برای انجام این پروژه با شما تماس خواهد گرفت.</p>
                    <p>برای دسترسی به تمام فایل های آموزشی این پروژه می توانید با کلیک بر روی لینک زیر آن ها را دانلود کنید.</p>
                    <p><span>موفق باشی</span><span>&#128522;</span></p>
                    <a download href="{{route('downloadAllProjectAttaches', ["pId" => $project->id])}}">دانلود تمام فایل ها به طور یکجا</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">متوجه شدم</button>
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
                        $("#resultModalBtn").click();
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
