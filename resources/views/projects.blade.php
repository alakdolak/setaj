@extends("layouts.siteStructure3")


@section("header")
    @parent
@stop

@section("banner")

    <div class="banner">
        <div class="bannerGrayBox"></div>
        <div class="bannerBorderBox bannerLightRedBox"></div>
        <div class="bannerMainBox projectsBanner">
            <div class="bannerText">انتخاب پروژه‌ها</div>
        </div>
    </div>

@stop

@section("content")

    <?php
        $arr = ["اول", "دوم", "سوم", "چهارم", "پنجم", "ششم", "هفتم", "هشتم", "نهم", "دهم"]
    ?>

    <div class="shopBox row">

        @for($i = 9; $i >= 0; $i--)

            <?php $allow = false; ?>

            @foreach($projects as $project)

                @if($project->week == $i)
                    <?php $allow = true; ?>
                @endif

            @endforeach

            @if($allow)
                <div class="shopEachRow col-lg-12" style="margin-top: 20px">

                    <div class="shopEachRow shopEachRowTitle col-lg-12">پروژه های هفته ی {{$arr[$i]}}</div>

                    <div style="margin-top: 20px" class="shopEachRow col-lg-12">

                        @foreach($projects as $project)

                            @if($project->week != $i)
                                @continue
                            @endif

                            <div data-tag="{{$project->tagStr}}" onclick="document.location.href = '{{route('showProject', ['id' => $project->id])}}'" class="myItem shopOneBox col-lg-3 col-xs-6">
                                <div class="sh_mainBox">
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

                                        <p class="sh_descriptRow sh_title" style="direction: rtl; text-align: right">
                                            @foreach($project->tags as $tag)
                                                <span>#{{$tag->name}}</span>
                                                <span>&nbsp;&nbsp;</span>
                                            @endforeach
                                        </p>

                                    </div>
                                </div>

                                @if($project->canBuy)
                                    <div class="sh_ownerBox">
                                        <div style="font-size: 0.9em">سفارش دهنده: مدرسه سراج</div>
                                    </div>
                                @else
                                    <div class="sh_ownerBox_finish">
                                        <div style="font-size: 0.9em">سفارش دهنده: مدرسه سراج</div>
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
