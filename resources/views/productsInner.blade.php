@extends("layouts.siteStructure4")


@section("header")
    @parent
    <style>
        .prInner_buyBtnBox {
            border-right: 25px solid #a1a1a1;
            border-left: 25px solid #a1a1a1;
            margin: 20px 0;
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
                    <div class="prInner_buyBtnBox">
                        <div class="prInner_buyBtn">خرید مجموعه</div>
                    </div>
{{--                    <div>--}}
{{--                        <button onclick="buy()" class="btn btn-primary">خرید</button>--}}
{{--                    </div>--}}
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

                        <div class="sh_ownerBox">
                            <div>تولیدکننده: {{$product->owner}}</div>
                        </div>

                    </div>

                @endforeach

            </div>
        </div>
    </div>

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
                            $("#alertText").empty().append("<div>شما اجازه خرید این محصول را ندارید</div>");
                        }
                        else if(res === "nok2") {
                            $("#alertText").empty().append("<div>این محصول قبلا به فروش رسیده است و شما اجازه خرید مجدد آن را ندارد.</div>");
                        }
                        else if(res === "nok3") {
                            $("#alertText").empty().append("<div>متاسفانه سکه کافی برای خریداری این پروژه ندارید</div>");
                        }
                        else if(res === "nok8") {
                            $("#alertText").empty().append("<div>برای خرید پروژه دوم می بایست از ساعت 10:05 و برای خرید پروژه سوم از ساعت 10:10 اقدام فرمایید</div>");
                        }
                        else if(res === "nok9") {
                            $("#alertText").empty().append("<div>ظرفیت خرید پروژه های عینی شما به پایان رسیده و شما فقط می‌توانید پروژه غیرعینی خریداری کنید</div>");
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
