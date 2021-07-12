@extends('layouts.structure')

@section('header')
    @parent

    <link href="{{\Illuminate\Support\Facades\URL::asset('global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{\Illuminate\Support\Facades\URL::asset('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css')}}" rel="stylesheet" type="text/css" />

    <style>
        th, td {
            text-align: center;
            padding: 7px;
            border: 1px solid #444;
        }
        .modal-backdrop {
            display: none !important;
        }
    </style>

    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/calendar-setup.js") }}></script>
    <script src= {{URL::asset("js/calendar-fa.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>
    <link rel="stylesheet" href="{{URL::asset('css/standalone.css')}}">
    <link rel="stylesheet" href= {{URL::asset("css/calendar-green.css") }}>

    <script>
        var items = {!! json_encode($items) !!} ;
    </script>

@stop

@section('content')

    <div class="col-sm-12" style="margin-top: 100px">

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

            <h3><span>تعداد کل</span><span>&nbsp;</span><span id="totalCount">{{count($items)}}</span></h3>

            <div class="row">
                <p>فیلتر براساس</p>

                <center class="col-xs-12 col-md-12">
                    <label for="projFilter">پروژه</label>
                    <select onchange="doFilter()" id="projFilter">
                        <option value="-1">همه</option>
                        @foreach($all as $itr)
                            <option value="{{$itr['id']}}">{{$itr['title']}}</option>
                        @endforeach
                    </select>
                </center>
            </div>

            <div class="portlet-body" style="margin-top: 30px">
                <table  style="margin-top: 20px" class="table table-striped table-bordered table-hover table-header-fixed" id="sample_1">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام کاربر</th>
                            <th>نام پروژه</th>
                            <th>دسته پروژه</th>
                            <th>امتیاز کسب شده</th>
                            <th>کل امتیاز موجود</th>
                            <th>زمان انجام</th>
                            <th>توضیحات</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($items as $item)
                            <tr id="myTr_{{$item->id}}"  class="tr proj_{{$item->cId}} grade_{{$item->gradeId}}">
                                <td>{{$i}}</td>
                                <td>{{$item->owner}}</td>
                                <td>{{$item->title}}</td>
                                <td>{{$item->tag}}</td>
                                <td id="point_{{$item->id}}">{{$item->point}}</td>
                                <td>{{$item->totalPoint}}</td>
                                <td>{{$item->date}}</td>
                                <td>{{$item->description}}</td>
                                <td><button class="btn btn-primary" data-toggle="modal" data-target="#changeModal" onclick="changePoint('{{$item->point}}', '{{$item->totalPoint}}', '{{$item->id}}')">تغییر امتیاز داده شده</button></td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </center>
    </div>


    <div id="changeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 100% !important;">
                <div class="modal-header">
                    <button id="closeConfirmationModalBtn" type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">تغییر امتیاز کاربر</h4>
                </div>
                <div class="modal-body">
                    <p>امتیاز مد نظر خود را وارد کنید</p>
                    <input type="number" id="newPoint">
                    <p>
                        <span>مقدار امتیاز گرفته شده تاکنون توسط کاربر </span>
                        <span id="currPoint"></span>
                        <span> می باشد و سقف امتیاز ممکن </span>
                        <span id="totalPoint"></span>
                        <span> است.</span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button onclick="doChangePoint()" type="button" class="btn btn-success">بله</button>
                    <button id="closeBtn" type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                </div>
            </div>

            <div id="confirmationModalDialogAlert" class="modal-content alertDiv hidden">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div id="alertText"></div>
                </div>
            </div>
        </div>
    </div>

    <script>

        var selectedId = -1;
        var selectedTotalPoint = -1;

        $(document).ready(function () {
            $("#sample_1_length").addClass('hidden');
            $("select[name='sample_1_length']").val(-1).change().addClass('hidden');
        });

        function changePoint(currPoint, totalPoint, id) {
            selectedId = id;
            selectedTotalPoint = totalPoint;
            $("#currPoint").empty().append(currPoint);
            $("#totalPoint").empty().append(totalPoint);
            $("#newPoint").val(0).attr("max", totalPoint);
        }

        function doChangePoint() {

            var newPoint = $("#newPoint").val();
            if(newPoint > selectedTotalPoint) {
                alert("مقدار وارد شده بیش از حد ماکزیمم است.");
                return;
            }

            $.ajax({
                type: 'post',
                url: '{{route('changePoint')}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: {
                    'point': newPoint,
                    'id': selectedId
                },
                success: function (res) {
                    if(res === "ok") {
                        $("#point_" + selectedId).empty().append(newPoint);
                        $("#closeBtn").click();
                    }
                    else
                        alert("خطایی در انجام عملیات مورد نظر رخ داده است.");
                }
            });

        }

        function doFilter() {

            var proj = $("#projFilter").val();

            $(".tr").addClass("hidden").each(function () {

                if(proj == -1 || $(this).hasClass("proj_" + proj))
                    $(this).removeClass("hidden");
            });

            doChangeDateFilter();
        }

    </script>

    <script src="{{\Illuminate\Support\Facades\URL::asset("js/dateFilter.js")}}"></script>

@stop
