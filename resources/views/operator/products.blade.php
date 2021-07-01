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
            <button onclick="addProduct()" class="btn btn-primary">افزودن محصول جدید</button>
        </div>

        <div class="portlet box purple">

            <div class="portlet-title">
                <div class="caption" style="float: right">
                    <i style="float: right" class="fa fa-cogs"></i>
                    <span style="margin-right: 10px">محصولات تعریف شده</span>
                </div>
            </div>

            <div class="portlet-body">

                @if(isset($err) && $err == 2)
                    <h1 style="color: red">شما اجازه تعریف محصول را ندارید چون هنوز محتوایی برای پروژه غیرعینی ایشان بارگذاری نشده است.</h1>
                @endif

                @if(count($products) == 0)
                    <h3>محصولی تعریف نشده است</h3>
                @else

                    <center>
                        <span>پایه تحصیلی مورد نظر</span>
                        <select onchange="filter(this.value)">
                            <option value="-1">همه</option>
                            @foreach($grades as $grade)
                                <option value="{{$grade->id}}">{{$grade->name}}</option>
                            @endforeach
                        </select>
                    </center>

                    <div class="table-scrollable">

                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                            <tr>
                                <th scope="col">ردیف</th>
                                <th scope="col">نام</th>
                                <th scope="col">آی دی کالا</th>
                                <th scope="col">صاحب محصول</th>
                                <th scope="col">پایه تحصیلی</th>
                                <th scope="col">تاریخ شروع نمایش</th>
                                <th scope="col">زمان شروع نمایش</th>
                                <th scope="col">تاریخ شروع خرید</th>
                                <th scope="col">زمان شروع خرید</th>
                                <td scope="col">تصویر</td>
                                <th scope="col" style="width:450px !important">توضیح</th>
                                <th scope="col">قیمت</th>
                                <th scope="col">ستاره ها</th>
                                <th scope="col">تاریخ تعریف محصول</th>
                                <th scope="col">خریدار</th>
                                <th scope="col">وضعیت نمایش</th>
                                <th scope="col">عملیات</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($products as $itr)
                                <tr class="myTr tr_{{$itr->grade_id}}" id="tr_{{$itr->id}}">
                                    <td>{{$i}}</td>
                                    <td>{{$itr->name}}</td>
                                    <td>{{$itr->id}}</td>
                                    <td>{{$itr->owner}}</td>
                                    <td>{{$itr->grade}}</td>
                                    <td>{{$itr->start_show}}</td>
                                    <td>{{$itr->start_time}}</td>
                                    <td>{{$itr->start_date_buy}}</td>
                                    <td>{{$itr->start_time_buy}}</td>
                                    <td><img width="100px" src="{{$itr->pic}}"></td>
                                    <td>{!! html_entity_decode($itr->description) !!}</td>
                                    <td>{{$itr->price}}</td>
                                    <td>{{$itr->star}}</td>
                                    <td>{{$itr->date}}</td>
                                    <td>{{$itr->buyer}}</td>
                                    <td>{{$itr->hide}}</td>
                                    <td>
                                        <button onclick="removeProduct('{{$itr->id}}')" class="btn btn-danger" data-toggle="tooltip" title="حذف">
                                            <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-trash"></span>
                                        </button>

                                        <a target="_blank" href="{{route('editProduct', ['id' => $itr->id])}}" class="btn btn-primary" data-toggle="tooltip" title="ویرایش">
                                            <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-edit"></span>
                                        </a>

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

    </div>

    <div id="preModal" class="modal">

        <div class="modal-content" style="height: 300px">
            <div>

                <h5 style="padding-right: 5%;">کد ملی صاحب محصول</h5>
                <input type="text" id="username" name="username" required>

            </div>

            <div style="margin-top: 20px">
                <input onclick="getDetail()" type="submit" value="افزودن" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('preModal').style.display = 'none'">
            </div>
        </div>

    </div>

    <div id="myAddModal" class="modal">

        <form action="{{route('addProduct')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content" style="width: 75% !important;">

                <center>

                    <input type="hidden" name="username" id="hiddenUsername">

                    <h5 style="padding-right: 5%;">نام محصول</h5>
                    <input type="text" name="name" required maxlength="100">

                    <h5 style="padding-right: 5%;">قیمت محصول</h5>
                    <input type="number" name="price" required min="0">

                    <h5 style="padding-right: 5%;">ستاره های محصول</h5>
                    <input type="number" name="star" required min="0">

                    <h5 style="padding-right: 5%;">پروژه مورد نظر</h5>
                    <select name="project" id="projects"></select>

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
                        <input type="time" name="start_time_buy">
                    </div>

                    <h5>توضیح محصول</h5>
                    <textarea id="editor1" cols="80" name="description" required></textarea>

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

        function addProduct() {
            document.getElementById('preModal').style.display = 'block';
        }

        function getDetail() {

            var username = $("#username").val();

            if(username.length === 0) {
                alert("لطفا کد ملی دانش آموز مورد نظر خود را وارد نمایید.");
                return;
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('getOpenProjects')}}',
                data: {
                    username: username
                },
                success: function (res) {

                    res = JSON.parse(res);

                    if(res.length === 0) {
                        alert("دانش آموز مورد نظر پروژه بازی ندارد.");
                        return;
                    }

                    var newElem = "";

                    for(var i = 0; i < res.length; i++) {
                        newElem += "<option value='" + res[i].id + "'>" + res[i].title + "</option>";
                    }

                    $("#hiddenUsername").val(username);
                    $("#projects").empty().append(newElem);

                    document.getElementById('preModal').style.display = 'none';
                    document.getElementById('myAddModal').style.display = 'block';
                }
            });
        }

        function removeProduct(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteProduct')}}',
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
                url: '{{route('toggleHideProduct')}}',
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
