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

            <table style="margin-top: 20px">
                <tr>
                    <td>نام پروژه</td>
                    <td>وضعیت انجام</td>
                    <td>وضعیت</td>
                </tr>

                @foreach($projects as $project)
                    <tr>

                        <td>{{$project->title}}</td>

                        @if($project->status)
                            <td>انجام شده</td>
                        @else
                            <td>انجام نشده</td>
                        @endif

                        <td>{{$project->date . '    ساعت     ' . $project->time}}</td>

                    </tr>
                @endforeach
            </table>
        </center>

    </div>

@stop
