@extends('layouts.siteStructure2')

@section('header')
    @parent
    <link href="{{URL::asset('pages/css/faq-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/faq.css?v=1")}}">
@stop

@section('content')

    <div class="faqBody">
        <div class="faqContents row">
            <div class="col-lg-4 col-sm-6 col-xs-12">
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

            <div class="col-lg-4 col-sm-6 col-xs-12">
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

            <div class="col-lg-4 col-sm-6 col-xs-12">
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
@stop
