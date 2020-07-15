@extends('layouts.structure')

@section('header')
    @parent
@stop

@section('content')

    <center style="margin-top: 20px">

        <h4>{{$err}}</h4>

        <button onclick="document.location.href = '{{route('usersReport', ['gradeId' => $gradeId])}}'" class="btn btn-primary">بازگشت</button>

    </center>

@stop
