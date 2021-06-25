@extends('layouts.structure')

@section('header')
    @parent

    <style>
        th, td {
            text-align: right;
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
{{--    {{URL::asset("js/ckeditor.js") }}--}}
@stop

@section('content')

    <div style="margin-top: 100px">

        <div style="margin: 20px">
            <button onclick="addProject()" class="btn btn-primary">افزودن پروژه شهروندی جدید</button>
        </div>

        <div class="portlet box purple">

            <div class="portlet-title">
                <div class="caption" style="float: right">
                    <i style="float: right" class="fa fa-cogs"></i>
                    <span style="margin-right: 10px">پروژه های شهروندی تعریف شده</span>
                </div>
            </div>
            <div class="portlet-body">

                @if(count($projects) == 0)
                    <h3>پروژه ای تعریف نشده است</h3>
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
                                <th scope="col">عملیات</th>
                                <th scope="col">نام</th>
                                <th scope="col">پایه تحصیلی</th>
                                <th scope="col">تاریخ شروع نمایش</th>
                                <th scope="col">زمان شروع نمایش</th>
                                <th scope="col">تاریخ شروع امکان خرید</th>
                                <th scope="col">تاریخ پایان امکان خرید</th>
                                <th scope="col">تصویر</th>
                                <th scope="col" style="width:450px !important">توضیح</th>
                                <th scope="col">امتیاز پروژه</th>
                                <th scope="col">تاریخ تعریف پروژه</th>
                                <th scope="col">تعداد نفرات خریدار پروژه</th>
                                <th scope="col">تگ</th>
                                <th scope="col">وضعیت نمایش</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($projects as $itr)

                                <?php $str = '-'; ?>
                                @foreach($itr->grades as $grade)
                                    <?php $str .= $grade->name . '-'; ?>
                                @endforeach

                                <tr class="myTr" data-grades="{{$str}}" id="tr_{{$itr->id}}">
                                    <td>{{$i}}</td>
                                    <td>
                                        <button onclick="removeProject('{{$itr->id}}')" class="btn btn-danger" data-toggle="tooltip" title="حذف">
                                            <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-trash"></span>
                                        </button>

                                        <a target="_blank" href="{{route('editCitizen', ['id' => $itr->id])}}" class="btn btn-primary" data-toggle="tooltip" title="ویرایش">
                                            <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-edit"></span>
                                        </a>

                                        <button class="btn btn-warning" onclick="toggleHide('{{$itr->id}}')"><span>تغییر وضعیت نمایش</span></button>

                                    </td>

                                    <td>{{$itr->title}}</td>

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

                                    <td>{{$itr->startShow}}</td>
                                    <td>{{$itr->startTime}}</td>
                                    <td>{{$itr->startReg}}</td>
                                    <td>{{$itr->endReg}}</td>
                                    <td><img width="100px" src="{{$itr->pic}}"></td>
                                    <td>...</td>
                                    <td>{{$itr->point}}</td>
                                    <td>{{$itr->date}}</td>
                                    <td>{{$itr->buyers}}</td>
                                    <td>{{$itr->tag}}</td>
                                    <td>{{$itr->hide}}</td>

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

        <form action="{{route('addCitizen')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content" style="width: 75% !important;">

                <center>

                    <h5 style="padding-right: 5%;">نام پروژه</h5>
                    <input type="text" name="name" required maxlength="100">

                    <h5 style="padding-right: 5%;">امتیاز پروژه</h5>
                    <input type="number" name="point" required min="0">

                    <h5 style="padding-right: 5%;">پایه تحصیلی</h5>
                    <select name="gradeId" required>
                        @foreach($grades as $grade)
                            <option value="{{$grade->id}}">{{$grade->name}}</option>
                        @endforeach
                    </select>

                    <h5>دسته پروژه</h5>
                    <select name="tagId">
                        @foreach($tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->name}}</option>
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

                    <div>
                        <span>تاریخ شروع امکان خرید</span>
                        <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="date_btn">
                        <br/>
                        <input type="text" name="start_reg" id="date_input" readonly>
                        <script>
                            Calendar.setup({
                                inputField: "date_input",
                                button: "date_btn",
                                ifFormat: "%Y/%m/%d",
                                dateType: "jalali"
                            });
                        </script>
                    </div>

                    <div>
                        <span>تاریخ اتمام امکان خرید</span>
                        <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="end_date_btn">
                        <br/>
                        <input type="text" name="end_reg" id="end_date_input" readonly>
                        <script>
                            Calendar.setup({
                                inputField: "end_date_input",
                                button: "end_date_btn",
                                ifFormat: "%Y/%m/%d",
                                dateType: "jalali"
                            });
                        </script>
                    </div>

                    <div style="margin: 10px">
                        <span>زمان شروع نمایش</span>
                        <input type="time" name="start_time">
                    </div>

                    <h5>توضیح پروژه</h5>
                    <textarea id="editor1" cols="80" name="description" required></textarea>

                    <h5 style="padding-right: 5%;">تصاویر پروژه(اختیاری)</h5>
                    <input type="file" name="file" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

                    <h5 style="padding-right: 5%;">فایل های آموزش پروژه(اختیاری)</h5>
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

        function removeGrade(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteGradeCitizen')}}',
                data: {
                    id: id
                },
                success: function (res) {

                    if(res === "ok")
                        $("#grade_" + id).remove();

                }
            });
        }

        function showGrades(id) {
            itemId = id;
            document.getElementById('myGradeModal').style.display = 'block';
        }

        function addNewGrade() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('addGradeCitizen')}}',
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

        CKEDITOR.replace('editor1');

        function addProject() {
            document.getElementById('myAddModal').style.display = 'block';
        }

        function removeProject(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteCitizen')}}',
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
                url: '{{route('toggleHideCitizen')}}',
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
