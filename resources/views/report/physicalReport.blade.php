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

@stop

@section('content')

    <div class="col-sm-12" style="margin-top: 100px">

        <center>

            <div style="margin: 10px">
                <span>تا چند رو قبل رو می خوای؟</span>
                <input type="number" min="0" id="pre">
            </div>
            <div style="margin: 10px">
                <button onclick="getData()" class="btn btn-primary">تایید و نمایش نتایج</button>
            </div>

            <table style="margin-top: 40px">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام کاربر</th>
                        <th>تعداد پروژه عینی</th>
                        <th>تعداد پروژه عیرعینی</th>
                    </tr>
                </thead>

                <tbody id="tbody"></tbody>

            </table>
        </center>

    </div>

    <script>

        function getData() {

            var pre = $("#pre").val();
            if(pre === "") {
                alert("لطفا فیلد لازم را پر نمایید.");
                return;
            }

            $.ajax({
                type: 'post',
                url: '{{route('physicalReportAPI')}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: {
                    pre: pre,
                    gradeId: '{{$gradeId}}'
                },
                success: function (res) {

                    res = JSON.parse(res);

                    if(res.status === "ok") {

                        var result = res.result;
                        var elem = "";
                        for(var i = 0; i < result.length; i++) {
                            elem += "<tr>";
                            elem += "<td>" + (i + 1) + "</td>";
                            elem += "<td>" + result[i].name + "</td>";
                            elem += "<td>" + result[i].physical + "</td>";
                            elem += "<td>" + result[i].unphysical + "</td>";
                            elem += "</tr>";
                        }

                        $("#tbody").empty().append(elem);
                    }
                    else
                        alert("عملیات موردنظر با خطا مواجه شده است.");
                }
            });

        }

    </script>

@stop
