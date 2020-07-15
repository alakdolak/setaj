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

    <div class="col-md-12" style="margin-top: 100px">

        <center>

            <button onclick="addItem()" class="btn btn-success">افزودن کاربر</button>

            <table style="margin-top: 20px">
                <tr>
                    <td>نام</td>
                    <td>کد ملی</td>
                    <td>وضعیت</td>
                    <td>وضعیت دسترسی فراتر</td>
                    <td>تعداد خرید</td>
                    <td>ارزش کل خریدها(سکه)</td>
                    <td>تعداد ستاره ها</td>
                    <td>تعداد سکه ها</td>
                    <td>عملیات</td>
                </tr>

                @foreach($users as $user)
                    <tr>

                        <td>{{$user->first_name . ' ' . $user->last_name}}</td>
                        <td>{{$user->nid}}</td>
                        <td>{{($user->status) ? "فعال" : "غیرفعال"}}</td>
                        <td>{{($user->super_active) ? "فعال" : "غیرفعال"}}</td>
                        <td>{{$user->buys}}</td>
                        <td>{{$user->sum}}</td>
                        <td>{{$user->stars}}</td>
                        <td>{{$user->money}}</td>
                        <td>
                            @if($user->status)
                                <button id="toggle_{{$user->id}}" onclick="toggleStatus('{{$user->id}}')" class="btn btn-danger col-xs-6">غیرفعال کردن کاربر</button>
                            @else
                                <button id="toggle_{{$user->id}}" onclick="toggleStatus('{{$user->id}}')" class="btn btn-success col-xs-6">فعال کردن کاربر</button>
                            @endif


                            @if($user->super_active)
                                <button id="toggle_super_{{$user->id}}" onclick="toggleSuperStatus('{{$user->id}}')" class="btn btn-danger col-xs-6">غیرفعال کردن دسترسی فراتر کاربر</button>
                            @else
                                <button id="toggle_super_{{$user->id}}" onclick="toggleSuperStatus('{{$user->id}}')" class="btn btn-success col-xs-6">فعال کردن دسترسی فراتر کاربر</button>
                            @endif

                            <button onclick="editMoney('{{$user->id}}', '{{$user->money}}', '{{$user->stars}}')" class="btn btn-info col-xs-6">ویرایش سکه/ستاره کاربر</button>
{{--                            <button onclick="document.location.href = '{{route('userBookmarks', ['uId' => $user->id])}}'" class="btn btn-info col-xs-6">اقلام مورد علاقه کاربر</button>--}}

                            <button onclick="document.location.href = '{{route('userBuys', ['uId' => $user->id])}}'" class="btn btn-basic col-xs-6">اقلام خریداری شده کاربر</button>
                            <button onclick="document.location.href = '{{route('userServices', ['uId' => $user->id])}}'" class="btn btn-default col-xs-6">خدمات انجام شده</button>
                            <button onclick="document.location.href = '{{route('userProjects', ['uId' => $user->id])}}'" class="btn btn-warning col-xs-6">پروژه ها</button>

                        </td>
                    </tr>
                @endforeach
            </table>
        </center>

    </div>

    <div id="myAddModal" class="modal">
        <form action="{{route('addUsers', ['gradeId' => $gradeId])}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <h2 style="padding-right: 5%;">فایل اکسل دانش آموزان</h2>
                <input type="file" name="file" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                <div style="margin-top: 10px">
                    <input type="submit" value="تایید" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                    <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('myAddModal').style.display = 'none'">
                </div>
            </div>
        </form>
    </div>

    <div id="myMoneyModal" class="modal">
        <form action="{{route('editMoney')}}" method="post">
            {{ csrf_field() }}
            <div class="modal-content">

                <input type="hidden" name="id" id="id">

                <h4 style="padding-right: 5%;">تعداد سکه ها</h4>
                <input type="number" id="coin" name="coin" required>

                <h4 style="padding-right: 5%;">تعداد ستاره ها</h4>
                <input type="number" id="star" name="star" required>

                <div style="margin-top: 10px">
                    <input type="submit" value="تایید" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                    <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('myMoneyModal').style.display = 'none'">
                </div>
            </div>
        </form>
    </div>

    <script>

        function toggleSuperStatus(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: '{{route('toggleSuperStatusUser')}}',
                data: {
                    id: id
                },
                success: function (res) {
                    if(res === "ok")
                        document.location.reload();
                }
            });

        }

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

        function editMoney(id, coin, star) {
            document.getElementById('myMoneyModal').style.display = 'block';
            document.getElementById('id').value = id;
            document.getElementById('coin').value = coin;
            document.getElementById('star').value = star;
        }
    </script>

@stop
