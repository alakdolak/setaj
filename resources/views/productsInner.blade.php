@extends("layouts.siteStructure4")


@section("header")
    @parent
    <style>
        .prInner_buyBtnBox {
            border-right: 25px solid #a1a1a1;
            border-left: 25px solid #a1a1a1;
            margin: 20px 0;
            cursor: pointer;
        }
        .prInner_buyBtn {
            line-height: 70px;
            background-color: #04c582;
            color: white;
            font-size: 2em;
            font-weight: 800;
            text-align: center;
            border-right: 25px solid #f1f1f1;
            border-left: 25px solid #f1f1f1;
        }

        /*css of modal*/
        .modal-body > .close {
            float: left;
        }

        .alertDiv {
            background-color: red;
            color: white;
            font-weight: 500;
        }

    </style>
@stop

@section("banner")

    <div class="banner">
        <div class="bannerGrayBox"></div>
        <div class="bannerBorderBox bannerLightBlueBox"></div>
        <div class="bannerMainBox productsBanner"></div>
    </div>

@stop

@section("content")

    <div class="shopBox row">

        <div class="weekContainer shopEachRow col-xs-12">

            <div class="shopEachRow col-xs-12">

                @if($canBuy)
                    <div data-toggle="modal" data-target="#confirmationModal" class="prInner_buyBtnBox">
                        <div class="prInner_buyBtn">خرید مجموعه</div>
                    </div>
                @else
                    <div style="cursor: auto;" class="prInner_buyBtnBox">
                        <div style="background-color: red !important;" class="prInner_buyBtn">شما امکان خرید ندارید</div>
                    </div>
                @endif

                @foreach($products as $product)

                    <div onclick="document.location.href = '{{route('showProduct', ['id' => $product->id])}}'" class="myItem shopOneBox col-md-3 col-sm-4 col-xs-6">

                        <div class="sh_mainBox">

                            @if($product->adv_status)
                                <div class="sh_advPic"></div>
                            @endif

                            <div style="background-image: url('{{$product->pic}}')" class="sh_mainPic"></div>
                            <div class="sh_descript">
                                <div class="sh_descriptRow sh_title">{{$product->name}}</div>
                                <div class="sh_descriptRow sh_priceBox">
                                    <div class="priceIcons coinIcon"></div>
                                    <div class="priceText">قیمت: {{$product->price}} سکه</div>
                                </div>
                                <div class="sh_descriptRow sh_priceBox">
                                    <div class="priceIcons starIcon"></div>
                                    <div class="priceText">ستاره ی دریافتی: {{$product->star}}</div>
                                </div>

                            </div>

                        </div>

                        @if(!$product->sold)
                            <div class="sh_ownerBox">
                                <div>تولیدکننده: {{$product->owner}}</div>
                            </div>
                        @else
                            <div class="sh_ownerBox_finish">
                                <div>تولیدکننده: {{$product->owner}}</div>
                            </div>
                        @endif
                    </div>

                @endforeach

            </div>
        </div>
    </div>

    @if(\Illuminate\Support\Facades\Auth::check())
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

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">خرید شما با موفقیت ثبت شد</h4>
                    </div>
                    <div class="modal-body">
                        <p>برای مشاهده تمامی محصولات دوبله به قسمت "خرید های من" در صفحه پروفایل مراجعه کنید.</p>
                        <p><span>متشکر از مشارکت شما</span><span>&#128522;</span></p>
                    </div>
                    <div class="modal-footer">
                        <button onclick="document.location.href = '{{route('profile')}}'" type="button" class="btn btn-danger">متوجه شدم</button>
                    </div>
                </div>

            </div>
        </div>

        <button class="hidden" id="resultModalBtn" data-toggle="modal" data-target="#resultModal"></button>

    @endif

    <script>

        function buy() {

            $.ajax({
                type: 'post',
                url: '{{route('buyUnPhysicalProduct')}}',
                data: {
                    projectId: '{{$projectId}}',
                    gradeId: '{{$grade}}'
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function (res) {

                    if(res === "ok") {
                        $("#closeConfirmationModalBtn").click();
                        $("#resultModalBtn").click();
                    }
                    else {

                        if(res === "nok1") {
                            $("#alertText").empty().append("<div>زمان شروع خرید محصول مورد نظر هنوز فرا نرسیده است.</div>");
                        }
                        else if(res === "nok2") {
                            $("#alertText").empty().append("<div>این محصول قبلا به فروش رسیده است و شما اجازه خرید مجدد آن را ندارد.</div>");
                        }
                        else if(res === "nok3") {
                            $("#alertText").empty().append("<div>متاسفانه سکه کافی برای خریداری این محصول را ندارید</div>");
                        }
                        else if(res === "nok8") {
                            $("#alertText").empty().append("<div>برای خرید محصول دوم می بایست از ساعت 12:05 و برای خرید محصول سوم از ساعت 12:10 اقدام فرمایید</div>");
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

    </script>

@stop
