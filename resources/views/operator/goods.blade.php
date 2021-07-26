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

    <script>
        var items = {!! json_encode($goods) !!} ;
    </script>

@stop

@section('content')

    <div style="margin-top: 100px">

        <div class="portlet box purple">

            <div class="portlet-title">
                <div class="caption" style="float: right">
                    <i style="float: right" class="fa fa-cogs"></i>
                    <span style="margin-right: 10px">محصولات تعریف شده</span>
                </div>
            </div>

            <div class="portlet-body">

                <center>
                    <button class="btn btn-primary" onclick="CKEDITOR.replace('editor1'); document.getElementById('myAddModal').style.display = 'block'">تعریف محصول جدید</button>
                </center>

                @if(count($goods) == 0)
                    <h3>محصولی تعریف نشده است</h3>
                @else

                    <center style="margin: 20px">
                        <span>پایه تحصیلی مورد نظر</span>
                        <select id="gradeFilter" onchange="doFilter()">
                            <option value="-1">همه</option>
                            @foreach($grades as $grade)
                                <option value="{{$grade->id}}">{{$grade->name}}</option>
                            @endforeach
                        </select>
                    </center>

                    <center>

                        <div class="col-xs-12" style="margin: 30px; direction: rtl">

                            <div style="display: inline-block; width: auto; margin-right: 10%; margin-left: 5%; float: right;">
                                <span style="float: right; margin-top: 6%;">    از تاریخ:   </span>
                                <label style="">
                                    <input type="button"
                                           style="border: none;  margin-top: 5%; width: 30px; height: 30px; background: url({{ URL::asset('images/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;"
                                           id="date_btn_Start">
                                </label>
                                <input type="text" style="max-width: 200px" class="form-detail"
                                       id="date_input_start" onchange="start(); doFilter();" readonly>

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
                                       id="date_input_end" onchange="end(); doFilter();" readonly>

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

                        <h3><span>تعداد کل</span><span>&nbsp;</span><span id="totalCount">{{count($goods)}}</span></h3>

                    </center>

                    <div class="table-scrollable">

                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th scope="col">ردیف</th>
                                    <th scope="col">نام</th>
                                    <th scope="col">کد کالا</th>
                                    <th scope="col">صاحب محصول</th>
                                    <th scope="col">پایه تحصیلی</th>
                                    <th scope="col">تاریخ شروع نمایش</th>
                                    <th scope="col">زمان شروع نمایش</th>
                                    <th scope="col">تاریخ شروع خرید</th>
                                    <th scope="col">زمان شروع خرید</th>
                                    <th scope="col">تصویر</th>
                                    <th scope="col" style="width:450px !important">توضیح</th>
                                    <th scope="col">قیمت</th>
                                    <th scope="col">تگ</th>
                                    <th scope="col">تاریخ تعریف محصول</th>
                                    <th scope="col">خریدار</th>
                                    <th scope="col">وضعیت نمایش</th>
                                    <th scope="col">عملیات</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($goods as $itr)
                                <tr class="tr grade_{{$itr->grade_id}}" id="myTr_{{$itr->id}}">
                                    <td>{{$i}}</td>
                                    <td>{{$itr->name}}</td>
                                    <td>{{$itr->code}}</td>
                                    <td>{{$itr->owner}}</td>
                                    <td>{{$itr->grade}}</td>
                                    <td>{{$itr->start_show}}</td>
                                    <td>{{$itr->start_time}}</td>
                                    <td>{{$itr->start_date_buy}}</td>
                                    <td>{{$itr->start_time_buy}}</td>
                                    <td><img width="100px" src="{{$itr->pic}}"></td>
                                    <td>{!! html_entity_decode($itr->description) !!}</td>
                                    <td>{{$itr->price}}</td>
                                    <td>{{$itr->tag}}</td>
                                    <td>{{$itr->date}}</td>
                                    <td>{{$itr->buyer}}</td>
                                    <td data-val="{{$itr->hide}}" id="visibility_{{$itr->id}}">{{$itr->hide}}</td>
                                    <td>
                                        <button onclick="removeProduct('{{$itr->id}}')" class="btn btn-danger" data-toggle="tooltip" title="حذف">
                                            <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-trash"></span>
                                        </button>

                                        <a target="_blank" href="{{route('editGood', ['id' => $itr->id])}}" class="btn btn-primary" data-toggle="tooltip" title="ویرایش">
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

    <div id="myAddModal" class="modal">

        <form action="{{route('addGood')}}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="modal-content" style="width: 75% !important;">

                <center>

                    <h5>نام کاربری صاحب محصول</h5>
                    <input type="text" name="username" required maxlength="10">

                    <h5>نام گروه</h5>
                    <input type="text" name="owner" required maxlength="100">

                    <h5>نام محصول</h5>
                    <input type="text" name="name" required maxlength="100">

                    <h5>کد محصول</h5>
                    <input type="text" name="code" required maxlength="100">

                    <h5>قیمت محصول</h5>
                    <input type="number" name="price" required min="0">

                    <h5>تگ(اختیاری)</h5>
                    <input type="text" name="tag" maxlength="200">

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
                        <input value="10:00" type="time" name="start_time">
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

                    <h5>تصاویر محصول(اختیاری)</h5>
                    <input type="file" name="file" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

                    <h5>تبلیغات محصول(اختیاری)</h5>
                    <input type="file" name="adv">

                </center>

                <div style="margin-top: 20px">
                    <input type="submit" value="افزودن" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                    <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('myAddModal').style.display = 'none'">
                </div>
            </div>
        </form>
    </div>

    <script>

        function doFilter() {

            var id = $("#gradeFilter").val();

            $(".tr").addClass("hidden").each(function () {

                if(id == -1 || $(this).hasClass("grade_" + id))
                    $(this).removeClass("hidden");

            });

            doChangeDateFilter();
        }

        function removeProduct(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('deleteGood')}}',
                data: {
                    id: id
                },
                success: function (res) {

                    if(res === "ok")
                        $("#myTr_" + id).remove();

                }
            });

        }

        function toggleHide(id) {

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: '{{route('toggleHideGood')}}',
                data: {
                    id: id
                },
                success: function (res) {

                    if(res === "ok") {
                        if($("#visibility_" + id).attr('data-val') === "آشکار")
                            $("#visibility_" + id).attr('data-val', "مخفی").empty().append("مخفی");
                        else
                            $("#visibility_" + id).attr('data-val', "آشکار").empty().append("آشکار");
                    }

                }
            });

        }

    </script>

    <script src="{{\Illuminate\Support\Facades\URL::asset("js/dateFilter.js")}}"></script>
@stop
