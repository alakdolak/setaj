@extends("layouts.siteStructure3")


@section("header")
    @parent
@stop

@section("banner")

    <div class="banner">
        <div class="bannerGrayBox"></div>
        <div class="bannerBorderBox bannerLightRedBox"></div>
        <div class="bannerMainBox projectsBanner"></div>
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
                <div class="weekContainer shopEachRow col-xs-12">

                    <div class="shopEachRow shopEachRowTitle week{{($i + 1)}} col-xs-12"></div>

                    <div class="shopEachRow col-xs-12">

                        @foreach($projects as $project)

                            @if($project->week != $i)
                                @continue
                            @endif

                            <div data-tag="-{{$project->tag_id}}-" onclick="document.location.href = '{{route('showCitizen', ['id' => $project->id])}}'" class="myItem shopOneBox col-md-3 col-sm-4 col-xs-6">
                                <div class="sh_mainBox">
                                    <div style="background-image: url('{{$project->pic}}')" class="sh_mainPic"></div>
                                    <div class="sh_descript">
                                        <div class="sh_descriptRow sh_title">{{$project->title}}</div>
                                        <div class="sh_descriptRow sh_priceBox">
                                            <div class="priceIcons coinIcon"></div>
                                            <div class="priceText">امتیاز: {{$project->point}} </div>
                                        </div>
                                        <div class="sh_descriptRow sh_priceBox">
                                            <div class="priceIcons categoryIcon"></div>
                                            <div class="priceText">دسته:
                                                {{$project->tag}}
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
