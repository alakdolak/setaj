
@extends('layouts.structure')

@section('header')
    @parent
@stop

@section('content')

    <div class="row" style="margin-top: 100px">

        @if($buyers == null)
            هنوز خریداری نشده است.
        @else

            @foreach($buyers as $buyer)
                <center class="col-md-3" style="padding: 4px; border: 1px dotted black; border-radius: 7px;">
                    <p>{{$buyer["name"]}}</p>
                    <p>
                        <span>وضعیت انجام: </span><span>&nbsp;</span><span>{{($buyer["status"]) ? "انجام شده" : "انجام نشده"}}</span>
                    </p>
                    @if($buyer["status"])
                        <p>
                            <span>تعداد ستاره های داده شده: </span><span>&nbsp;</span><span>{{$buyer["star"]}}</span>
                        </p>
                    @else
                        <button onclick="confirmJob('{{$star}}', '{{$buyer["id"]}}', '{{$id}}')" class="btn btn-success">تاییده انجام کار</button>
                    @endif
                </center>
            @endforeach
        @endif
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
