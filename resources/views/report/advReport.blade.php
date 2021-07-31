@extends('layouts.structure')

@section('header')
    @parent

    <style>
        th, td {
            text-align: center;
            padding: 7px;
            border: 1px solid #444;
        }

    </style>


    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/calendar-setup.js") }}></script>
    <script src= {{URL::asset("js/calendar-fa.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>
    <link rel="stylesheet" href="{{URL::asset('css/standalone.css')}}">
    <link rel="stylesheet" href= {{URL::asset("css/calendar-green.css") }}>
    <script>
        var items = {!! json_encode($projects) !!} ;
    </script>
@stop

@section('content')

    <div class="col-sm-12" style="margin-top: 100px">

        <center>

            <div  class="col-md-6 col-xs-12">
                <span>پروژه مورد نظر</span>
                <select id="mySelect" onchange="filter()">
                    <option value="-1">همه</option>
                    @foreach($allTitles as $title)
                        <option value="{{$title}}">{{$title}}</option>
                    @endforeach
                </select>
            </div>

            <div  class="col-md-6 col-xs-12">
                <span>آزاد/عادی</span>
                <select id="extra" onchange="filter()">
                    <option value="-1">همه</option>
                    <option value="1">آزاد</option>
                    <option value="0">عادی</option>
                </select>
            </div>

            <div class="col-xs-12" style="margin-top: 5px; direction: rtl">

                <div style="display: inline-block; width: auto; margin-right: 10%; margin-left: 5%; float: right;">
                    <span style="float: right; margin-top: 6%;">    از تاریخ:   </span>
                    <label style="">
                        <input type="button"
                               style="border: none;  margin-top: 5%; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;"
                               id="date_btn_Start">
                    </label>
                    <input type="text" style="max-width: 200px" class="form-detail"
                           id="date_input_start" onchange="start(); filter();" readonly>

                    <script>
                        Calendar.setup({
                            inputField: "date_input_start",
                            button: "date_btn_Start",
                            ifFormat: "%Y/%m/%d",
                            dateType: "jalali"
                        });
                    </script>
                </div>

                <div style="display: inline-block; width: auto; margin-left: 5%; float: right">
                    <span style="float: right; margin-top: 6%;">تا تاریخ:</span>
                    <label style="">
                        <input type="button"
                               style="border: none;  margin-top: 5%; width: 30px;  height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;"
                               id="date_btn_end">
                    </label>
                    <input type="text" style="max-width: 200px" class="form-detail"
                           id="date_input_end" onchange="end(); filter();" readonly>

                    <script>
                        Calendar.setup({
                            inputField: "date_input_end",
                            button: "date_btn_end",
                            ifFormat: "%Y/%m/%d",
                            dateType: "jalali"
                        });
                    </script>
                </div>

            </div>

            <h3 style="margin-top: 100px"><span>تعداد کل: </span><span>&nbsp;</span><span id="totalCount">{{count($projects)}}</span></h3>

            <table style="margin-top: 40px">
                <tr>
                    <td>ردیف</td>
                    <td>نام کاربر</td>
                    <td>نام پروژه</td>
                    <td>فایل تبلیغ</td>
                    <td>وضعیت تایید تبلیغ</td>
                    <td>تاریخ پذیرش پروژه</td>
                    <td>عملیات</td>
                </tr>

                <?php $i = 1; ?>
                @foreach($projects as $project)
                    <tr class="myTr extra_{{(($project->extra) ? 1 : 0)}}" data-value="{{$project->title}}" id="myTr_{{$project->id}}">
                        <td>{{$i}}</td>
                        <td>{{$project->name}}</td>
                        <td>{{$project->title}}</td>

                        <td><a id="adv_download_{{$project->id}}" download href="{{$project->adv}}">دانلود فایل</a></td>

                        <td id="adv_status_{{$project->id}}">
                            @if($project->adv_status == 1)
                                <p style="background-color: darkseagreen">تایید شده</p>
                            @elseif($project->adv_status == 0)
                                <p style="background-color: cadetblue">تایید نشده</p>
                            @else
                                <p style="background-color: indianred">رد شده</p>
                            @endif
                        </td>

                        <td>{{$project->Bdate . '    ساعت     ' . $project->time}}</td>
                        <td>

                            @if($project->adv_status == 0 || $project->adv_status == -1)
                                <button id="accept_adv_{{$project->id}}" class="btn btn-success" onclick="setAdvStatus('{{$project->id}}', 1)">تایید تبلیغ</button>
                            @endif
                            @if($project->adv_status == 0 || $project->adv_status == 1)
                                <button id="reject_adv_{{$project->id}}" class="btn btn-warning" onclick="setAdvStatus('{{$project->id}}', -1)">رد تبلیغ</button>
                            @endif

                        </td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </table>
        </center>

    </div>

    <script src="{{\Illuminate\Support\Facades\URL::asset("js/dateFilter.js")}}"></script>

    <script>

        function setAdvStatus(pbId, status) {

            $.ajax({
                type: 'post',
                url: '{{route('setAdvStatus')}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: {
                    status: status,
                    pbId: pbId
                },
                success: function (res) {
                    if(res === "ok") {
                        alert("عملیات موردنظر با موفقیت انجام شد.");
                        if(status == 1) {
                            $("#accept_adv_" + pbId).remove();
                            $("#adv_status_" + pbId).empty().append("تایید شده");
                        }
                        else {
                            $("#accept_adv_" + pbId).remove();
                            $("#adv_download_" + pbId).remove();
                            $("#reject_adv_" + pbId).remove();
                            $("#adv_status_" + pbId).empty().append("رد شده");
                        }
                    }
                    else
                        alert("عملیات موردنظر با خطا مواجه شده است.");
                }
            });

        }

        function filter() {

            var mySelect = $("#mySelect").val();
            var extra = $("#extra").val();

            if(mySelect == -1 && extra == -1) {
                $(".myTr").removeClass('hidden');
            }
            else {
                $(".myTr").addClass('hidden').each(function () {
                    if(
                        (mySelect == -1 || $(this).attr("data-value") == mySelect) &&
                        (extra == -1 || $(this).hasClass("extra_" + extra))
                    )
                        $(this).removeClass("hidden");
                });
            }

            doChangeDateFilter();
        }

    </script>
@stop
