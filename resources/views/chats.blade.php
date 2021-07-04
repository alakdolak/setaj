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

        @if(count($chats) == 0)

            <h3>مکالمه جدیدی وجود ندارد.</h3>

        @else

            @foreach($chats as $chat)
                <center onclick="document.location.href = '{{route('msgs', ['chatId' => $chat->id])}}'" class="col-xs-4 gradeBox">
                    <p>
                        <span>{{$chat->name}}</span>
                        <span style="font-size: 1.2em; color: red; margin-right: 7px">
                            <span>پیام های دیده نشده: </span>
                            <span>{{$chat->unseen}}</span>
                        </span>
                    </p>
                    <p>
                        <span>تعداد کل پیام ها:</span>
                        <span>{{$chat->total}}</span>
                    </p>
                </center>
            @endforeach

        @endif

    </div>

@stop
