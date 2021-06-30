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

            <div style="margin-top: 30px">
                <input type="submit" class="btn btn-success" value="ذخیره">
            </div>
        </form>

    </div>
@stop
