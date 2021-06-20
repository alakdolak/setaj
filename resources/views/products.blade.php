@extends("layouts.siteStructure3")


@section("header")
    @parent

@stop

@section("banner")

    <div class="banner">
        <div class="bannerGrayBox"></div>
        <div class="bannerBorderBox bannerLightBlueBox"></div>
        <div class="bannerMainBox productsBanner"></div>
    </div>

@stop

@section("content")

    <?php
    $arr = ["اول", "دوم", "سوم", "چهارم", "پنجم", "ششم", "هفتم", "هشتم", "نهم", "دهم"]
    ?>

    <div class="shopBox row">

        @for($i = 9; $i >= 0; $i--)

            <?php $allow = false; ?>

            @foreach($products as $product)

                @if($product->week == $i)
                    <?php $allow = true; ?>
                @endif

            @endforeach

            @if($allow)
                <div class="weekContainer shopEachRow col-xs-12">

                    <div class="shopEachRow shopEachRowTitle week{{($i + 1)}} col-xs-12"></div>

                    <div class="shopEachRow col-xs-12">

                        @foreach($products as $product)

                            @if($product->week != $i)
                                @continue
                            @endif

                            <div data-tag="{{$product->tagStr}}" onclick="document.location.href = '{{route('showProduct', ['id' => $product->id])}}'" class="myItem shopOneBox col-md-3 col-sm-4 col-xs-6">
                                <div class="sh_mainBox">
                                    <div class="sh_advPic"></div>
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

{{--                                        <p class="sh_descriptRow sh_title" style="direction: rtl; text-align: right">--}}
{{--                                            @foreach($product->tags as $tag)--}}
{{--                                                <span>#{{$tag->name}}</span>--}}
{{--                                                <span>&nbsp;&nbsp;</span>--}}
{{--                                            @endforeach--}}
{{--                                        </p>--}}
                                    </div>

                                </div>

                                @if($product->canBuy)
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
            @endif

        @endfor
    </div>


@stop
