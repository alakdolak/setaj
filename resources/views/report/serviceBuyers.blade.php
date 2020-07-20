
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

    <script>

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
