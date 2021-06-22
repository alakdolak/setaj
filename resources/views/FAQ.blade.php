@extends('layouts.siteStructure2')

@section('header')
    @parent
    <link href="{{URL::asset('pages/css/faq-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/faq.css?v=1")}}">
@stop

@section('content')

    <div class="faqBody">
        <div class="faqContents row">
            <div style="float: right; margin-bottom: 10%" class="col-lg-4 col-sm-6 col-xs-12">
                <?php $i = 0; ?>
                @foreach($categories as $category)
                    @if($i % 3 == 0)
                        <div class="faqSection">
                            <div class="faqTitle">{{$category->name}}</div>
                            <div class="faqGroup" id="accordion{{$category->id}}">
                                @foreach($category->items as $itr)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$category->id}}" href="#collapse_{{$itr->id}}"> {!! $itr->question !!}</a>
                                            </h4>
                                        </div>
                                        <div id="collapse_{{$itr->id}}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>{!! $itr->answer !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <?php $i++; ?>
                @endforeach
            </div>

            <div style="display: none" class="col-lg-4 col-sm-6 col-xs-12">
                <?php $i = 0; ?>
                @foreach($categories as $category)
                    @if($i % 3 == 1)
                        <div class="faqSection">
                            <div class="faqTitle">{{$category->name}}</div>
                            <div class="faqGroup" id="accordion{{$category->id}}">
                                @foreach($category->items as $itr)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$category->id}}" href="#collapse_{{$itr->id}}"> {!! $itr->question !!}</a>
                                            </h4>
                                        </div>
                                        <div id="collapse_{{$itr->id}}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>{!! $itr->answer !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <?php $i++; ?>
                @endforeach
            </div>

            <div style="display: none" class="col-lg-4 col-sm-6 col-xs-12">
                    <?php $i = 0; ?>
                    @foreach($categories as $category)
                        @if($i % 3 == 2)
                            <div class="faqSection">
                                <div class="faqTitle">{{$category->name}}</div>
                                <div class="faqGroup" id="accordion{{$category->id}}">
                                    @foreach($category->items as $itr)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$category->id}}" href="#collapse_{{$itr->id}}"> {!! $itr->question !!}</a>
                                                </h4>
                                            </div>
                                            <div id="collapse_{{$itr->id}}" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <p>{!! $itr->answer !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <?php $i++; ?>
                    @endforeach
                </div>
        </div>
    </div>

    <div>
        @foreach($tutorials as $tutorial)
            <p>{{$tutorial->title}}</p>
            @if($tutorial->pic != null)
                <img src="{{$tutorial->pic}}" width="100px">
            @endif

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

        @endforeach
    </div>
@stop
