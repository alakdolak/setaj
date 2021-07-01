@extends('layouts.structure')

@section('header')
    @parent

    <style>
        th, td {
            text-align: right;
        }

        .calendar {
            z-index: 1000000000000 !important;
        }

        input {
            text-align: center;
        }

    </style>

    <script src="//cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>

@stop

@section('content')

    <form action="{{route('doEditTutorial', ['id' => $tutorial->id])}}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <center class="col-xs-12" style="margin-top: 70px">

            <h5 style="padding-right: 5%;">عنوان آموزش</h5>
            <input value="{{$tutorial->title}}" type="text" name="title" required maxlength="100">

            <h5 style="padding-right: 5%;">تصویر فعلی آموزش</h5>
            @if($tutorial->pic != null)
                <img width="200" src="{{\Illuminate\Support\Facades\URL::asset("storage/tutorials/" . $tutorial->pic)}}">
            @else
                <img width="200" src="{{\Illuminate\Support\Facades\URL::asset("images/defaultTutorial.jpg")}}">
            @endif

            <h5>توضیح آموزش</h5>
            <textarea id="editor1" cols="80" name="description" required>
                {!! html_entity_decode($tutorial->description) !!}
            </textarea>

            <h5 style="padding-right: 5%;">فایل آموزش</h5>
            <input type="file" name="file">

            <h5 style="padding-right: 5%;">تصویر آموزش</h5>
            <input type="file" name="pic" accept="image/png, image/gif, image/jpeg image/jpg">

            <h3 style="color: red">در صورت آپلود فایل جدید برای آموزش، موارد قبلی حذف خواهند شد.</h3>

            <div style="margin-top: 20px">
                <input type="submit" value="ویرایش" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
            </div>

        </center>

    </form>

    <script>

        CKEDITOR.replace('editor1');

    </script>

@stop
