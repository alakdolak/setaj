@extends('layouts.siteStructure')

@section('header')
    @parent

    <style>

        #bookmark:hover:before {
            content: "\e005" !important;
        }

        .zoomable:hover {
            transform: scale(1.1);
        }

    </style>

@stop

@section('content')

    <center class="row" style="margin-top: 100px">

        <div class="bookmarkDivTotal">
            <p onclick="bookmark()" class="zoomable bookmarkDiv" onmouseenter="$(this).css('background-color', 'rgb(199, 200, 206)')" onmouseleave="$(this).css('background-color', 'transparent')" style="cursor: pointer; float: left; margin-left: 30px; border: 1px solid #202121; height: 34px; padding: 0 23px; line-height: 30px; background-color: transparent; border-radius: 30px !important;">
                <span>نشان کن</span>
                <span id="bookmark" class="glyphicon {{($bookmark) ? "glyphicon-heart" : "glyphicon-heart-empty"}}" style="margin-right: 4px; cursor: pointer; font-family: 'Glyphicons Halflings' !important;"></span>
            </p>

            <p onclick="like()" class="zoomable bookmarkDiv" onmouseenter="$(this).css('background-color', 'rgb(199, 200, 206)')" onmouseleave="$(this).css('background-color', 'transparent')" style="cursor: pointer; float: left; margin-left: 30px; border: 1px solid #202121; height: 34px; padding: 0 23px; line-height: 30px; background-color: transparent; border-radius: 30px !important;">
                <span>لایک کن</span>
                <span id="like" class="glyphicon {{($like) ? "glyphicon-heart" : "glyphicon-heart-empty"}}" style="margin-right: 4px; cursor: pointer; font-family: 'Glyphicons Halflings' !important;"></span>
            </p>

        </div>

        <h3>{{$project->title}}</h3>

        <div>
            {!! html_entity_decode($project->description) !!}
        </div>

        <p>هزینه: {{$project->price}} سکه</p>

        @if($canBuy)
            <button onclick="buy()" class="btn btn-success">خرید پروژه</button>

            <p style="margin-top: 10px" id="buyErr"></p>
        @endif

        @foreach($project->pics as $pic)
            <img style="width: 250px; margin: 10px; float: right" src="{{$pic}}">
        @endforeach

        <div style="clear: both"></div>
        <h1>فایل های آموزشی</h1>

        @foreach($project->attach as $pic)
            @if($pic["type"] == "png" || $pic["type"] == "jpg" || $pic["type"] == "gif" || $pic["type"] == "bmp" || $pic["type"] == "jpeg")
                <center class="col-xs-12">
                    <img style="width: 250px; margin: 10px; float: right" src="{{$pic["path"]}}">
                </center>
            @elseif($pic["type"] == "mp4")
                <center class="col-xs-12">
                    <video width="320" height="240" controls>
                        <source src="{{$pic["path"]}}" type="video/mp4">
                        مرورگر شما از پخش ویدیو پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                    </video>
                </center>
            @elseif($pic["type"] == "mp3")
                <center class="col-xs-12">
                    <audio controls>
                        <source src="{{$pic["path"]}}" type="audio/mpeg">
                        مرورگر شما از پخش موزیک پشتیبانی نمی کند. لطفا مرورگر خود را تغییر دهید.
                    </audio>
                </center>
            @elseif($pic["type"] == "pdf")
                <center class="col-xs-12">
                    <embed src="{{$pic["path"]}}" width="800px" height="800px" />
                </center>
            @else
                <center class="col-xs-12">
                    <a href="{{$pic["path"]}}" download>دانلود فایل</a>
                </center>
            @endif
        @endforeach

    </center>

    <script>

        function buy() {
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('buyProject')}}',
                data: {
                    id: '{{$project->id}}'
                },
                success: function (res) {

                    if(res === "nok1") {
                        $("#buyErr").empty().append("شما اجازه خرید این محصول را ندارید.");
                    }

                    else if(res === "nok2") {
                        $("#buyErr").empty().append("شما قبلا این محصول را خریداری کرده اید.");
                    }

                    else if(res === "nok3") {
                        $("#buyErr").empty().append("متاسفانه سکه کافی برای خریداری این پروژه ندارید.");
                    }

                    else if(res === "nok4") {
                        $("#buyErr").empty().append("مهلت خریداری این محصول به پایان رسیده است.");
                    }

                    else if(res === "nok5") {
                        $("#buyErr").empty().append("عملیات مورد نظر غیرمجاز است.");
                    }

                    else if(res === "ok") {
                        document.location.href = '{{route('myProjects')}}';
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
                    id: '{{$project->id}}',
                    mode: '{{getValueInfo('projectMode')}}'
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
                    id: '{{$project->id}}',
                    mode: '{{getValueInfo('projectMode')}}'
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
