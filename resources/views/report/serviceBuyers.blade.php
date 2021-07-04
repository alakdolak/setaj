
@extends('layouts.structure')

@section('header')
    @parent
    <style>

        td {
            padding: 7px;
            border: 1px solid;
        }

    </style>
@stop

@section('content')

    <div class="row" style="margin-top: 100px">

        <center>
            <h2 style="color: red">{{($physical) ? "این پروژه همیاری عینی است" : "این پروژه همیاری غیرعینی است."}}</h2>
        </center>

        @if($buyers == null)
            هنوز خریداری نشده است.
        @else

            <center class="col-xs-12">
                <select id="filter" style="margin: 10px;" onchange='filter(this.value, $("#gradeSelect").val())'>
                    <option value="0">تمام خریداران</option>
                    <option value="1">تایید شدگان</option>
                    <option value="-1">تایید نشدگان</option>
                </select>
                <select id="gradeSelect" style="margin: 10px;" onchange="filter($('#filter').val(), this.value)">
                    <option value="-1">همه پایه های تحصیلی</option>
                    @foreach($grades as $grade)
                        <option value="{{$grade->id}}">{{$grade->name}}</option>
                    @endforeach
                </select>
            </center>

        <center class="col-xs-12">

            <p>
                <span id="found">{{count($buyers)}}</span>
                <span>&nbsp;</span>
                <span>مورد یافته شده</span>
            </p>


            <a class="btn btn-default" style="margin: 5px;" href="{{route('serviceBuyersExcel', ['id' => $id])}}" download>دانلود فایل اکسل</a>

            <table>
                <tr>
                    <td>ردیف</td>
                    <td>نام</td>
                    <td>پایه تحصیلی</td>
                    <td>تاریخ</td>
                    @if(!$physical)
                        <td>فایل محتوا</td>
                        <td>وضعیت تایید فایل محتوا</td>
                    @endif
                    <td>وضعیت انجام</td>
                    <td>تعداد ستاره های داده شده</td>
                    <td>عملیات</td>
                </tr>

                <?php $i = 1 ?>
                @foreach($buyers as $buyer)

                    <tr class="myBox {{($buyer["status"]) ? 'confirmed' : 'undone'}} grade_{{$buyer["grade"]}}">
                        <td>{{$i}}</td>
                        <td>{{$buyer["name"]}}</td>
                        <td>{{$buyer["gradeName"]}}</td>
                        <td>{{$buyer["date"] . '     ساعت:     ' . $buyer["time"]}}</td>

                        @if(!$physical)

                            <td>
                                @if($buyer["file"] != null)
                                    <a href="{{$buyer["file"]}}" download>دانلود</a>
                                @else
                                    فایلی بارگذاری نشده است.
                                @endif
                            </td>

                            <td id="file_status_{{$buyer["sbId"]}}">
                                @if($buyer["file_status"] == 1)
                                    تایید شده
                                @elseif($buyer["file_status"] == 0)
                                    تایید نشده
                                @else
                                    رد شده
                                @endif
                            </td>

                        @endif
                        <td>
                            <span>{{($buyer["status"]) ? "انجام شده" : "انجام نشده"}}</span>
                        </td>

                        <td>
                            @if($buyer["status"])
                                <span>{{$buyer["star"]}}</span>
                            @else
                                <span>0</span>
                            @endif
                        </td>
                        <td>
                            @if(!$buyer["status"])
                                <button onclick="confirmJob('{{$star}}', '{{$buyer["id"]}}', '{{$id}}')" class="btn btn-success">تاییده انجام کار</button>
                                <button onclick="deleteJob('{{$buyer["id"]}}', '{{$id}}')" class="btn btn-danger">بازپس گیری خدمت</button>

                                @if($buyer["file"] != null && !$physical &&
                                    ($buyer["file_status"] == 0 || $buyer["file_status"] == -1)
                                )
                                    <button id="accept_file_{{$buyer["sbId"]}}" class="btn btn-primary" onclick="setFileStatus('{{$buyer["sbId"]}}', 1)">تایید محتوا</button>
                                @endif

                                @if($buyer["file"] != null && !$physical &&
                                    ($buyer["file_status"] == 0 || $buyer["file_status"] == 1)
                                )
                                    <button id="reject_file_{{$buyer["sbId"]}}" class="btn btn-warning" onclick="setFileStatus('{{$buyer["sbId"]}}', -1)">رد محتوا</button>
                                @endif

                            @endif
                        </td>
                    </tr>

                    <?php $i++ ?>

                @endforeach

            </table>
        </center>

        @endif
    </div>

    <div id="myConfirmModal" class="modal">


        <center class="modal-content">

            <div>

                <h5 style="padding-right: 5%;">تعداد ستاره مدنظر</h5>
                <select id="starOptions"></select>

            </div>

            <div style="margin-top: 20px">
                <input onclick="done()" type="submit" value="افزودن" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('myConfirmModal').style.display = 'none'">
            </div>
        </center>

    </div>

    <script>

        var serviceId, userId;

        function setFileStatus(sbId, status) {

            $.ajax({
                type: 'post',
                url: '{{route('setServiceFileStatus')}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: {
                    status: status,
                    sbId: sbId
                },
                success: function (res) {
                    if(res === "ok") {
                        alert("عملیات موردنظر با موفقیت انجام شد.");
                        if(status == 1) {
                            $("#accept_file_" + sbId).remove();
                            $("#file_status_" + sbId).empty().append("تایید شده");
                        }
                        else {
                            $("#file_download_" + sbId).remove();
                            $("#reject_file_" + sbId).remove();
                            $("#accept_file_" + sbId).remove();
                            $("#file_status_" + sbId).empty().append("رد شده");
                        }
                    }
                    else
                        alert("عملیات موردنظر با خطا مواجه شده است.");
                }
            });

        }

        function filter(val1, val2) {

            var counter = 0;

            $(".myBox").addClass('hidden').each(function () {

                if(
                    (val1 == 0 || (val1 == 1 && $(this).hasClass('confirmed')) ||
                        (val1 == -1 && $(this).hasClass('undone'))) &&
                    (val2 == -1 || $(this).hasClass('grade_' + val2))
                ) {
                    $(this).removeClass('hidden');
                    counter++;
                }
            });

            $("#found").empty().append(counter);

        }

        function done() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('doneService')}}',
                data: {
                    id: serviceId,
                    star: $("#starOptions").val(),
                    user_id: userId
                },
                success: function (res) {
                    if(res === "ok") {
                        alert("عملیات مورد نظر با موفقیت انجام پذیرفت.");
                        document.getElementById('myConfirmModal').style.display = 'none';
                    }
                    else if(res === "nok2")
                        alert("اول باید محتوای پروژه توسط دانش آموز بارگذاری شود و سپس معلم راهنما آن را تایید کند و درنهایت پروژه تایید نهایی شود.");
                    else
                        alert("خطایی در انجام عملیات مورد نظر رخ داده است.");
                }
            });

        }

        function confirmJob(star, uId, sId) {

            userId = uId;
            serviceId = sId;

            var newElem = "";
            for(i = star; i >= 0; i--) {
                newElem += "<option value='" + i + "'>" + i + "</option>";
            }

            $("#starOptions").empty().append(newElem);

            document.getElementById('myConfirmModal').style.display = 'block';
        }


        function deleteJob(uId, sId) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteJob')}}',
                data: {
                    sId: sId,
                    uId: uId
                },
                success: function (res) {
                    if(res === "ok") {
                        alert("عملیات مورد نظر با موفقیت انجام پذیرفت.");
                    }
                }
            });

        }

    </script>

@stop
