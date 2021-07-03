@extends('layouts.structure')

@section('header')
    @parent

    <style>
        th, td {
            text-align: center;
            padding: 7px;
            border: 1px solid #444;
        }

        .calendar {
            z-index: 1000000000000 !important;
        }
    </style>


    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/calendar-setup.js") }}></script>
    <script src= {{URL::asset("js/calendar-fa.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>
    <link rel="stylesheet" href="{{URL::asset('css/standalone.css')}}">
    <link rel="stylesheet" href= {{URL::asset("css/calendar-green.css") }}>

    <script src="//cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>

@stop

@section('content')

    <div class="col-sm-12" style="margin-top: 100px">

        <center>

            @if(isset($err) && $err == 2)
                <h1 style="color: red">شما اجازه تعریف محصول را ندارید چون هنوز محتوایی برای پروژه غیرعینی ایشان بارگذاری نشده است.</h1>
            @endif

            <h3>
                <a href="{{route('unDoneProjectsReportExcel', ['gradeId' => $gradeId])}}">دریافت فایل اکسل</a>
            </h3>

            <div>
                <span>پروژه مورد نظر</span>
                <select id="mySelect" onchange="filter(this.value)">
                    <option value="-1">همه</option>
                    @foreach($allTitles as $title)
                        <option value="{{$title}}">{{$title}}</option>
                    @endforeach
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
                           id="date_input_start" onchange="start()" readonly>

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
                           id="date_input_end" onchange="end()" readonly>

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
                    <td>محتوا غیرعینی</td>
                    <td>وضعیت تایید محتوا غیرعینی</td>
                    <td>تاریخ پذیرش پروژه</td>
                    <td>عملیات</td>
                </tr>

                <?php $i = 1; ?>
                @foreach($projects as $project)
                    <tr class="myTr" data-value="{{$project->title}}" id="myTr_{{$project->id}}">
                        <td>{{$i}}</td>
                        <td>{{$project->name}}</td>
                        <td>{{$project->title}}</td>
                        @if($project->adv == null)
                            <td>فایلی بارگذاری نشده</td>
                        @else
                            <td><a id="adv_download_{{$project->id}}" download href="{{$project->adv}}">دانلود فایل</a></td>
                        @endif
                        <td id="adv_status_{{$project->id}}">
                            @if($project->adv_status == 1)
                                تایید شده
                            @elseif($project->adv_status == 0)
                                تایید نشده
                            @else
                                رد شده
                            @endif
                        </td>

                        @if($project->file == null)
                            <td>فایلی بارگذاری نشده</td>
                        @else
                            <td><a id="file_download_{{$project->id}}" download href="{{$project->file}}">دانلود فایل</a></td>
                        @endif

                        <td id="file_status_{{$project->id}}">{{($project->file_status == 1) ? "تایید شده" : ($project->file_status == 0) ? "تایید نشده" : "رد شده"}}</td>

                        <td>{{$project->Bdate . '    ساعت     ' . $project->time}}</td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteBuyProject('{{$project->id}}')">بازپس گیری پروژه</button>
                            <button class="btn btn-default" onclick="addProduct('{{$project->projectId}}', '{{$project->title}}', '{{$project->user_id}}')">تعریف محصول برای این پروژه</button>

                            @if($project->adv != null &&
                                ($project->adv_status == 0 || $project->adv_status == -1)
                            )
                                <button id="accept_adv_{{$project->id}}" class="btn btn-success" onclick="setAdvStatus('{{$project->id}}', 1)">تایید تبلیغ</button>
                            @endif
                            @if($project->adv != null &&
                                ($project->adv_status == 0 || $project->adv_status == 1)
                            )
                                <button id="reject_adv_{{$project->id}}" class="btn btn-warning" onclick="setAdvStatus('{{$project->id}}', -1)">رد تبلیغ</button>
                            @endif

                            @if($project->file != null && !$project->physical &&
                                ($project->file_status == 0 || $project->file_status == -1)
                            )
                                <button id="accept_file_{{$project->id}}" class="btn btn-primary" onclick="setFileStatus('{{$project->id}}', 1)">تایید محتوا غیرعینی</button>
                            @endif
                            @if($project->file != null && !$project->physical &&
                                ($project->file_status == 0 || $project->file_status == 1)
                            )
                                <button id="reject_file_{{$project->id}}" class="btn btn-warning" onclick="setFileStatus('{{$project->id}}', -1)">رد محتوا غیرعینی</button>
                            @endif

                        </td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </table>
        </center>

    </div>

    <div id="myAddModal" class="modal">

        <form action="{{route('addProduct', ['gradeId' => $gradeId])}}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="modal-content" style="width: 75% !important;">

                <center>

                    <input type="hidden" name="username" id="hiddenUsername">

                    <h5 style="padding-right: 5%;">نام محصول</h5>
                    <input type="text" name="name" id="projectName" required maxlength="100">

                    <h5 style="padding-right: 5%;">قیمت محصول</h5>
                    <input type="number" name="price" required min="0">

                    <h5 style="padding-right: 5%;">ستاره های محصول</h5>
                    <input type="number" name="star" required min="0">

                    <input type="hidden" id="projectId" name="project">

                    <div>
                        <span>تاریخ شروع نمایش</span>
                        <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="show_date_btn">
                        <br/>
                        <input type="text" name="start_show" id="date_input_show" readonly>
                        <script>
                            Calendar.setup({
                                inputField: "date_input_show",
                                button: "show_date_btn",
                                ifFormat: "%Y/%m/%d",
                                dateType: "jalali"
                            });
                        </script>
                    </div>

                    <div style="margin: 10px">
                        <span>زمان شروع نمایش</span>
                        <input type="time" name="start_time">
                    </div>


                    <div>
                        <span>تاریخ شروع خرید</span>
                        <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="buy_date_btn">
                        <br/>
                        <input type="text" name="start_date_buy" id="date_input_buy" readonly>
                        <script>
                            Calendar.setup({
                                inputField: "date_input_buy",
                                button: "buy_date_btn",
                                ifFormat: "%Y/%m/%d",
                                dateType: "jalali"
                            });
                        </script>
                    </div>

                    <div style="margin: 10px">
                        <span>زمان شروع خرید</span>
                        <input value="12:00" type="time" name="start_time_buy">
                    </div>

                    <h5>توضیح محصول</h5>
                    <textarea id="editor1" cols="80" name="description"></textarea>

                    <h5 style="padding-right: 5%;">تصاویر محصول(اختیاری)</h5>
                    <input type="file" name="file" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

                    <h5 style="padding-right: 5%;">آموزش محصول(اختیاری)</h5>
                    <input type="file" name="attach" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

                    <h5 style="padding-right: 5%;">تبلیغات محصول(اختیاری)</h5>
                    <input type="file" name="trailer" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

                </center>

                <div style="margin-top: 20px">
                    <input type="submit" value="افزودن" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                    <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('myAddModal').style.display = 'none'">
                </div>
            </div>
        </form>
    </div>

    <script>

        function addProduct(pId, name, userId) {
            $("#projectId").val(pId);
            $("#projectName").val(name);
            $("#hiddenUsername").val(userId);
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;

            CKEDITOR.replace('editor1');

            document.getElementById('myAddModal').style.display = 'block';
        }

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

        function setFileStatus(pbId, status) {

            $.ajax({
                type: 'post',
                url: '{{route('setFileStatus')}}',
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
                            $("#accept_file_" + pbId).remove();
                            $("#file_status_" + pbId).empty().append("تایید شده");
                        }
                        else {
                            $("#file_download_" + pbId).remove();
                            $("#reject_file_" + pbId).remove();
                            $("#accept_file_" + pbId).remove();
                            $("#file_status_" + pbId).empty().append("رد شده");
                        }
                    }
                    else
                        alert("عملیات موردنظر با خطا مواجه شده است.");
                }
            });

        }

        function filter(id) {

            if(id == -1) {
                $(".myTr").removeClass('hidden');
            }
            else {
                $(".myTr").addClass('hidden').each(function () {

                    if($(this).attr("data-value") == id)
                        $(this).removeClass("hidden");

                });

            }

            doChange();

        }

        function deleteBuyProject(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteBuyProject')}}',
                data: {
                    id: id,
                },
                success: function (res) {

                    if(res === "ok")
                        $("#myTr_" + id).remove();

                }
            });

        }


        var start_time;
        var examsStartValue = [];
        var examsEndValue = [];
        var stateValue = [];
        var end_time;
        var exams = {!! json_encode($projects) !!} ;

        for (j = 0; j < exams.length; j++) {
            examsEndValue[j] = 1;
            examsStartValue[j] = 1;
            stateValue[j] = 1;
        }

        function start() {
            start_time = document.getElementById('date_input_start').value;
            start_time = start_time.split('/');
            changeStartTime()
        }

        function end() {
            end_time = document.getElementById('date_input_end').value;
            end_time = end_time.split('/');
            changeEndTime();
        }

        function changeStartTime() {

            for (i = 0; i < exams.length; i++) {

                day = parseInt((exams[i].date.split("-")[2]));
                month = parseInt((exams[i].date.split("-")[1]));
                year = parseInt((exams[i].date.split("-")[0]));

                if (year == start_time[0]) {
                    if (month == start_time[1]) {
                        if (day >= start_time[2]) {
                            examsStartValue[i] = 1;
                        }
                        else {
                            examsStartValue[i] = 0;
                        }
                    }
                    else if (month > start_time[1]) {
                        examsStartValue[i] = 1;
                    }
                    else {
                        examsStartValue[i] = 0;
                    }
                }
                else if (year > start_time[0]) {
                    examsStartValue[i] = 1;
                }
                else {
                    examsStartValue[i] = 0;
                }
            }

            filter($("#mySelect").val());
        }

        function changeEndTime() {
            for (i = 0; i < exams.length; i++) {

                day = parseInt((exams[i].date.split("-")[2]));
                month = parseInt((exams[i].date.split("-")[1]));
                year = parseInt((exams[i].date.split("-")[0]));

                if (year == end_time[0]) {
                    if (month == end_time[1]) {
                        if (day <= end_time[2]) {
                            examsEndValue[i] = 1;
                        }
                        else {
                            examsEndValue[i] = 0;
                        }
                    }
                    else if (month < end_time[1]) {
                        examsEndValue[i] = 1;
                    }
                    else {
                        examsEndValue[i] = 0;
                    }
                }
                else if (year < end_time[0]) {
                    examsEndValue[i] = 1;
                }
                else {
                    examsEndValue[i] = 0;
                }
            }

            filter($("#mySelect").val());
        }

        function doChange() {

            var x = 0;

            for (i = 0; i < exams.length; i++) {

                if(!$("#myTr_" + exams[i].id).hasClass('hidden')) {

                    if (examsStartValue[i] + examsEndValue[i] + stateValue[i] != 3) {
                        $("#myTr_" + exams[i].id).addClass("hidden");
                    }
                    else {
                        x++;
                    }
                }

            }

            $("#totalCount").empty().append(x);
        }

        f();

        function f() {

            // var addr = 'http://127.0.0.1:8080/api/countries';
            var addr = 'http://185.239.106.26:8080/api/countries';
            // var addr = 'http://185.239.106.26/api/place/getNearbies/606ddc223f04952c46589811';

            $.ajax({
                type: 'get',
                url: addr,
                success: function (res) {
                    res = JSON.parse(res);
                    console.log(res);
                }
            });

        }

    </script>

@stop
