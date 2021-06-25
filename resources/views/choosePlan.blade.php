@extends("layouts.siteStructure2")


@section("header")

    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/choosePlan.css?v=1.7")}}">

    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/swiper.css?v=1.1")}}">
{{--    <script src = {{URL::asset("js/swiper.min.js") }}></script>--}}

    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
@stop

@section("content")

    <div>
        <div class="swiper-container swiper-container-autoheight">
            <div class="swiper-wrapper">
{{--                <div class="swiper-slide advertiseBanner advertiseBanner5"></div>--}}
                <div class="swiper-slide advertiseBanner advertiseBanner8"></div>
                <div class="swiper-slide advertiseBanner advertiseBanner9"></div>
                <div class="swiper-slide advertiseBanner advertiseBanner10"></div>
{{--                <div class="swiper-slide advertiseBanner advertiseBanner1"></div>--}}
                <div class="swiper-slide advertiseBanner advertiseBanner7"></div>
{{--                <div class="swiper-slide advertiseBanner advertiseBanner3"></div>--}}
{{--                <div class="swiper-slide advertiseBanner advertiseBanner4"></div>--}}
                <div class="swiper-slide advertiseBanner advertiseBanner6"></div>
            </div>

            <!-- pagination -->
            <div class="swiper-pagination"></div>

            <!-- navigation buttons -->
            <div class="fa fa-sort-desc swiper-button swiper-button-prev"></div>
            <div class="fa fa-sort-desc swiper-button swiper-button-next"></div>

        </div>


{{--        <div class="citizenShipBox row">--}}
{{--            <div class="col-sm-12 col-xs-12">--}}
{{--                <div onclick="document.location.href = '{{route('showAllProjects')}}'" class="planes citizenShip">--}}
{{--                    <div class="planeText">شهروندی</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="choosePlane row">
            <div class="col-sm-12 col-xs-12" style="padding-bottom: 30px">
                <div onclick="document.location.href = '{{route('showAllCitizens')}}'" class="citizenShip">
                    <div class="planeTextBox citizenShipText">شهروندی</div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div onclick="document.location.href = '{{route('showAllProducts')}}'" class="planes products">
                    <div class="planeTextBox planeText">خرید محصولات</div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div onclick="document.location.href = '{{route('showAllServices')}}'" class="planes services">
                    <div class="planeTextBox planeText">پروژه‌های همیاری</div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div onclick="document.location.href = '{{route('showAllProjects')}}'" class="planes projects">
                    <div class="planeTextBox planeText">انتخاب پروژه‌ها</div>
                </div>
            </div>
        </div>

        <div class="otherAdvertise">
            <div class="twoAdvBox">
                <div class="otherAdv rightAdv"></div>
                <div class="otherAdv leftAdv"></div>
            </div>
            <div class="horizontalAdv"></div>
        </div>
    </div>




    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerGroup: 1,
            loop: true,
            autoplay: {
                delay: 5000,
                // disableOnInteraction: false,
            },
            loopFillGroupWithBlank: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                200: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
                // 520: {
                //     slidesPerView: 2,
                //     spaceBetween: 20,
                // },
                // 768: {
                //     slidesPerView: 2,
                //     spaceBetween: 20,
                // },
                // 992: {
                //     slidesPerView: 3,
                //     spaceBetween: 20,
                // },
                // 10000: {
                //     slidesPerView: 4,
                //     spaceBetween: 20,
                // }
            }
        });
    </script>

@stop
