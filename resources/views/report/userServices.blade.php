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

    <div class="col-md-12" style="margin-top: 100px">

        <center>

            <table style="margin-top: 20px">
                <tr>
                    <td>نام خدمت</td>
                    <td>وضعیت انجام</td>
                    <td>تعداد سکه تعلق یافته</td>
                </tr>

                @foreach($services as $service)
                    <tr>

                        <td>{{$service->title}}</td>

                        @if($service->status)
                            <td>انجام شده</td>
                        @else
                            <td>انجام نشده</td>
                        @endif

                        <td>{{$service->star}}</td>
                    </tr>
                @endforeach
            </table>
        </center>

    </div>

@stop
