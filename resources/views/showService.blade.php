@extends('layouts.siteStructure2')

@section('header')
    @parent

    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/product.css")}}">

    <style>

        .remodal-is-closed {
            display: none;
        }

        .remodal-is-opened {
            display: block;
        }
    </style>

@stop

@section('content')

{{--    <center class="row" style="margin-top: 100px">--}}

{{--        <div class="bookmarkDivTotal">--}}
{{--            <p onclick="bookmark()" class="zoomable bookmarkDiv" onmouseenter="$(this).css('background-color', 'rgb(199, 200, 206)')" onmouseleave="$(this).css('background-color', 'transparent')" style="cursor: pointer; float: left; margin-left: 30px; border: 1px solid #202121; height: 34px; padding: 0 23px; line-height: 30px; background-color: transparent; border-radius: 30px !important;">--}}
{{--                <span>نشان کن</span>--}}
{{--                <span id="bookmark" class="glyphicon {{($bookmark) ? "glyphicon-heart" : "glyphicon-heart-empty"}}" style="margin-right: 4px; cursor: pointer; font-family: 'Glyphicons Halflings' !important;"></span>--}}
{{--            </p>--}}

{{--            <p onclick="like()" class="zoomable bookmarkDiv" onmouseenter="$(this).css('background-color', 'rgb(199, 200, 206)')" onmouseleave="$(this).css('background-color', 'transparent')" style="cursor: pointer; float: left; margin-left: 30px; border: 1px solid #202121; height: 34px; padding: 0 23px; line-height: 30px; background-color: transparent; border-radius: 30px !important;">--}}
{{--                <span>لایک کن</span>--}}
{{--                <span id="like" class="glyphicon {{($like) ? "glyphicon-heart" : "glyphicon-heart-empty"}}" style="margin-right: 4px; cursor: pointer; font-family: 'Glyphicons Halflings' !important;"></span>--}}
{{--            </p>--}}
{{--        </div>--}}

{{--        <h3>{{$service->name}}</h3>--}}

{{--        <div>--}}
{{--            {!! html_entity_decode($service->description) !!}--}}
{{--        </div>--}}

{{--        <p>هزینه: {{$service->price}} سکه</p>--}}
{{--        <p>تعداد ستاره: {{$service->star}}</p>--}}

{{--        @if($canBuy)--}}
{{--            <button onclick="buy()" class="btn btn-success">خرید پروژه</button>--}}

{{--            <p style="margin-top: 10px" id="buyErr"></p>--}}
{{--        @endif--}}

{{--        @foreach($service->pics as $pic)--}}
{{--            <img style="width: 250px; margin: 10px; float: right" src="{{$pic}}">--}}
{{--        @endforeach--}}

{{--        <div style="clear: both"></div>--}}
{{--        <h1>فایل های آموزشی</h1>--}}

{{--        @foreach($service->attach as $pic)--}}
{{--            @if($pic["type"] == "png" || $pic["type"] == "jpg" || $pic["type"] == "gif" || $pic["type"] == "bmp" || $pic["type"] == "jpeg")--}}
{{--                <center class="col-xs-12">--}}
{{--                    <img style="width: 250px; margin: 10px; float: right" src="{{$pic["path"]}}">--}}
{{--                </center>--}}
{{--            @elseif($pic["type"] == "mp4")--}}
{{--                <center class="col-xs-12">--}}
{{--                    <video width="320" height="240" controls>--}}
{{--                        <source src="{{$pic["path"]}}" type="video/mp4">--}}
{{--                        مرورگر شما از پخش ویدیو پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.--}}
{{--                    </video>--}}
{{--                </center>--}}
{{--            @elseif($pic["type"] == "mp3")--}}
{{--                <center class="col-xs-12">--}}
{{--                    <audio controls>--}}
{{--                        <source src="{{$pic["path"]}}" type="audio/mpeg">--}}
{{--                        مرورگر شما از پخش موزیک پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.--}}
{{--                    </audio>--}}
{{--                </center>--}}
{{--            @elseif($pic["type"] == "pdf")--}}
{{--                <center class="col-xs-12">--}}
{{--                    <embed src="{{$pic["path"]}}" width="800px" height="800px" />--}}
{{--                </center>--}}
{{--            @else--}}
{{--                <center class="col-xs-12">--}}
{{--                    <a href="{{$pic["path"]}}" download>دانلود فایل</a>--}}
{{--                </center>--}}
{{--            @endif--}}
{{--        @endforeach--}}

{{--    </center>--}}
<article class="c-product js-product">
    <section class="c-product__info">
        <div class="c-product__headline">
            <h1 class="c-product__title">
                {{$service->name}}
            </h1>
        </div>
        <div class="c-product__attributes js-product-attributes">
            <div class="c-product__config">
                <div class="c-product__engagement">
                    <div class="c-product__engagement-item">
                        <div class="c-product__engagement-rating">{{$service->star}}
                        </div>
                    </div>
                    <div class="c-product__engagement-item">
                        <div class="c-product__engagement-link" data-activate-tab="comments">{{$service->likes}} لایک کاربران</div>
                    </div>
                </div>
                <div class="c-product__config-wrapper">

                    <div class="c-product__params js-is-expandable" data-collapse-count="2">
                        {!! html_entity_decode($service->description) !!}
                    </div>
                </div>
            </div>
            <div class="c-product__summary js-product-summary">
                <div class="c-box">
                    <div class="c-product__seller-info js-seller-info">
                        <div class="js-seller-info-changable c-product__seller-box">

                            <div class="c-product__seller-row c-product__seller-row--price">
                                <div class="c-product__seller-price-real">
                                    <div class="c-product__seller-price-raw js-price-value">{{$service->star}}</div>ستاره
                                </div>
                            </div>

                            @if($canBuy)
                                <div onclick="buy()" class="c-product__seller-row c-product__seller-row--add-to-cart"><a class="btn-add-to-cart btn-add-to-cart--full-width js-add-to-cart js-cart-page-add-to-cart js-btn-add-to-cart"><span class="btn-add-to-cart__txt">برعهده گرفتن خدمت</span></a></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="c-product__gallery">

        <div class="c-product-gallery__offer js-amazing-offer u-hidden">
            <img class="c-product-gallery__offer-img" src="https://www.digikala.com/static/files/eccdcccd.png">
            <div class="c-product-gallery__timer js-counter" data-countdown="" data-countdownseconds=""></div>
        </div>
        <div class="c-gallery ">
            <div class="c-gallery__item">
                <ul class="c-gallery__options">
                    <li>
                        <button id="add-to-favorite-button" class="btn-option btn-option--wishes"></button><span class="c-tooltip c-tooltip--left c-tooltip--short 	glyphicon glyphicon-heart-empty">افزودن به علاقه&zwnj;مندی</span>
                    </li>
                    <li>
                        <button id="add-to-bookmark-button" class="btn-option btn-option--wishes"></button><span class="c-tooltip c-tooltip--left c-tooltip--short glyphicon glyphicon-heart-empty">افزودن به نشان</span>
                    </li>
                </ul>

                <div class="c-gallery__img">
                    <img class="js-gallery-img" data-src="https://dkstatics-public.digikala.com/digikala-products/114358181.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" title="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت" data-zoom-image="https://dkstatics-public.digikala.com/digikala-products/114358181.jpg?x-oss-process=image/resize,w_1280/quality,q_80" src="https://dkstatics-public.digikala.com/digikala-products/114358181.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80">
                </div>

            </div>

            <ul class="c-gallery__items">

                <li class="is-diviter">
                    <div class="thumb-wrapper thumb-wrapper--blur js-gallery-video" data-snt-event="dkProductPageClick" data-snt-params="{&quot;item&quot;:&quot;gallery-option&quot;,&quot;item_option&quot;:&quot;video&quot;}">
                        <img src="https://dkstatics-public.digikala.com/digikala-products/114358181.jpg?x-oss-process=image/resize,m_lfit,h_150,w_150/quality,q_80">
                        <div class="c-gallery__count-circle">
                            <div class="btn-option btn-option--play-video"></div><span class="c-tooltip c-tooltip--left c-tooltip--short">نمایش ویدیو</span>
                        </div>
                    </div>
                </li>

                <li class="js-product-thumb-img" data-slide-index="2" data-event="album_usage" data-event-category="product_page" data-event-label="2212020-num of pics:36">
                    <div class="thumb-wrapper">
                        <img src="https://dkstatics-public.digikala.com/digikala-products/114359700.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        <div class="c-gallery__images-count"><span class="c-gallery__count-circle"><div class="c-gallery__three-bullets"></div></span>
                        </div>
                    </div>
                </li>

                <li class="js-product-thumb-img" data-slide-index="3" data-event="album_usage" data-event-category="product_page" data-event-label="2212020-num of pics:36">
                    <div class="thumb-wrapper">
                        <img src="https://dkstatics-public.digikala.com/digikala-products/114359706.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        <div class="c-gallery__images-count"><span class="c-gallery__count-circle"><div class="c-gallery__three-bullets"></div></span>
                        </div>
                    </div>
                </li>

                <li class="js-product-thumb-img" data-slide-index="4" data-event="album_usage" data-event-category="product_page" data-event-label="2212020-num of pics:36">
                    <div class="thumb-wrapper">
                        <img src="https://dkstatics-public.digikala.com/digikala-products/114359707.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        <div class="c-gallery__images-count"><span class="c-gallery__count-circle"><div class="c-gallery__three-bullets"></div></span>
                        </div>
                    </div>
                </li>

                <li class="js-product-thumb-img" data-slide-index="5" data-event="album_usage" data-event-category="product_page" data-event-label="2212020-num of pics:36">
                    <div class="thumb-wrapper">
                        <img src="https://dkstatics-public.digikala.com/digikala-products/114359708.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        <div class="c-gallery__images-count">
                            <span class="c-gallery__count-circle">
                                <div class="c-gallery__three-bullets"></div>
                            </span>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </section>
</article>

<div class="remodal-wrapper remodal-is-closed" id="my_gallery">
    <div class="remodal c-remodal-gallery remodal-is-initialized remodal-is-closed" data-remodal-id="gallery" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc" tabindex="-1">
        <div class="c-remodal-gallery__main js-level-one-gallery is-open">
            <div class="c-remodal-gallery__top-bar">
                <div class="c-remodal-gallery__tabs js-top-bar-tabs">
                    <div class="c-remodal-gallery__tab js-gallery-tab c-remodal-gallery__tab--selected" data-id="1">تصاویر رسمی</div>
                </div>
                <button onclick="$('#my_gallery').removeClass('remodal-is-opened').addClass('remodal-is-closed')" class="c-remodal-gallery__close"></button>
            </div>

            <div class="c-remodal-gallery__content js-gallery-tab-content is-active" id="gallery-content-1">

                <div class="c-remodal-gallery__main-img js-gallery-main-img js-video-container">
                    <div class="video-js vjs-default-skin vjs-big-play-centered vjs-paused vjs-fluid pdp-video-container-dimensions vjs-controls-enabled vjs-workinghover vjs-v7 vjs-user-active" id="pdp-video-container" tabindex="-1" role="region" lang="en-us" aria-label="Video Player">
                        <video id="pdp-video-container_html5_api" class="vjs-tech" tabindex="-1" role="application" preload="auto"></video>
                        <div class="vjs-poster vjs-hidden" tabindex="-1" aria-disabled="false"></div>
                        <div class="vjs-text-track-display" aria-live="off" aria-atomic="true"></div>
                        <div class="vjs-loading-spinner" dir="ltr"><span class="vjs-control-text">Video Player is loading.</span>
                        </div>
                        <button class="vjs-big-play-button" type="button" title="Play Video" aria-disabled="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Play Video</span>
                        </button>
                        <div class="vjs-control-bar" dir="ltr">
                            <button class="vjs-play-control vjs-control vjs-button" type="button" title="Play" aria-disabled="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Play</span>
                            </button>
                            <div class="vjs-volume-panel vjs-control vjs-volume-panel-horizontal">
                                <button class="vjs-mute-control vjs-control vjs-button" type="button" title="Mute" aria-disabled="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Mute</span>
                                </button>
                                <div class="vjs-volume-control vjs-control vjs-volume-horizontal">
                                    <div tabindex="0" class="vjs-volume-bar vjs-slider-bar vjs-slider vjs-slider-horizontal" role="slider" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" aria-label="Volume Level" aria-live="polite" aria-valuetext="100%">
                                        <div class="vjs-volume-level"><span class="vjs-control-text"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vjs-current-time vjs-time-control vjs-control"><span class="vjs-control-text" role="presentation">Current Time </span><span class="vjs-current-time-display" aria-live="off" role="presentation">0:00</span>
                            </div>
                            <div class="vjs-time-control vjs-time-divider" aria-hidden="true">
                                <div><span>/</span>
                                </div>
                            </div>
                            <div class="vjs-duration vjs-time-control vjs-control"><span class="vjs-control-text" role="presentation">Duration </span><span class="vjs-duration-display" aria-live="off" role="presentation">0:00</span>
                            </div>
                            <div class="vjs-progress-control vjs-control">
                                <div tabindex="0" class="vjs-progress-holder vjs-slider vjs-slider-horizontal" role="slider" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" aria-label="Progress Bar">
                                    <div class="vjs-load-progress"><span class="vjs-control-text"><span>Loaded</span>: <span class="vjs-control-text-loaded-percentage">0%</span></span>
                                    </div>
                                    <div class="vjs-mouse-display">
                                        <div class="vjs-time-tooltip" aria-hidden="true"></div>
                                    </div>
                                    <div class="vjs-play-progress vjs-slider-bar" aria-hidden="true">
                                        <div class="vjs-time-tooltip" aria-hidden="true"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="vjs-live-control vjs-control vjs-hidden">
                                <div class="vjs-live-display" aria-live="off"><span class="vjs-control-text">Stream Type </span>LIVE</div>
                            </div>
                            <button class="vjs-seek-to-live-control vjs-control vjs-at-live-edge" type="button" title="Seek to live, currently playing live" aria-disabled="true"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Seek to live, currently playing live</span><span class="vjs-seek-to-live-text" aria-hidden="true">LIVE</span>
                            </button>
                            <div class="vjs-remaining-time vjs-time-control vjs-control"><span class="vjs-control-text" role="presentation">Remaining Time </span><span aria-hidden="true">-</span><span class="vjs-remaining-time-display" aria-live="off" role="presentation">0:00</span>
                            </div>
                            <div class="vjs-custom-control-spacer vjs-spacer "></div>
                            <div class="vjs-playback-rate vjs-menu-button vjs-menu-button-popup vjs-control vjs-button vjs-hidden">
                                <button class="vjs-playback-rate vjs-menu-button vjs-menu-button-popup vjs-button" type="button" aria-disabled="false" title="Playback Rate" aria-haspopup="true" aria-expanded="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Playback Rate</span>
                                </button>
                                <div class="vjs-menu">
                                    <ul class="vjs-menu-content" role="menu"></ul>
                                </div>
                                <div class="vjs-playback-rate-value">1x</div>
                            </div>
                            <div class="vjs-chapters-button vjs-menu-button vjs-menu-button-popup vjs-control vjs-button vjs-hidden">
                                <button class="vjs-chapters-button vjs-menu-button vjs-menu-button-popup vjs-button" type="button" aria-disabled="false" title="Chapters" aria-haspopup="true" aria-expanded="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Chapters</span>
                                </button>
                                <div class="vjs-menu">
                                    <ul class="vjs-menu-content" role="menu">
                                        <li class="vjs-menu-title" tabindex="-1">Chapters</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="vjs-descriptions-button vjs-menu-button vjs-menu-button-popup vjs-control vjs-button vjs-hidden">
                                <button class="vjs-descriptions-button vjs-menu-button vjs-menu-button-popup vjs-button" type="button" aria-disabled="false" title="Descriptions" aria-haspopup="true" aria-expanded="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Descriptions</span>
                                </button>
                                <div class="vjs-menu">
                                    <ul class="vjs-menu-content" role="menu">
                                        <li class="vjs-menu-item vjs-selected" tabindex="-1" role="menuitemradio" aria-disabled="false" aria-checked="true"><span class="vjs-menu-item-text">descriptions off</span><span class="vjs-control-text" aria-live="polite">, selected</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="vjs-subs-caps-button vjs-menu-button vjs-menu-button-popup vjs-control vjs-button vjs-hidden">
                                <button class="vjs-subs-caps-button vjs-menu-button vjs-menu-button-popup vjs-button" type="button" aria-disabled="false" title="Captions" aria-haspopup="true" aria-expanded="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Captions</span>
                                </button>
                                <div class="vjs-menu">
                                    <ul class="vjs-menu-content" role="menu">
                                        <li class="vjs-menu-item vjs-texttrack-settings" tabindex="-1" role="menuitem" aria-disabled="false"><span class="vjs-menu-item-text">captions settings</span><span class="vjs-control-text" aria-live="polite">, opens captions settings dialog</span>
                                        </li>
                                        <li class="vjs-menu-item vjs-selected" tabindex="-1" role="menuitemradio" aria-disabled="false" aria-checked="true"><span class="vjs-menu-item-text">captions off</span><span class="vjs-control-text" aria-live="polite">, selected</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="vjs-audio-button vjs-menu-button vjs-menu-button-popup vjs-control vjs-button vjs-hidden">
                                <button class="vjs-audio-button vjs-menu-button vjs-menu-button-popup vjs-button" type="button" aria-disabled="false" title="Audio Track" aria-haspopup="true" aria-expanded="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Audio Track</span>
                                </button>
                                <div class="vjs-menu">
                                    <ul class="vjs-menu-content" role="menu"></ul>
                                </div>
                            </div>
                            <button class="vjs-picture-in-picture-control vjs-control vjs-button" type="button" title="Picture-in-Picture" aria-disabled="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Picture-in-Picture</span>
                            </button>
                            <button class="vjs-fullscreen-control vjs-control vjs-button" type="button" title="Fullscreen" aria-disabled="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Fullscreen</span>
                            </button>
                        </div>

                    </div>
                </div>

                <div class="c-remodal-gallery__main-img js-gallery-main-img js-img-main-1" data-slide-title="Slide ">
                    <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359700.jpg?x-oss-process=image/resize,h_1600/quality,q_80" data-high-res-src="https://dkstatics-public.digikala.com/digikala-products/114359700.jpg?x-oss-process=image/resize,h_1600/quality,q_80" class="pannable-image" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت main 1 1" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359700.jpg?x-oss-process=image/resize,h_1600/quality,q_80">
                </div>
                <div class="c-remodal-gallery__main-img js-gallery-main-img js-img-main-2" data-slide-title="Slide 1">
                    <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359706.jpg?x-oss-process=image/resize,h_1600/quality,q_80" data-high-res-src="https://dkstatics-public.digikala.com/digikala-products/114359706.jpg?x-oss-process=image/resize,h_1600/quality,q_80" class="pannable-image" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت main 1 2" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359706.jpg?x-oss-process=image/resize,h_1600/quality,q_80">
                </div>
                <div class="c-remodal-gallery__main-img js-gallery-main-img js-img-main-3 is-active" data-slide-title="Slide 2">
                    <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359707.jpg?x-oss-process=image/resize,h_1600/quality,q_80" data-high-res-src="https://dkstatics-public.digikala.com/digikala-products/114359707.jpg?x-oss-process=image/resize,h_1600/quality,q_80" class="pannable-image" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت main 1 3" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359707.jpg?x-oss-process=image/resize,h_1600/quality,q_80">
                </div>
                <div class="c-remodal-gallery__main-img js-gallery-main-img js-img-main-4" data-slide-title="Slide 3">
                    <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359708.jpg?x-oss-process=image/resize,h_1600/quality,q_80" data-high-res-src="https://dkstatics-public.digikala.com/digikala-products/114359708.jpg?x-oss-process=image/resize,h_1600/quality,q_80" class="pannable-image" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت main 1 4" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359708.jpg?x-oss-process=image/resize,h_1600/quality,q_80">
                </div>

                <div class="c-remodal-gallery__info">
                    <div class="c-remodal-gallery__title">گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت</div>
                    <div class="c-remodal-gallery__thumbs js-official-thumbs">
                        <div class="c-remodal-gallery__thumb is-video js-image-thumb" data-video-cover="https://dkstatics-public.digikala.com/digikala-video-cover/100007717.jpg?x-oss-process=image/resize,w_600/quality,q_80" data-video-src="https://dkstatics-public.digikala.com/digikala-video-playlist/100005174.m3u8" data-id="1">
                            <img data-src="https://dkstatics-public.digikala.com/digikala-video-cover/100007717.jpg?x-oss-process=image/resize,m_fill,h_115,w_115" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت video" src="https://dkstatics-public.digikala.com/digikala-video-cover/100007717.jpg?x-oss-process=image/resize,m_fill,h_115,w_115">
                        </div>
                        <div class="c-remodal-gallery__thumb js-image-thumb" data-order="1">
                            <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359700.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت thumb 2 1" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359700.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        </div>
                        <div class="c-remodal-gallery__thumb js-image-thumb" data-order="2">
                            <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359706.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت thumb 2 2" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359706.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        </div>
                        <div class="c-remodal-gallery__thumb js-image-thumb c-remodal-gallery__thumb--selected" data-order="3">
                            <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359707.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت thumb 2 3" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359707.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        </div>
                        <div class="c-remodal-gallery__thumb js-image-thumb" data-order="4">
                            <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359708.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت thumb 2 4" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359708.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        </div>
                        <div class="c-remodal-gallery__thumb js-image-thumb" data-order="5">
                            <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359709.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت thumb 2 5" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359709.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        </div>
                        <div class="c-remodal-gallery__thumb js-image-thumb" data-order="6">
                            <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359710.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت thumb 2 6" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359710.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        </div>
                        <div class="c-remodal-gallery__thumb js-image-thumb" data-order="7">
                            <img data-src="https://dkstatics-public.digikala.com/digikala-products/114359711.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60" title="" alt="گوشی موبایل شیائومی مدل Redmi Note 8 Pro m1906g7G دو سیم&zwnj; کارت ظرفیت 128 گیگابایت thumb 2 7" data-type="" src="https://dkstatics-public.digikala.com/digikala-products/114359711.jpg?x-oss-process=image/resize,m_lfit,h_115,w_115/quality,q_60">
                        </div>

                    </div>

                </div>
            </div>

            <div class="c-remodal-gallery__content c-remodal-gallery__content--comments js-gallery-tab-content js-comments-with-thumbnails" id="gallery-content-2">
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg  is-video js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/36653.mp4" data-index="0" data-comment-id="6962416"></div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg  is-video js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/49793.mp4" data-index="0" data-comment-id="7373385"></div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/53096.JPG?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="0" data-comment-id="7492414">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/53096.JPG?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/61011.jpeg?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="0" data-comment-id="7762428">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/61011.jpeg?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/61012.jpeg?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="1" data-comment-id="7762428">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/61012.jpeg?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/62364.JPG?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="0" data-comment-id="7799349">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/62364.JPG?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/62365.JPG?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="1" data-comment-id="7799349">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/62365.JPG?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg  is-video js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/74820.mp4" data-index="0" data-comment-id="7132468"></div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/81081.jpg?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="0" data-comment-id="8342909">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/81081.jpg?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/87093.jpg?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="0" data-comment-id="8493971">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/87093.jpg?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/87095.jpg?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="1" data-comment-id="8493971">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/87095.jpg?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/87097.jpg?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="2" data-comment-id="8493971">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/87097.jpg?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg  is-video js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/104484.mp4" data-index="0" data-comment-id="8921201"></div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg  is-video js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/127794.mp4" data-index="0" data-comment-id="9469865"></div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg  is-video js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/9debfd5b9d3553e44f187ef26da299f630eee19a.mp4" data-index="0" data-comment-id="9485570"></div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/82f0936c6f5bf63b43cf5d596ccbd6544ff0e846.jpg?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="1" data-comment-id="9485570">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/82f0936c6f5bf63b43cf5d596ccbd6544ff0e846.jpg?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/e28ca75391e33ca5a274691cb8352a07bb21c14f.jpg?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="2" data-comment-id="9485570">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/e28ca75391e33ca5a274691cb8352a07bb21c14f.jpg?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/fe688d991d9605821e11dc4baa2442234046468c_1593801386.jpg?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="0" data-comment-id="9839819">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/fe688d991d9605821e11dc4baa2442234046468c_1593801386.jpg?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg   js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/56b2c241ac4b3b4016b446757e6730df48165748_1593873350.jpg?x-oss-process=image/resize,m_lfit,h_1024,w_1024/quality,q_80" data-index="0" data-comment-id="9862236">
                    <img src="https://dkstatics-public.digikala.com/digikala-comment-files/56b2c241ac4b3b4016b446757e6730df48165748_1593873350.jpg?x-oss-process=image/resize,m_lfit,h_240,w_240/quality,q_80" alt="">
                </div>
                <div class="c-remodal-gallery__comment-thumbnail c-remodal-gallery__comment-thumbnail--bg  is-video js-comment-thumbnail" data-src="https://dkstatics-public.digikala.com/digikala-comment-files/e6ae02f1437873bc8f70cf1bd74d4b4cb27f4529_1594044843.mp4" data-index="0" data-comment-id="9917140"></div>
            </div>
        </div>
    </div>
</div>

    <script>

        $(".thumb-wrapper").on('click', function () {

            $("#my_gallery").removeClass('remodal-is-closed').addClass('remodal-is-opened');

        });

        function buy() {
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('buyService')}}',
                data: {
                    id: '{{$service->id}}'
                },
                success: function (res) {

                    if(res === "nok1") {
                        $("#buyErr").empty().append("شما اجازه خرید این محصول را ندارید.");
                    }

                    else if(res === "nok2") {
                        $("#buyErr").empty().append("این خدمت از قبل برعهده گرفته شده است.");
                    }

                    else if(res === "nok3") {
                        $("#buyErr").empty().append("این خدمت را قبلا برعهده گرفته اید.");
                    }

                    else if(res === "nok5") {
                        $("#buyErr").empty().append("عملیات مورد نظر غیرمجاز است.");
                    }

                    else if(res === "ok") {
                        document.location.href = '{{route('myServices')}}';
                    }

                }
            });
        }

        function bookmark() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('bookmark')}}',
                data: {
                    id: '{{$service->id}}',
                    mode: '{{getValueInfo('productMode')}}'
                },
                success: function (res) {
                    if(res === "ok")
                        $("#bookmark").removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
                    else
                        $("#bookmark").removeClass('glyphicon-heart').addClass('glyphicon-heart-empty');
                }
            });

        }

        function like() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('like')}}',
                data: {
                    id: '{{$service->id}}',
                    mode: '{{getValueInfo('serviceMode')}}'
                },
                success: function (res) {
                    if(res === "ok")
                        $("#like").removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
                    else
                        $("#like").removeClass('glyphicon-heart').addClass('glyphicon-heart-empty');
                }
            });

        }

    </script>

@stop
