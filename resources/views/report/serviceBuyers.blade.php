
@extends('layouts.structure')

@section('header')
    @parent
@stop

@section('content')

    @if($buyers == null)
        هنوز خریداری نشده است.
    @else
        @foreach($buyers as $buyer)
            <div style="padding: 4px; margin: 4px; border: 1px dotted black; border-radius: 7px;">
                <p>{{$buyer["name"]}}</p>
                <p>
                    <span>وضعیت انجام: </span><span>&nbsp;</span><span>{{($buyer["status"]) ? "انجام شده" : "انجام نشده"}}</span>
                </p>
                @if($buyer["status"])
                    <p>
                        <span>تعداد ستاره های داده شده: </span><span>&nbsp;</span><span>{{$buyer["star"]}}</span>
                    </p>
                @else
                    <button onclick="confirmJob('{{$itr->star}}', '{{$buyer["id"]}}', '{{$itr->id}}')" class="btn btn-default">تاییده انجام کار</button>
                @endif
            </div>
        @endforeach
    @endif
@stop
