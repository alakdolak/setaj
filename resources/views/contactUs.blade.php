@extends("layouts.siteStructure2")


@section("header")
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/contactUs.css?v=1")}}">
@stop

@section("content")

    <div class="row contactUsBody">
        <div class="cU_descriptRow row">
            <div class="col-sm-6 col-xs-12">
                <div class="cU_descript">
                    <div class="cU_iconBox">
                        <i class="cU_icon fa fa-map-marker-alt"></i>
                    </div>
                    <div class="cU_textBox">
                        <div class="cU_textTitle">آدرس</div>
{{--                        <div class="cU_text">تهران</div>--}}
                        <div class="cU_text">پاسداران ، خیابان گلستان پنجم ، بین خیابان اسلامی و خیابان پایدارفرد ، پلاک 177</div>
                        <div class="cU_text">مدرسه‌ی پسرانه‌ی سراج</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="cU_descript">
                    <div class="cU_iconBox">
                        <i class="cU_icon fa fa-phone"></i>
                    </div>
                    <div class="cU_textBox">
                        <div class="cU_textTitle">شماره‌های تماس</div>
                        <div class="cU_text">22598561 - 021</div>
                        <div class="cU_text">22778547 - 021</div>
                        <div class="cU_text">26473361 - 021</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cU_descriptRow row">
            <div class="col-sm-6 col-xs-12">
                <div class="cU_descript">
                    <div class="cU_iconBox">
                        <i class="cU_icon fa fa fa-paper-plane"></i>
                    </div>
                    <div class="cU_textBox">
                        <div class="cU_textTitle">مدرسه در تلگرام</div>
                        <a class="cu_link" href="https://T.me/seraj_school">لینک ورود به کانال</a>
{{--                        <a class="cu_link">seraj +</a>--}}
{{--                        <a class="cu_link">seraj -</a>--}}
                    </div>
                </div>T.me/seraj_school
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="cU_descript">
                    <div class="cU_iconBox">
                        <i class="cU_icon fa fa-check"></i>
                    </div>
                    <div class="cU_textBox">
                        <div class="cU_textTitle">مدرسه در بله</div>
                        <a class="cu_link" href="https://ble.ir/Seraj_school">لینک ورود به کانال</a>
{{--                        <a class="cu_link">seraj +</a>--}}
{{--                        <a class="cu_link">seraj -</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
