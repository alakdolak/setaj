@extends("layouts.siteStructureGood")


@section("header")
    @parent
@stop

@section("banner")

    <div class="banner">
        <div class="bannerGrayBox"></div>
        <div class="bannerBorderBox bannerLightGreenBox"></div>
        <div class="bannerMainBox goodsBanner"></div>
    </div>

@stop

@section("content")
    <div class="shopBox row">
        <div class="weekContainer shopEachRow col-xs-12">
            <div class="shopEachRow shopEachRowTitle goodsTitleBanner col-xs-12"></div>
            <div class="shopEachRow col-xs-12">
                @foreach($goods as $good)
                    <div data-tag="{{$good->tag}}" onclick="document.location.href = '{{route('showGood', ['id' => $good->id])}}'" class="myItem shopOneBox col-md-3 col-sm-4 col-xs-6">
                        <div class="sh_mainBox">
                            <div style="background-image: url('{{$good->pic}}'); background-size: cover !important; background-position: center !important;" class="sh_mainPic"></div>
                            <div class="sh_descript">
                                <div class="sh_descriptRow sh_title">{{$good->name}}</div>
                                <div class="sh_descriptRow sh_priceBox">
                                    <div class="priceIcons coinIcon"></div>
                                    @if($good->price != "رایگان")
                                        <div class="priceText">قیمت: {{$good->price}} تومان</div>
                                    @else
                                        <div class="priceText">قیمت: رایگان</div>
                                    @endif
                                </div>
                                @if(count($good->tags) > 0)
                                    <div class="sh_descriptRow sh_priceBox">
                                        <div class="priceIcons categoryIcon"></div>
                                        <div class="priceText">دسته:
                                            <?php $k = 0; ?>
                                            @foreach($good->tags as $tag)
                                                @if($k == count($good->tags) - 1)
                                                    {{$tag}}
                                                @else
                                                    {{$tag}} و
                                                @endif
                                            <?php $k++; ?>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div class="sh_descriptRow sh_priceBox">
                                    <div class="priceIcons capacityIcon"></div>
                                    <div class="priceText">کد محصول:
                                        {{$good->code}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($good->canBuy)
                            <div class="sh_ownerBox">
                                <div style="font-size: 0.9em"><span>تولید کننده: </span><span>{{$good->owner}}</span></div>
                            </div>
                        @else
                            <div class="sh_ownerBox_finish">
                                <div style="font-size: 0.9em"><span>تولید کننده: </span><span>{{$good->owner}}</span></div>
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@stop
