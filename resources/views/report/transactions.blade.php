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

    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/calendar-setup.js") }}></script>
    <script src= {{URL::asset("js/calendar-fa.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>
    <link rel="stylesheet" href="{{URL::asset('css/standalone.css')}}">
    <link rel="stylesheet" href= {{URL::asset("css/calendar-green.css") }}>

@stop

@section('content')

    <div class="col-sm-12" style="margin-top: 100px">

            <p><span>تعداد کل: </span><span>&nbsp;</span><span id="totalCount">{{count($transactions)}}</span></p>

            <table style="margin-top: 20px">
                <tr>
                    <td>ردیف</td>
                    <td>فروشنده</td>
                    <td>پایه تحصیلی فروشنده</td>
                    <td>نام گروه فروشنده</td>
                    <td>خریدار</td>
                    <td>محصول</td>
                    <td>کد محصول</td>
                    <td>پست شود؟</td>
                    <td>آدرس پستی</td>
                    <td>شماره همراه خریدار</td>
                    <td>مقدار پرداختی</td>
                    <td>کد پیگیری</td>
                    <td>تاریخ انجام معامله</td>
                </tr>

                <?php $i = 0; ?>
                @foreach($transactions as $transaction)
                    <tr id="{{$i}}">
                        <td>{{($i + 1)}}</td>
                        <td>{{$transaction->seller}}</td>
                        <td>{{$transaction->grade}}</td>
                        <td>{{$transaction->owner}}</td>
                        <td>{{$transaction->buyer}}</td>
                        <td>{{$transaction->name}}</td>
                        <td>{{$transaction->code}}</td>
                        @if(($transaction->post))
                            <td>بله</td>
                        @else
                            <td>خیر</td>
                        @endif
                        <td>{{$transaction->address}}</td>
                        <td>{{$transaction->phone}}</td>
                        <td>{{$transaction->pay}}</td>
                        <td>{{$transaction->ref_id}}</td>
                        <td>{{$transaction->date . '     ساعت:     ' . $transaction->time}}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </table>
        </center>

    </div>

@stop
