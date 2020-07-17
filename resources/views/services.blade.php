@extends("layouts.siteStructure3")


@section("header")
    @parent
@stop

@section("banner")

    <div class="banner">
        <div class="bannerGrayBox"></div>
        <div class="bannerBorderBox bannerLightPinkBox"></div>
        <div class="bannerMainBox servicesBanner"></div>
    </div>

@stop

@section("content")

    <?php
        $arr = ["اول", "دوم", "سوم", "چهارم", "پنجم", "ششم", "هفتم", "هشتم", "نهم", "دهم"]
    ?>

    <div class="shopBox row">

        @for($i = 9; $i >= 0; $i--)

            <?php $allow = false; ?>

            @foreach($services as $service)

                @if($service->week == $i)
                    <?php $allow = true; ?>
                @endif

            @endforeach

            @if($allow)
                <div class="shopEachRow col-sm-12" style="margin-top: 200px">

                    <div class="shopEachRow shopEachRowTitle week{{($i + 1)}} col-sm-12"></div>

                    <div class="shopEachRow col-sm-12">

                        @foreach($services as $service)

                            @if($service->week != $i)
                                @continue
                            @endif

                            <div onclick="document.location.href = '{{route('showService', ['id' => $service->id])}}'" class="shopOneBox col-sm-3 col-xs-6">
                                <div class="sh_mainBox">
                                    <div style="background-image: url('{{$service->pic}}')" class="sh_mainPic"></div>
                                    <div class="sh_descript">
                                        <div class="sh_descriptRow sh_title">{{$service->title}}</div>

                                        <div class="sh_descriptRow sh_priceBox">
                                            <div class="priceIcons starIcon"></div>
                                            <div class="priceText">ستاره ی دریافتی: {{$service->star}}</div>
                                        </div>

                                        <div class="sh_descriptRow sh_priceBox">
                                            <div class="priceIcons capacityIcon"></div>
                                            <div class="priceText">موجودی: {{$service->reminder}}</div>
                                        </div>
                                    </div>
                                </div>

                                @if($service->canBuy)
                                    <div class="sh_ownerBox">
                                        <div style="font-size: 0.9em">سفارش مدرسه سراج</div>
                                    </div>
                                @else
                                    <div class="sh_ownerBox_finish">
                                        <div style="font-size: 0.9em">سفارش مدرسه سراج</div>
                                    </div>
                                @endif

                            </div>
                        @endforeach

                    </div>
                </div>
            @endif

        @endfor
    </div>

@stop
