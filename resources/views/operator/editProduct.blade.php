@extends('layouts.structure')

@section('header')
    @parent
@stop


@section('content')

    <form action="{{route('doEditProduct', ['id' => $product->id])}}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <center class="col-xs-12" style="margin-top: 70px">

            <h5 style="padding-right: 5%;">نام محصول</h5>
            <input value="{{$product->name}}" type="text" name="name" required maxlength="100">

            <h5 style="padding-right: 5%;">قیمت محصول</h5>
            <input value="{{$product->price}}" type="number" name="price" required min="0">

            <h5 style="padding-right: 5%;">ستاره های محصول</h5>
            <input value="{{$product->star}}" type="number" name="star" required min="0">

            <h5>توضیح محصول</h5>
            <textarea id="editor1" cols="80" name="description" required>
                {!! html_entity_decode($product->description) !!}
            </textarea>

            <h5 style="padding-right: 5%;">تصاویر محصول(اختیاری)</h5>
            <input type="file" name="file" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

            <h5 style="padding-right: 5%;">آموزش محصول(اختیاری)</h5>
            <input type="file" name="attach" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

            <h5 style="padding-right: 5%;">تبلیغات محصول(اختیاری)</h5>
            <input type="file" name="trailer" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">


            <h3 style="color: red">در صورت آپلود تصاویر جدید یا فایل های آموزشی جدید یا تبلیغات جدید برای محصول، موارد قبلی حذف خواهند شد.</h3>

            <div style="margin-top: 20px">
                <input type="submit" value="ویرایش" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
            </div>

        </center>

    </form>

@stop
