@extends('layouts.siteStructure2')

@section('header')
    @parent
    <link href="{{URL::asset('pages/css/faq-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/card.css?v=1.5")}}">
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/faq.css?v=1")}}">
@stop

@section('content')

    <div class="faqBody">
{{--کد مربوط به قسمت پرسش و پاسخ--}}
        <div class="faqContents row" style="display: none">
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

        {{--کد مربوط به قسمت فیلم های آموزشی--}}
        <div class="shopEachRow col-xs-12" style="margin-bottom: 50px">
            @foreach($tutorials as $tutorial)
                <div onclick="document.location.href = '{{route('showTutorial', ['id' => $tutorial->id])}}'" class="myItem shopOneBox col-md-3 col-sm-4 col-xs-6">
                    <div class="sh_mainBox">
                        <div style="background-image: url('{{$tutorial->pic}}')" class="sh_mainPic"></div>
                        <div class="sh_descript" style="min-height: 120px !important;">
                            <div class="sh_descriptRow sh_title">{{$tutorial->title}}</div>
                            <div class="sh_descriptRow">{!! html_entity_decode($tutorial->description) !!}</div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>

@stop
