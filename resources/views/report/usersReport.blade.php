@extends('layouts.structure')

@section('header')
    @parent

    <style>

        .gradeBox {
            padding: 10px;
            background-color: #e18c62;
            border: 1px solid;
            color: white;
            border-radius: 7px;
            cursor: pointer;
            margin-top: 10px;
        }

    </style>

@stop

@section('content')

    <center class="col-xs-12" style="margin-top: 100px">

        @if(count($grades) == 0)

            <h3>پایه تحصیلی ای وجود ندارد.</h3>

        @else

            @foreach($grades as $grade)
                <div class="col-xs-4">
                    <p onclick="document.location.href = '{{$path . '/' . $grade->id}}'" class="gradeBox">{{$grade->name}}</p>
                </div>
            @endforeach

        @endif

    </center>

@stop
