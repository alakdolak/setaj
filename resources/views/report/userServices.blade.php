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

            <table style="margin-top: 20px">
                <tr>
                    <td>نام خدمت</td>
                    <td>وضعیت انجام</td>
                    <td>تعداد ستاره تعلق یافته</td>
                    <td>عملیات</td>
                </tr>

                @foreach($services as $service)
                    <tr>

                        <td>{{$service->title}}</td>

                        @if($service->status)
                            <td>انجام شده</td>
                        @else
                            <td>انجام نشده</td>
                        @endif

                        <td>{{$service->star}}</td>

                        <td>
                            @if(!$service->status)
                                <button onclick="confirmJob('{{$service->mainStars}}', '{{$uId}}', '{{$service->id}}')" class="btn btn-success">تاییده انجام کار</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </center>

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
                    if(res == "ok") {
                        alert("عملیات مورد نظر با موفقیت انجام پذیرفت.");
                        document.getElementById('myConfirmModal').style.display = 'none';
                    }
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

    </script>

@stop
