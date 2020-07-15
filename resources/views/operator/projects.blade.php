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

    <script src = {{URL::asset("js/calendar.js") }}></script>
    <script src = {{URL::asset("js/calendar-setup.js") }}></script>
    <script src = {{URL::asset("js/calendar-fa.js") }}></script>
    <script src = {{URL::asset("js/jalali.js") }}></script>
    <link rel="stylesheet" href = {{URL::asset("css/calendar-green.css") }}>
    <script src="//cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>

@stop

@section('content')

    <center style="margin-top: 100px">

        <div style="margin: 20px">
            <button onclick="addProject()" class="btn btn-primary">افزودن پروژه جدید</button>
        </div>

        <div class="portlet box purple">

            <div class="portlet-title">
                <div class="caption" style="float: right">
                    <i style="float: right" class="fa fa-cogs"></i>
                    <span style="margin-right: 10px">پروژه های تعریف شده</span>
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
                                <option value="{{$grade->id}}">{{$grade->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="table-scrollable">

                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th scope="col">ردیف</th>
                                    <th scope="col">نام</th>
                                    <th scope="col">پایه تحصیلی</th>
                                    <th scope="col">ظرفیت</th>
                                    <th scope="col">تاریخ شروع امکان خرید</th>
                                    <th scope="col">تاریخ پایان امکان خرید</th>
                                    <td scope="col">تصویر</td>
                                    <th scope="col" style="width:450px !important">توضیح</th>
                                    <th scope="col">هزینه پروژه</th>
                                    <th scope="col">تاریخ تعریف پروژه</th>
                                    <th scope="col">نفرات خریدار پروژه</th>
                                    <th scope="col">تگ ها</th>
                                    <th scope="col">وضعیت نمایش</th>
                                    <th scope="col">عملیات</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($projects as $itr)
                                    <tr class="myTr tr_{{$itr->grade_id}}" id="tr_{{$itr->id}}">
                                        <td>{{$i}}</td>
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

                                        <td>{{$itr->capacity}}</td>
                                        <td>{{$itr->startReg}}</td>
                                        <td>{{$itr->endReg}}</td>
                                        <td><img width="100px" src="{{$itr->pic}}"></td>
                                        <td>{!! html_entity_decode($itr->description) !!}</td>
                                        <td>{{$itr->price}}</td>
                                        <td>{{$itr->date}}</td>
                                        <td>{{$itr->buyers}}</td>
                                        <td>
                                            @foreach($itr->tags as $tag)
                                                <button id="tag_{{$tag->id}}" onclick="removeTag('{{$tag->id}}')" style="margin: 4px" class="btn btn-info">
                                                    <span>{{$tag->name}}</span>
                                                    <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-remove"></span>
                                                </button>
                                            @endforeach
                                            <div style="margin-top: 10px">
                                                <button onclick="showTags('{{$itr->id}}')" class="btn btn-default">افزودن تگ جدید</button>
                                            </div>
                                        </td>
                                        <td>{{$itr->hide}}</td>
                                        <td>
                                            <button onclick="removeProject('{{$itr->id}}')" class="btn btn-danger" data-toggle="tooltip" title="حذف">
                                                <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-trash"></span>
                                            </button>

                                            <button onclick="editProject('{{$itr->id}}', '{{$itr->title}}', '{{$itr->price}}', '{{$itr->grade_id}}', '{{$itr->startReg}}', '{{$itr->endReg}}')" class="btn btn-primary" data-toggle="tooltip" title="ویرایش">
                                                <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-edit"></span>
                                            </button>

                                            <button class="btn btn-warning" onclick="toggleHide('{{$itr->id}}')"><span>تغییر وضعیت نمایش</span></button>

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

    </center>

    <div id="myAddModal" class="modal">

        <form action="{{route('addProject')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content" style="width: 75% !important;">

                <center>

                    <h5 style="padding-right: 5%;">نام پروژه</h5>
                    <input type="text" name="name" required maxlength="100">

                    <h5 style="padding-right: 5%;">هزینه پروژه</h5>
                    <input type="number" name="price" required min="0">

                    <h5 style="padding-right: 5%;">پایه تحصیلی</h5>
                    <select name="gradeId" required>
                        @foreach($grades as $grade)
                            <option value="{{$grade->id}}">{{$grade->name}}</option>
                        @endforeach
                    </select>

                    <h5 style="padding-right: 5%;">ظرفیت</h5>
                    <input type="number" name="capacity" required>
                    <p>اگر می خواهید ظرفیت این پروژه بی نهایت باشد، 1- را وارد نمایید.</p>


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

    <div id="myTagModal" class="modal">

        <div class="modal-content">

            <center>

                <h5 style="padding-right: 5%;">تگ ها</h5>
                <select id="tagId">
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                </select>
            </center>

            <div style="margin-top: 20px">
                <input onclick="addNewTag()" type="submit" value="افزودن تگ" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('myTagModal').style.display = 'none'">
            </div>
        </div>

    </div>

    <div id="myGradeModal" class="modal">

        <div class="modal-content">

            <center>

                <h5 style="padding-right: 5%;">پایه های تحصیلی</h5>
                <select id="gradeId">
                    @foreach($grades as $grade)
                        <option value="{{$grade->id}}">{{$grade->name}}</option>
                    @endforeach
                </select>
            </center>

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
                url: '{{route('deleteGradeProject')}}',
                data: {
                    id: id
                },
                success: function (res) {

                    if(res === "ok")
                        $("#grade_" + id).remove();

                }
            });
        }

        function removeTag(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteTagProject')}}',
                data: {
                    id: id
                },
                success: function (res) {

                    if(res === "ok")
                        $("#tag_" + id).remove();

                }
            });
        }

        function showTags(id) {
            itemId = id;
            document.getElementById('myTagModal').style.display = 'block';
        }

        function showGrades(id) {
            itemId = id;
            document.getElementById('myGradeModal').style.display = 'block';
        }

        function addNewTag() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('addTagProject')}}',
                data: {
                    id: itemId,
                    tagId: $("#tagId").val()
                },
                success: function (res) {

                    if(res === "ok")
                        document.location.reload();

                }
            });

        }

        function addNewGrade() {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('addGradeProject')}}',
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
                $(".myTr").addClass('hidden');
                $(".tr_" + id).removeClass('hidden');
            }

        }

        CKEDITOR.replace('editor1');

        function addProject() {
            document.getElementById('myAddModal').style.display = 'block';
        }

        function editProject(id, name, price, gradeId, startReg, endReg) {

            $("#projectId").val(id);
            $("#name").val(name);
            $("#price").val(price);
            $("#date_input2").val(startReg);
            $("#end_date_input2").val(endReg);
            // $("#description").html(desc);
            $("#gradeId").val(gradeId);

            document.getElementById('myEditModal').style.display = 'block';
        }

        function removeProject(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteProject')}}',
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
                url: '{{route('toggleHideProject')}}',
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
