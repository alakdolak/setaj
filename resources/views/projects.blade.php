@extends("layouts.siteStructureProject")


@section("header")
    @parent
@stop

@section("banner")

    @if($extra)
        <div class="banner">
            <div class="bannerGrayBox"></div>
            <div class="bannerBorderBox bannerLightRedBox"></div>
            <div class="bannerMainBox extraProjectsBanner"></div>
        </div>
    @else
        <div class="banner">
            <div class="bannerGrayBox"></div>
            <div class="bannerBorderBox bannerLightRedBox"></div>
            <div class="bannerMainBox projectsBanner"></div>
        </div>
    @endif

@stop

@section("content")

    <?php
        $arr = ["اول", "دوم", "سوم", "چهارم", "پنجم", "ششم", "هفتم", "هشتم", "نهم", "دهم"]
    ?>

    <div class="shopBox row">

        <?php $showBanner = false; ?>

        @for($i = 9; $i >= 0; $i--)

            <?php $allow = false; ?>

            @foreach($projects as $project)

                @if($project->week == $i)
                    <?php $allow = true; ?>
                @endif

            @endforeach

            @if($allow)
                <div class="weekContainer shopEachRow col-xs-12">

                    @if($extra && !$showBanner)
                        <?php $showBanner = true; ?>
                        <div class="shopEachRow shopEachRowTitle extraBanner col-xs-12"></div>
                    @elseif(!$extra)
                        <div class="shopEachRow shopEachRowTitle week{{($i + 1)}} col-xs-12"></div>
                    @endif


                    <div class="shopEachRow col-xs-12">

                        @foreach($projects as $project)

                            @if($project->week != $i)
                                @continue
                            @endif

                            <div data-tag="{{$project->tagStr}}" onclick="document.location.href = '{{route('showProject', ['id' => $project->id])}}'" class="myItem shopOneBox col-md-3 col-sm-4 col-xs-6">
                                <div class="sh_mainBox">

                                    @if($extra)
                                        <div class="sh_extraPic2"></div>
                                    @endif

                                    <div style="background-image: url('{{$project->pic}}')" class="sh_mainPic"></div>
                                    <div class="sh_descript">
                                        <div class="sh_descriptRow sh_title">{{$project->title}}</div>
                                        <div class="sh_descriptRow sh_priceBox">
                                            <div class="priceIcons coinIcon"></div>
                                            @if($project->price != "رایگان")
                                                <div class="priceText">قیمت: {{$project->price}} سکه</div>
                                            @else
                                                <div class="priceText">قیمت: رایگان</div>
                                            @endif
                                        </div>
                                        <div class="sh_descriptRow sh_priceBox">
                                            <div class="priceIcons categoryIcon"></div>
                                            <div class="priceText">دسته:
                                                <?php $k = 0; ?>
                                                @foreach($project->tags as $tag)
                                                    @if($k == count($project->tags) - 1)
                                                        {{$tag->name}}
                                                    @else
                                                        {{$tag->name}} و
                                                    @endif
                                                <?php $k++; ?>
                                                @endforeach
                                                <span> - </span>
                                                @if($project->physical)
                                                    <span>عینی</span>
                                                @else
                                                    <span>غیرعینی</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($project->canBuy)
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
