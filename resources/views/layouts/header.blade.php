
<div class="header">

    <div onclick="document.location.href = '{{route('choosePlan')}}'" class="logoDiv">
        <div class="logoPic"></div>
        <div class="logoText"></div>
    </div>

    <div class="headerNav">

        <?php $config = \App\models\ConfigModel::first(); ?>

        @if($config->show_project)
            <div onclick="document.location.href = '{{route('showAllProjects', ['extra' => 0])}}'" class="headerNavbar">انتخاب پروژه‌ها</div>
        @endif

        @if($config->show_extra)
            <div onclick="document.location.href = '{{route('showAllProjects', ['extra' => 1])}}'" class="headerNavbar">انتخاب پروژه‌های بازار آزاد</div>
        @endif

        @if($config->show_citizen)
            <div onclick="document.location.href = '{{route('showAllCitizens')}}'" class="headerNavbar">شهروندی</div>
        @endif

        @if($config->show_service)
            <div onclick="document.location.href = '{{route('showAllServices')}}'" class="headerNavbar">همیاری</div>
        @endif

        @if($config->show_product)
            <div onclick="document.location.href = '{{route('showAllProducts', ['extra' => 0])}}'" class="headerNavbar">خرید محصولات</div>
        @endif

        @if($config->show_sell_extra)
            <div onclick="document.location.href = '{{route('showAllProducts', ['extra' => 1])}}'" class="headerNavbar">بازار آزاد</div>
        @endif

        @if($config->show_shop)
            <div onclick="document.location.href = '{{route('showAllGoods')}}'" class="headerNavbar">فروشگاه</div>
        @endif

        @if(\Illuminate\Support\Facades\Auth::check())
            <div class="headerNavbar">
                <div onclick="if($('#profilePopUp').hasClass('hidden')) { $('#profilePopUp').removeClass('hidden'); } else $('#profilePopUp').addClass('hidden');" class="profileIconBox screenMode">
                    <div class="profileIcon"></div>
                </div>
                <div onclick="if($('#profilePopUp').hasClass('hidden')) { $('#profilePopUp').removeClass('hidden'); } else $('#profilePopUp').addClass('hidden');" class="phoneMode">پروفایل</div>
                <div id="profilePopUp" class="profilePopUp hidden">
                    <i class="fa fa-sort-desc rightArrowIcon"></i>
                    <div class="profileRowPopUp profileName">{{\Illuminate\Support\Facades\Auth::user()->first_name . ' ' . \Illuminate\Support\Facades\Auth::user()->last_name}}</div>
                    <div class="profileRowPopUp profilePopUpIconBox">
                        <div>تعداد سکه: {{\Illuminate\Support\Facades\Auth::user()->money}}</div>
                        <div class="profilePopUpIcon coinIcon"></div>
                    </div>
                    <div class="profileRowPopUp profilePopUpIconBox">
                        <div>تعداد ستاره: {{\Illuminate\Support\Facades\Auth::user()->stars}}</div>
                        <div class="profilePopUpIcon starIcon"></div>
                    </div>
                    <div onclick="document.location.href = '{{route('profile')}}'" class="profileRowPopUp profileLogOIBox">
                        <div class="logOIText">ورود به صفحه شخصی</div>
                        <div class="logIcon loginIcon"></div>
                    </div>
                    <div onclick="document.location.href = '{{route('logout')}}'" class="profileLogOIBox">
                        <div class="logIcon"></div>
                        <div class="logOIText">خروج از حساب کاربری</div>
                    </div>
                </div>
            </div>
        @else
            <div onclick="document.location.href='{{route('login')}}'" class="headerLogin">
                <div class="headerLoginIcone">
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <div class="headerLoginText">ورود</div>
            </div>
        @endif
        {{--<div onclick="document.location.href = '{{route('profile')}}'" class="myNavbar">پروفایل</div>--}}
    </div>
</div>
