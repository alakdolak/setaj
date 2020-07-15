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

        @if(count($chats) == 0)

            <h3>مکالمه جدیدی وجود ندارد.</h3>

        @else

            @foreach($chats as $chat)
                <div class="col-xs-4">
                    <p onclick="document.location.href = '{{route('msgs', ['chatId' => $chat->id])}}'" class="gradeBox">{{$chat->name}}<span style="font-size: 0.8em; color: red; margin-right: 7px">{{$chat->countNum}}</span></p>
                </div>
            @endforeach

        @endif

    </center>

@stop
