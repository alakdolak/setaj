@extends('layouts.structure')

@section('header')
    @parent

    <style>
        * {
            box-sizing: border-box;
        }

        .column {
            float: left;
            width: 33.33%;
            padding: 5px;
            height: 300px;
            max-height: 300px;

        }

        /* Clearfix (clear floats) */
        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #008CBA;
            overflow: hidden;
            width: 100%;
            height: 100%;
            -webkit-transform: scale(0);
            -ms-transform: scale(0);
            transform: scale(0);
            -webkit-transition: .3s ease;
            transition: .3s ease;
        }

        .container:hover .overlay {
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
        }

        .text {
            color: white;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .container {
            position: relative;
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            border: 1px solid #888;
            width: 30%;
            direction: rtl;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        @-webkit-keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }

        @keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }
        .cke_chrome {
            margin-top: 20px;
            border: none !important;
        }
    </style>

    <style>
        th, td {
            text-align: right;
        }

        .bigTd {
            width: 320px !important;
        }

        .calendar {
            z-index: 1000000000000 !important;
        }

    </style>

    <script src = "{{URL::asset("js/calendar.js") }}"></script>
    <script src = "{{URL::asset("js/calendar-setup.js") }}"></script>
    <script src = "{{URL::asset("js/calendar-fa.js") }}"></script>
    <script src = "{{URL::asset("js/jalali.js") }}"></script>
    <link rel="stylesheet" href = "{{URL::asset("css/calendar-green.css") }}">
    <script src="//cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>

@stop

@section('content')

    <div style="margin-top: 100px">

        <div style="margin: 20px">
            <button onclick="addService()" class="btn btn-primary">افزودن خدمت جدید</button>
        </div>

        <div class="portlet box purple">

            <div class="portlet-title">
                <div class="caption" style="float: right">
                    <i style="float: right" class="fa fa-cogs"></i>
                    <span style="margin-right: 10px">خدمات تعریف شده</span>
                </div>
            </div>
            <div class="portlet-body">

                @if(count($services) == 0)
                    <h3>خدمتی تعریف نشده است</h3>
                @else

                    <div>
                        <span>پایه تحصیلی مورد نظر</span>
                        <select onchange="filter(this.value)">
                            <option value="-1">همه</option>
                            @foreach($grades as $grade)
                                <option value="{{$grade->name}}">{{$grade->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="table-scrollable">

                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                            <tr>
                                <th scope="col">ردیف</th>
                                <th scope="col">نام</th>
                                <th scope="col">عینی/غیرعینی</th>
                                <th scope="col">پایه تحصیلی</th>

                                <th scope="col">تاریخ شروع نمایش خدمت</th>
                                <th scope="col">زمان شروع نمایش خدمت</th>

                                <th scope="col">تاریخ شروع خرید خدمت</th>
                                <th scope="col">زمان شروع خرید خدمت</th>

                                <th scope="col">موجودی</th>
                                <td scope="col">تصویر</td>
                                <th scope="col" style="width:450px !important">توضیح</th>
                                <th scope="col">تعداد ستاره ها</th>
                                <th scope="col">تاریخ تعریف خدمت</th>
                                <th scope="col">وضعیت نمایش</th>
                                <th scope="col">عملیات</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($services as $itr)

                                <?php $str = '-'; ?>
                                @foreach($itr->grades as $grade)
                                    <?php $str .= $grade->name . '-'; ?>
                                @endforeach

                                <tr class="myTr" data-grades="{{$str}}" id="tr_{{$itr->id}}">
                                    <td>{{$i}}</td>
                                    <td>{{$itr->title}}</td>

                                    <td>{{($itr->physical) ? "عینی" : "غیرعینی"}}</td>

                                    <td>
                                        @foreach($itr->grades as $grade)
                                            <button id="grade_{{$grade->id}}" onclick="removeGrade('{{$grade->id}}')" style="margin: 4px" class="btn btn-info">
                                                <span>{{$grade->name}}</span>
                                                <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        @endforeach
                                        <div style="margin-top: 10px">
                                            <button onclick="showGrades('{{$itr->id}}')" class="btn btn-default">افزودن پایه تحصیلی جدید</button>
                                        </div>
                                    </td>

                                    <td>{{$itr->start_show}}</td>
                                    <td>{{$itr->start_time}}</td>

                                    <td>{{$itr->start_buy}}</td>
                                    <td>{{$itr->buy_time}}</td>

                                    <td>{{$itr->capacity}}</td>
                                    <td><img width="100px" src="{{$itr->pic}}"></td>
                                    <td>...</td>
                                    <td>{{$itr->star}}</td>
                                    <td>{{$itr->date}}</td>
                                    <td>{{$itr->hide}}</td>
                                    <td>
                                        <button onclick="removeService('{{$itr->id}}')" class="btn btn-danger" data-toggle="tooltip" title="حذف">
                                            <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-trash"></span>
                                        </button>

                                        <a target="_blank" href="{{route('editService', ['id' => $itr->id])}}" onclick="" class="btn btn-primary" data-toggle="tooltip" title="ویرایش">
                                            <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-edit"></span>
                                        </a>

                                        <button style="margin: 10px" class="btn btn-warning" onclick="toggleHide('{{$itr->id}}')"><span>تغییر وضعیت نمایش</span></button>
                                        <a style="margin: 10px" target="_blank" href="{{route('serviceBuyers', ['id' => $itr->id])}}" class="btn btn-success">مشاهده خریداران</a>
                                    </td>
                                </tr>
                                <?php $i += 1; ?>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <div id="myAddModal" class="modal">

        <form action="{{route('addService')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content" style="width: 75% !important;">

                <center>

                    <h5 style="padding-right: 5%;">نام خدمت</h5>
                    <input type="text" name="name" required maxlength="100">

                    <h5 style="padding-right: 5%;">تعداد ستاره ها</h5>
                    <input type="number" name="star" required min="0">

                    <h5 style="padding-right: 5%;">موجودی</h5>
                    <input type="number" name="capacity" required min="1">

                    <h5 style="padding-right: 5%;">آیا پروژه عینی است؟</h5>
                    <input type="checkbox" name="physical" checked>

                    <h5 style="padding-right: 5%;">پایه تحصیلی</h5>
                    <select name="gradeId" required>
                        @foreach($grades as $grade)
                            <option value="{{$grade->id}}">{{$grade->name}}</option>
                        @endforeach
                    </select>

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
                        <input type="text" name="start_buy" id="date_input_buy" readonly>
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
                        <input type="time" name="buy_time">
                    </div>

                    <h5>توضیح خدمت</h5>
                    <textarea id="editor1" cols="80" name="description" required></textarea>

                    <h5 style="padding-right: 5%;">تصاویر خدمت(اختیاری)</h5>
                    <input type="file" name="file" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

                    <h5 style="padding-right: 5%;">فایل های آموزشی خدمت(اختیاری)</h5>
                    <input type="file" name="attach" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

                </center>

                <div style="margin-top: 20px">
                    <input type="submit" value="افزودن" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                    <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('myAddModal').style.display = 'none'">
                </div>
            </div>
        </form>
    </div>

    <div id="myGradeModal" class="modal">

        <div class="modal-content">

            <div>

                <h5 style="padding-right: 5%;">پایه های تحصیلی</h5>
                <select id="gradeId">
                    @foreach($grades as $grade)
                        <option value="{{$grade->id}}">{{$grade->name}}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-top: 20px">
                <input onclick="addNewGrade()" type="submit" value="افزودن پایه تحصیلی" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('myGradeModal').style.display = 'none'">
            </div>
        </div>

    </div>


    <script>

        var itemId;

        function showGrades(id) {
            itemId = id;
            document.getElementById('myGradeModal').style.display = 'block';
        }

        function removeGrade(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteGradeService')}}',
                data: {
                    id: id
                },
                success: function (res) {

                    if(res === "ok")
                        $("#grade_" + id).remove();

                }
            });
        }


        function addNewGrade() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('addGradeService')}}',
                data: {
                    id: itemId,
                    gradeId: $("#gradeId").val()
                },
                success: function (res) {

                    if(res === "ok")
                        document.location.reload();

                }
            });

        }


        function filter(id) {

            if(id == -1) {
                $(".myTr").removeClass('hidden');
            }
            else {
                $(".myTr").addClass('hidden').each(function () {

                    if($(this).attr("data-grades").includes('-' +  id + '-'))
                        $(this).removeClass("hidden");

                });

            }

        }


        var userId, serviceId;

        CKEDITOR.replace('editor1');

        function addService() {
            document.getElementById('myAddModal').style.display = 'block';
        }

        function removeService(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteService')}}',
                data: {
                    id: id
                },
                success: function (res) {

                    if(res === "ok")
                        $("#tr_" + id).remove();

                }
            });

        }

        function toggleHide(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('toggleHideService')}}',
                data: {
                    id: id
                },
                success: function (res) {

                    if(res === "ok")
                        document.location.reload();

                }
            });

        }

    </script>

@stop
