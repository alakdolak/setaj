@extends("layouts.siteStructureProject")


@section("header")
    @parent

@stop

@section("banner")

    @if(!$extra)
        <div class="banner">
            <div class="bannerGrayBox"></div>
            <div class="bannerBorderBox bannerLightBlueBox"></div>
            <div class="bannerMainBox productsBanner"></div>
        </div>
    @else
        <div class="banner">
            <div class="bannerGrayBox"></div>
            <div class="bannerBorderBox bannerLightPurpleBox"></div>
            <div class="bannerMainBox extraProductsBanner"></div>
        </div>
    @endif

@stop

@section("content")

    <?php
    $arr = ["اول", "دوم", "سوم", "چهارم", "پنجم", "ششم", "هفتم", "هشتم", "نهم", "دهم"]
    ?>

    <div class="shopBox row">

        @for($i = 9; $i >= 0; $i--)

            <?php $allow = $extra; ?>

            @if($extra && $i != 9)
                @continue
            @endif

            @if(!$extra)

                @foreach($products as $product)

                    @if($product->week == $i)
                        <?php $allow = true; ?>
                    @endif

                @endforeach
            @endif

            @if($allow)
                <div class="weekContainer shopEachRow col-xs-12">

                    @if(!$extra)
                        <div class="shopEachRow shopEachRowTitle week{{($i + 1)}} col-xs-12"></div>
                    @else
                        <div class="shopEachRow shopEachRowTitle extraBanner col-xs-12"></div>
                    @endif

                    <div class="shopEachRow col-xs-12">

                        @foreach($products as $product)

                            @if(!$extra && $product->week != $i)
                                @continue
                            @endif

                            <div data-tag="{{$product->tagStr}}" onclick="document.location.href = '{{($product->physical) ? route('showProduct', ['id' => $product->id]) : route('showAllProductsInner', ['projectId' => $product->id, 'gradeId' => $grade])}}'" class="myItem shopOneBox col-md-3 col-sm-4 col-xs-6">
                                <div class="sh_mainBox">

                                    @if($product->adv_status)
                                        <div class="sh_advPic"></div>
                                    @endif

                                    @if($extra)
                                        <div class="sh_extraPic"></div>
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

                                        <div class="sh_descriptRow sh_priceBox">
                                            <div class="priceIcons categoryIcon"></div>
                                            <div class="priceText">دسته:
                                                @foreach($product->tags as $tag)
                                                    <span>{{$tag->name}}</span>
                                                @endforeach
                                                <span>-</span>
                                                @if($product->physical)
                                                    <span>عینی</span>
                                                @else
                                                    <span>غیر عینی</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                @if($product->canBuy)
                                    <div class="sh_ownerBox">
                                        @if($product->physical)
                                            <div>تولیدکننده: {{$product->owner}}</div>
                                        @else
                                            <div>{{$product->owner}}</div>
                                        @endif
                                    </div>
                                @else
                                    <div class="sh_ownerBox_finish">
                                        @if($product->physical)
                                            <div>تولیدکننده: {{$product->owner}}</div>
                                        @else
                                            <div>{{$product->owner}}</div>
                                        @endif
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
