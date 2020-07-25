@extends("layouts.siteStructure2")


@section("header")

    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/choosePlan.css?v=1.4")}}">
@stop

@section("content")

    <div>
        <div class="advertiseBannerBox">
            <div class="advertiseBanner"></div>
        </div>

        <div class="choosePlane row">
            <div class="col-sm-4 col-xs-12">
                <div onclick="document.location.href = '{{route('showAllProjects')}}'" class="planes projects">
                    <div class="planeText">انتخاب پروژه‌ها</div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div onclick="document.location.href = '{{route('showAllServices')}}'" class="planes services">
                    <div class="planeText">پروژه‌های همیاری</div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div onclick="document.location.href = '{{route('showAllProducts')}}'" class="planes products">
                    <div class="planeText">خرید محصولات</div>
                </div>
            </div>
        </div>

        <div class="otherAdvertise">
            <div class="twoAdvBox">
                <div class="otherAdv leftAdv"></div>
                <div class="otherAdv rightAdv"></div>
            </div>
            <div class="horizontalAdv"></div>
        </div>
    </div>

@stop
