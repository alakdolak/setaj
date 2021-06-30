@extends('layouts.siteStructure2')

@section('header')
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/product.css?v=1.5")}}">
@stop

@section("content")

    <div class="eachProduct row">
        <div class="pr_descript col-sm-7 col-xs-12">
            <div class="pr_descriptRow pr_title">{{$tutorial->title}}</div>

            @if(!empty($tutorial->description))
                <div class="pr_descriptRow">
                    <div class="pr_iconesBox">
                        <div class="pr_icons folderIcon"></div>
                        <div>توضیحات:</div>
                    </div>
                    <div class="pr_description">
                        <div class="should_be_iransans">{!! html_entity_decode($tutorial->description) !!}</div>
                    </div>
                </div>
            @endif
        </div>
        <div class="pr_picsBox col-sm-5 col-xs-12">
            <div class="pr_pics">
                <div style="background-image: url('{{$tutorial->pic}}');" id="pr_mainPic" class="pr_bigPic"></div>
            </div>
        </div>

        <div class="pr_advertiseBox col-xs-12">
            <div class="pr_iconesBox" style="margin-bottom: 15px">
                <div class="pr_icons movieIcon"></div>
                <div>فایل های آموزشی:</div>
            </div>
            <div class="pr_advertise col-xs-12">

                <?php
                $tmp = explode(".", $tutorial->path);
                $pic["type"] = $tmp[count($tmp) - 1];
                $pic["path"] = $tutorial->path;
                ?>

                @if($pic["type"] == "png" || $pic["type"] == "jpg" || $pic["type"] == "gif" || $pic["type"] == "bmp" || $pic["type"] == "jpeg")
                    <div class="eachAdvType col-xs-12">
                        <img style="width: 100%;" src="{{$pic["path"]}}">
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
                        <audio style="width: 100%;" controls>
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
        </div>

    </div>
@stop

