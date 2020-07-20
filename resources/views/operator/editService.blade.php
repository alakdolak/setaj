@extends('layouts.structure')

@section('header')
    @parent

    <style>
        th, td {
            text-align: right;
        }

        input {
            text-align: center;
        }

    </style>

    <script src="//cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>

@stop

@section('content')

    <form action="{{route('doEditService', ['id' => $service->id])}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <center class="col-xs-12" style="margin-top: 70px">

            <h5 style="padding-right: 5%;">نام خدمت</h5>
            <input value="{{$service->title}}" type="text" name="name" required maxlength="100">

            <h5 style="padding-right: 5%;">تعداد ستاره ها</h5>
            <input value="{{$service->star}}" type="number" name="star" required min="0">

            <h5 style="padding-right: 5%;">موجودی</h5>
            <input value="{{$service->capacity}}" type="number" name="capacity" required min="1">

            <h5>توضیح خدمت</h5>
            <textarea id="editor1" cols="80" name="description" required>
                {!! html_entity_decode($service->description) !!}
            </textarea>

            <h5 style="padding-right: 5%;">تصاویر خدمت(اختیاری)</h5>
            <input type="file" name="file" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

            <h5 style="padding-right: 5%;">فایل های آموزشی خدمت(اختیاری)</h5>
            <input type="file" name="attach" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

            <h3 style="color: red">در صورت آپلود تصاویر جدید یا فایل های آموزشی جدید برای خدمت، موارد قبلی حذف خواهند شد.</h3>

            <div style="margin-top: 20px">
                <input type="submit" value="ویرایش" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
            </div>

        </center>

    </form>

    <script>

        CKEDITOR.replace('editor1');

    </script>

@stop
