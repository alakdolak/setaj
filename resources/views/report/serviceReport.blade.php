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

    <div class="col-xs-12" style="margin-top: 100px">

        @if(count($services) == 0)

            <h3>خدمتی وجود ندارد.</h3>

        @else

            @foreach($services as $service)
                <div class="col-xs-4">
                    <p onclick="document.location.href = '{{route('serviceBuyers', ['id' => $service->id])}}'" class="gradeBox">{{$service->title}}</p>
                </div>
            @endforeach

        @endif

    </div>

@stop
