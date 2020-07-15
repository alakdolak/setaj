@extends('layouts.siteStructure2')

@section('header')
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/product.css")}}">

@stop

@section("content")

    <div class="eachProduct row">
        <div class="pr_descript col-sm-7 col-xs-12">
            <div class="pr_descriptRow pr_title">{{$service->title}}</div>
            <div class="pr_descriptRow pr_salesman">سفارش مدرسه سراج</div>

            <div class="pr_descriptRow pr_iconesBox">
                <div class="pr_icons starIcon"></div>
                <div>ستاره ی دریافتی: {{$service->star}}</div>
            </div>
            <div class="pr_descriptRow">
                <div class="pr_iconesBox">
                    <div class="pr_icons coinIcon"></div>
                    <div>توضیحات:</div>
                </div>
                <div class="pr_description">
                    <div>{!! $service->description !!}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-xs-12" style="padding-right: 0 !important;">
            <div class="pr_pics">
                <div class="pr_otherPics">
                    @foreach($service->pics as $pic)
                        <div data-url="{{$pic}}" style="background-image: url('{{$pic}}'); background-size: contain; cursor:pointer;" class="pr_eachOtherPics"></div>
                    @endforeach
                </div>
                @if(count($service->pics) > 0)
                    <div style="background-image: url('{{$product->pics[0]}}'); background-size: contain;" id="pr_mainPic" class="pr_mainPic"></div>
                @else
                    <div style="background-image: url('{{\Illuminate\Support\Facades\URL::asset("productPic/defaultPic.jpg")}}'); background-size: contain;" id="pr_mainPic" class="pr_mainPic"></div>
                @endif
            </div>
            @if($canBuy)
                <div data-toggle="modal" data-target="#confirmationModal" class="shopBtn shopDownloadBtn">خرید و دریافت محصول</div>
                <div data-toggle="modal" data-target="#confirmationModal" class="shopBtn downloadBtn">دریافت محصول</div>
                <div data-toggle="modal" data-target="#confirmationModal" class="shopBtn doneBtn">تمام شد</div>
            @else
                <div style="background-color: #ccc !important; cursor: not-allowed" disabled class="shopBtn">خرید محصول</div>
            @endif
        </div>

    </div>

    <div id="confirmationModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">آیا مطمئنی میخوای بخری؟</h4>
                </div>
                <div class="modal-body">
                    <p>بعد خرید دهنت سرویس میشه ها. مطمئنی میخوای بخری؟</p>
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
                    <p>خرید شما با موفقیت انجام شد و با کلیک بر روی دکمه زیر می توانید همه فایل های آموزشی را به طور یکجا دانلود کنید.</p>
                    <a>دانلود تمام فایل ها به طور یکجا</a>
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
                url: '{{route('buyService')}}',
                data: {
                    id: '{{$service->id}}'
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
                    id: '{{$service->id}}',
                    mode: '{{getValueInfo('serviceMode')}}'
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
                    id: '{{$service->id}}',
                    mode: '{{getValueInfo('serviceMode')}}'
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
