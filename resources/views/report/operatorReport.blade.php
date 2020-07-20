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

    <center class="col-sm-12" style="margin-top: 100px">

        <button onclick="addItem()" class="btn btn-success">افزودن معلم راهنما</button>

        <table class="col-xs-12" style="margin-top: 20px">
            <tr>
                <td>نام</td>
                <td>کد ملی</td>
                <td>وضعیت</td>
                <td>عملیات</td>
            </tr>

            @foreach($users as $user)
                <tr>

                    <td>{{$user->first_name . ' ' . $user->last_name}}</td>
                    <td>{{$user->nid}}</td>
                    <td>{{($user->status) ? "فعال" : "غیرفعال"}}</td>

                    <td>

                        @if($user->status)
                            <button id="toggle_{{$user->id}}" onclick="toggleStatus('{{$user->id}}')" class="btn btn-danger col-xs-6">غیرفعال کردن کاربر</button>
                        @else
                            <button id="toggle_{{$user->id}}" onclick="toggleStatus('{{$user->id}}')" class="btn btn-success col-xs-6">فعال کردن کاربر</button>
                        @endif

                    </td>
                </tr>
            @endforeach
        </table>

    </center>

    <div id="myAddModal" class="modal">
        <form action="{{route('addOperators')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <h2 style="padding-right: 5%;">فایل اکسل معلمین راهنما</h2>
                <input type="file" name="file" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                <div style="margin-top: 10px">
                    <input type="submit" value="تایید" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                    <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('myAddModal').style.display = 'none'">
                </div>
            </div>
        </form>
    </div>

    <script>

        function toggleStatus(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: '{{route('toggleStatusUser')}}',
                data: {
                    id: id
                },
                success: function (res) {
                    if(res === "ok")
                        document.location.reload();
                }
            });

        }

        function addItem(id, name) {
            document.getElementById('myAddModal').style.display = 'block';
            document.getElementById('categoryId').value = id;
            document.getElementById('oldName').value = name;
        }

    </script>

@stop
