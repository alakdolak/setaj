@extends('layouts.structure')

@section('header')
    @parent

    <style>
        th, td {
            text-align: center;
            padding: 7px;
            border: 1px solid #444;
        }

    </style>

@stop

@section('content')

    <div class="col-sm-12" style="margin-top: 100px">

        <center>

            <h3>
                <a href="{{route('productProjectReportExcel', ['gradeId' => $gradeId])}}" download>دریافت فایل اکسل</a>
            </h3>

            <h3><span>تعداد کل</span><span>&nbsp;</span><span>{{count($users)}}</span></h3>

            <table style="margin-top: 20px">
                <tr>
                    <td>ردیف</td>
                    <td>نام کاربر</td>
                    <td>تعداد پروژه های انجام شده</td>
                    <td>تعداد پروژه های ناتمام</td>
                    <td>تعداد محصولات خریداری شده</td>
                    <td>تعداد خدمات انجام شده</td>
                    <td>تعداد خدمات ناتمام</td>
                </tr>
                <?php $i = 1; ?>
                @foreach($users as $user)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$user->first_name . ' ' . $user->last_name}}</td>
                        <td>{{$user->completeProjects}}</td>
                        <td>{{$user->unCompleteProjects}}</td>
                        <td>{{$user->buys}}</td>
                        <td>{{$user->completeServices}}</td>
                        <td>{{$user->unCompleteServices}}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </table>
        </center>

    </div>

@stop
