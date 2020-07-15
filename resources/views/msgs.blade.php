@extends('layouts.structure')

@section('header')
    @parent
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset("css/chatbox.css")}}">

    <style>

        .fixed-height {
            right: 30% !important;
            top: 15% !important;
        }

    </style>

@stop

@section('content')


    <div id="root">

        <div class="header-wrapper"></div>
        <div class="fixed-height" id="chatbox-container">
            <div class="chatbox  conversation-part--animation" id="msgs">
                <div class="conversation-part conversation-part--question">
                    <div class="avatar-wrapper same-row">
                        <div class="avatar"></div>
                    </div>
                    @if(count($msgs) == 0)
                        <div class="same-row question-part text-ltr">
                            <div class="bubble no-border" style="display: table; direction: unset;">
                                <div class="bubble-label">
                                    <div>به مرکز پشتیبانی خوش آمدید.</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @foreach($msgs as $msg)
                    <div class="conversation-part conversation-part--question" >
                        <div class="avatar-wrapper same-row"></div>
                        <div class="same-row question-part text-ltr" style="{{($msg->is_me) ? "float: left;" : "float: right;"}}">
                            <div class="bubble no-border" style="display: table; direction: unset;">
                                <div class="bubble-label">
                                    <div>{{$msg->text}}</div>
                                </div>

                            </div>

                            <span class="comment">{{$msg->time}}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="composer">
                <pre class="send-button glyphicon glyphicon-send"></pre>
                <textarea id="textInput" placeholder="سوال خود را بنویسید."></textarea>
            </div>

        </div>
        <div class="chat-buttons"></div>

        <div id="chat-bot-widget-refresh" class="glyphicon glyphicon-refresh" title="Close"></div>
    </div>


    <script>

        $(document).ready(function () {

            $("#chat-bot-launcher").on("click", function () {

                $("#root").removeClass("hidden");

            });

            $("#chat-bot-widget-close").on('click', function () {
                $("#root").addClass("hidden");
            });

        });

        $("#textInput").on("keypress", function (e) {

            if(e.keyCode === 13) {
                e.preventDefault();
                sendMsg();
            }

        });

        function sendMsg() {

            var x = $("#textInput").val();
            if(x.length === 0)
                return;

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('sendRes')}}',
                data: {
                    msg: x,
                    chatId: '{{$chatId}}'
                },
                success: function (res) {

                    res = JSON.parse(res);

                    if(res.status === "ok") {

                        var newElem = '<div class="conversation-part conversation-part--question">';
                        newElem += '<div class="avatar-wrapper same-row"></div>';
                        newElem += '<div class="same-row question-part text-ltr" style="float: right">';
                        newElem += '<div class="bubble no-border" style="display: table; direction: unset;">';
                        newElem += '<div class="bubble-label">';
                        newElem += '<div>' + x + '</div></div></div>';
                        newElem += '<span class="comment">' + res.sendTime + '</span>';
                        newElem += '</div></div>';
                        $("#msgs").append(newElem);
                        $("#textInput").val("");
                    }

                }
            });
        }

    </script>

@stop
