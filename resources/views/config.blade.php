@extends('layouts.structure')

@section('header')
    @parent

    <style>

        label {
            width: 400px;
        }

        input {
            text-align: center;
        }

    </style>

@stop

@section('content')

    <div style="margin-top: 200px">

        <form method="post" action="{{route('doConfig')}}">

            {{csrf_field()}}

            <div>
                <label for="change_rate">نرخ تبدیل ستاره به سکه (هر ستاره برابر است با ... سکه)</label>
                <input id="change_rate" value="{{$config->change_rate}}" name="change_rate" type="number">
            </div>

            <div>
                <label for="rev_change_rate">نرخ تبدیل سکه به ستاره (هر سکه برابر است با ... ستاره)</label>
                <input id="rev_change_rate" value="{{$config->rev_change_rate}}" name="rev_change_rate" type="text">
            </div>

            <div>
                <label for="initial_point">مقدار سکه اولیه دانش آموزان</label>
                <input value="{{$config->initial_point}}" id="initial_point" name="initial_point" type="number">
            </div>

            <div>
                <label for="initial_star">مقدار ستاره اولیه دانش آموزان</label>
                <input value="{{$config->initial_star}}" id="initial_star" name="initial_star" type="number">
            </div>

            <div>
                <label for="project_limit_7">محدودیت تعداد خرید پروژه ها در هفته برای هفتمی ها</label>
                <input value="{{$config->project_limit_7}}" id="project_limit_7" name="project_limit_7" type="number">
            </div>

            <div>
                <label for="project_limit_6">محدودیت تعداد خرید پروژه ها در هفته  برای ششمی ها</label>
                <input value="{{$config->project_limit_6}}" id="project_limit_6" name="project_limit_6" type="number">
            </div>

            <div>
                <label for="project_limit_5">محدودیت تعداد خرید پروژه ها در هفته  برای پنجمی ها</label>
                <input value="{{$config->project_limit_5}}" id="project_limit_5" name="project_limit_5" type="number">
            </div>

            <div>
                <label for="project_limit_4">محدودیت تعداد خرید پروژه ها در هفته  برای چهارمی ها</label>
                <input value="{{$config->project_limit_4}}" id="project_limit_4" name="project_limit_4" type="number">
            </div>

            <div>
                <label for="project_limit_3">محدودیت تعداد خرید پروژه ها در هفته  برای سومی ها</label>
                <input value="{{$config->project_limit_3}}" id="project_limit_3" name="project_limit_3" type="number">
            </div>

            <div>
                <label for="project_limit_2">محدودیت تعداد خرید پروژه ها در هفته  برای دومی ها</label>
                <input value="{{$config->project_limit_2}}" id="project_limit_2" name="project_limit_2" type="number">
            </div>

            <div>
                <label for="project_limit_1">محدودیت تعداد خرید پروژه ها در هفته  برای اولی ها</label>
                <input value="{{$config->project_limit_1}}" id="project_limit_1" name="project_limit_1" type="number">
            </div>

            <div>
                <label for="service_limit">محدودیت تعداد خدمات انجام نشده</label>
                <input value="{{$config->service_limit}}" id="service_limit" name="service_limit" type="number">
            </div>

            <div>
                <label for="extra_limit">محدودیت تعداد پروژه های اضافی انجام نشده</label>
                <input value="{{$config->extra_limit}}" id="extra_limit" name="extra_limit" type="number">
            </div>

            <h2>تنظیمات نمایش</h2>
            <div>
                <label for="show_extra">نمایش بازار آزاد</label>
                @if($config->show_sell_extra)
                    <input id="show_sell_extra" name="show_sell_extra" checked type="checkbox">
                @else
                    <input id="show_sell_extra" name="show_sell_extra" type="checkbox">
                @endif
            </div>

            <div>
                <label for="show_extra">نمایش پروژه های مازاد</label>
                @if($config->show_extra)
                    <input id="show_extra" name="show_extra" checked type="checkbox">
                @else
                    <input id="show_extra" name="show_extra" type="checkbox">
                @endif
            </div>

            <div>
                <label for="show_extra">نمایش فروشگاه</label>
                @if($config->show_shop)
                    <input id="show_shop" name="show_shop" checked type="checkbox">
                @else
                    <input id="show_shop" name="show_shop" type="checkbox">
                @endif
            </div>

            <div>
                <label for="show_extra">نمایش محصولات</label>
                @if($config->show_product)
                    <input id="show_product" name="show_product" checked type="checkbox">
                @else
                    <input id="show_product" name="show_product" type="checkbox">
                @endif
            </div>

            <div>
                <label for="show_project">نمایش پروژه ها</label>
                @if($config->show_project)
                    <input id="show_project" name="show_project" checked type="checkbox">
                @else
                    <input id="show_project" name="show_project" type="checkbox">
                @endif
            </div>

            <div>
                <label for="show_service">نمایش پروژه های همیاری</label>
                @if($config->show_service)
                    <input id="show_service" name="show_service" checked type="checkbox">
                @else
                    <input id="show_service" name="show_service" type="checkbox">
                @endif
            </div>

            <div>
                <label for="show_citizen">نمایش پروژه های شهروندی</label>
                @if($config->show_citizen)
                    <input id="show_citizen" name="show_citizen" checked type="checkbox">
                @else
                    <input id="show_citizen" name="show_citizen" type="checkbox">
                @endif
            </div>


            <h2>مشخصات آدم خفن</h2>

            <div>
                <label for="min_health">حداقل امتیاز تندرستی</label>
                <input value="{{$config->min_health}}" id="min_health" name="min_health" type="number">
            </div>

            <div>
                <label for="min_think">حداقل امتیاز تفکر</label>
                <input value="{{$config->min_think}}" id="min_think" name="min_think" type="number">
            </div>

            <div>
                <label for="min_behavior">حداقل امتیاز کردار</label>
                <input value="{{$config->min_behavior}}" id="min_behavior" name="min_behavior" type="number">
            </div>

            <div>
                <label for="min_money">حداقل پول</label>
                <input value="{{$config->min_money}}" id="min_money" name="min_money" type="number">
            </div>

            <div>
                <label for="min_star">حداقل ستاره</label>
                <input value="{{$config->min_star}}" id="min_star" name="min_star" type="number">
            </div>

            <div style="margin-top: 30px">
                <input type="submit" class="btn btn-success" value="ذخیره">
            </div>
        </form>

    </div>
@stop
