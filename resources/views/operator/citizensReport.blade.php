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

@stop

@section('content')

    <div class="col-sm-12" style="margin-top: 100px">

        <center>

            <h3><span>تعداد کل</span><span>&nbsp;</span><span>{{count($items)}}</span></h3>

            <div class="row">
                <p>فیلتر براساس</p>
                <center class="col-xs-12 col-md-6">
                    <label for="gradeFilter">پایه تحصیلی</label>
                    <select onchange="doFilter()" id="gradeFilter">
                        <option value="-1">همه</option>
                        @foreach($grades as $grade)
                            <option value="{{$grade->id}}">{{$grade->name}}</option>
                        @endforeach
                    </select>
                </center>

                <center class="col-xs-12 col-md-6">
                    <label for="projFilter">پروژه</label>
                    <select onchange="doFilter()" id="projFilter">
                        <option value="-1">همه</option>
                        @foreach($all as $itr)
                            <option value="{{$itr->id}}">{{$itr->title}}</option>
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
                            <th>پایه تحصیلی</th>
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
                            <tr class="tr proj_{{$item->cId}} grade_{{$item->gradeId}}">
                                <td>{{$i}}</td>
                                <td>{{$item->owner}}</td>
                                <td>{{$item->grade}}</td>
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

            var grade = $("#gradeFilter").val();
            var proj = $("#projFilter").val();

            $(".tr").addClass("hidden").each(function () {

                if(
                    (grade == -1 || $(this).hasClass("grade_" + grade)) &&
                    (proj == -1 || $(this).hasClass("proj_" + proj))
                )
                    $(this).removeClass("hidden");

            });

        }

    </script>

@stop
