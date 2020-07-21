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

        <div>

            <table style="margin-top: 20px">
                <tr>
                    <td>نام کاربر</td>
                    <td>نام پروژه</td>
                </tr>

                @foreach($projects as $project)
                    <tr>

                        <td>{{$project->name}}</td>
                        <td>{{$project->title}}</td>

                    </tr>
                @endforeach
            </table>
        </div>

    </div>

@stop
