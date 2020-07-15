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
                    <td>نام کاربر</td>
                    <td>تعداد پروژه های انجام شده</td>
                    <td>تعداد پروژه های ناتمام</td>
                    <td>تعداد محصولات خریداری شده</td>
                    <td>تعداد خدمات انجام شده</td>
                    <td>تعداد خدمات ناتمام</td>
                </tr>

                @foreach($users as $user)
                    <tr>

                        <td>{{$user->first_name . ' ' . $user->last_name}}</td>
                        <td>{{$user->completeProjects}}</td>
                        <td>{{$user->unCompleteProjects}}</td>
                        <td>{{$user->buys}}</td>
                        <td>{{$user->completeServices}}</td>
                        <td>{{$user->unCompleteServices}}</td>
                    </tr>
                @endforeach
            </table>
        </center>

    </div>

@stop
