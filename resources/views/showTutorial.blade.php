@extends('layouts.siteStructure2')

@section('header')
    @parent
@stop

@section('content')

    <div>

        <p>{{$tutorial->title}}</p>

        <?php
        $pic["path"] = $tutorial->path;
        $tmp = explode(".", $tutorial->path);
        $pic["type"] = $tmp[count($tmp) - 1];
        ?>
        @if($pic["type"] == "png" || $pic["type"] == "jpg" || $pic["type"] == "gif" || $pic["type"] == "bmp" || $pic["type"] == "jpeg")
            <div class="eachAdvType col-xs-12">
                <img style="width: 100%; float: right" src="{{$pic["path"]}}">
            </div>
        @elseif($pic["type"] == "mp4" || $pic["type"] == "m4v")
            <div class="eachAdvType col-xs-12">
                <video style="width: 100%" controls>
                    <source src="{{$pic["path"]}}" type="video/mp4">
                    مرورگر شما از پخش ویدیو پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                </video>
            </div>
        @elseif($pic["type"] == "mp3" || $pic["type"] == "ogg" || $pic["type"] == "m4a" || $pic["type"] == "aac" || $pic["type"] == "amr")
            <div class="eachAdvType col-xs-12">
                <audio style="width: 100%" controls>
                    <source src="{{$pic["path"]}}" type="audio/mpeg">
                    مرورگر شما از پخش موزیک پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                </audio>
            </div>
        @elseif($pic["type"] == "pdf")
            <div class="eachAdvType col-xs-12">
                <embed style="width: 100% !important;" src="{{$pic["path"]}}" width="800px" height="800px" />
            </div>
        @else
            <div class="eachAdvType col-xs-12">
                <a href="{{$pic["path"]}}" download>دانلود فایل</a>
            </div>
        @endif

    </div>
@stop
