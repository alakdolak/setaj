@extends('layouts.structure')

@section('header')
    @parent

    <style>
        th, td {
            text-align: center;
            padding: 7px;
            border: 1px solid #444;
        }

        .modal {
            z-index: 100000;
        }

    </style>

@stop

@section('content')

    <center class="col-sm-12" style="margin-top: 100px">

        <div>

            <h3>
                <a href="{{route('usersReportExcel', ['gradeId' => $gradeId])}}" download>دانلود فایل اکسل</a>
            </h3>

            <button onclick="addItem()" class="btn btn-success">افزودن کاربر</button>
            <button onclick="cancelAllSuperActivation()" class="btn btn-success">لغو کردن دسترسی فراتر همه دانش آموزان</button>
            <button onclick="onAllSuperActivation()" class="btn btn-success">روشن کردن دسترسی فراتر همه دانش آموزان</button>

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
                    <td>تعداد ستاره های کل</td>
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
                        <td>{{$user->total}}</td>
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
                            <button onclick="document.location.href = '{{route('userServices', ['uId' => $user->id])}}'" style="background-color: #8940b5; color: white;" class="btn col-xs-6">خدمات انجام شده</button>
                            <button onclick="document.location.href = '{{route('userProjects', ['uId' => $user->id])}}'" class="btn btn-warning col-xs-6">پروژه ها</button>


                            <button data-toggle="modal" data-target="#assignProjectModal" onclick="chooseSelectedUser('{{$user->id}}')" style="background-color: #0b4d3f; color: white;" class="btn col-xs-6">برداشتن پروژه برای کاربر</button>
                            <button data-toggle="modal" data-target="#assignServiceModal" onclick="chooseSelectedUser('{{$user->id}}')" style="background-color: #1d7d86; color: white;" class="btn col-xs-6">برداشتن خدمت برای کاربر</button>
                            <button data-toggle="modal" data-target="#assignProductModal" onclick="chooseSelectedUser('{{$user->id}}')" style="background-color: #862c24; color: white;" class="btn btn-warning col-xs-6">خرید محصول برای کاربر</button>

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

    </center>

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

    <div id="assignProjectModal" class="modal">

        <div class="modal-content">

            <center>

                <h5 style="padding-right: 5%;">پروژه مورد نظر</h5>
                <select id="projects">
                    @foreach($projects as $project)
                        <option value="{{$project->id}}">{{$project->title}}</option>
                    @endforeach
                </select>
            </center>

            <div style="margin-top: 20px">
                <input onclick="assignProject()" type="submit" value="تایید" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" data-dismiss="modal">
            </div>
        </div>

    </div>

    <div id="assignProductModal" class="modal">

        <div class="modal-content">

            <center>
                <h5 style="padding-right: 5%;">کد محصول مورد نظر</h5>
                <input type="text" id="productCode">
            </center>

            <div style="margin-top: 20px">
                <input onclick="assignProduct()" type="submit" value="تایید" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" data-dismiss="modal">
            </div>
        </div>

    </div>

    <div id="assignServiceModal" class="modal">

        <div class="modal-content">

            <center>

                <h5 style="padding-right: 5%;">خدمت مورد نظر</h5>
                <select id="services">
                    @foreach($services as $service)
                        <option value="{{$service->id}}">{{$service->title}}</option>
                    @endforeach
                </select>
            </center>

            <div style="margin-top: 20px">
                <input onclick="assignService()" type="submit" value="تایید" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" data-dismiss="modal">
            </div>
        </div>

    </div>

    <div id="assignServiceModal" class="modal">

        <div class="modal-content">

            <center>

                <h5 style="padding-right: 5%;">پروژه مورد نظر</h5>
                <select id="projects">
                    @foreach($projects as $project)
                        <option value="{{$project->id}}">{{$project->title}}</option>
                    @endforeach
                </select>
            </center>

            <div style="margin-top: 20px">
                <input onclick="assignProject()" type="submit" value="تایید" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" data-dismiss="modal">
            </div>
        </div>

    </div>


    <script>

        var userId;

        function assignProduct() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: '{{route('assignProductToUser')}}',
                data: {
                    productId: $("#productCode").val(),
                    userId: userId
                },
                success: function (res) {
                    if(res === "ok")
                        alert("عملیات مورد نظر باموفقیت انجام شد.");
                    else if(res === "nok1")
                        alert("این پروژه در مقطع تحصیلی دانش آموز مورد نظر نیست.");
                    else if(res === "nok2")
                        alert("این محصول توسط فرد دیگری خریداری شده است.");
                    else if(res === "nok3")
                        alert("عملیات مورد نظر مجاز نیست.");
                    else if(res === "nok4")
                        alert("سکه های فرد مورد نظر برای این کار کافی نیست.");
                }
            });

        }

        function assignService() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: '{{route('assignServiceToUser')}}',
                data: {
                    serviceId: $("#services").val(),
                    userId: userId
                },
                success: function (res) {
                    if(res === "ok")
                        alert("عملیات مورد نظر باموفقیت انجام شد.");
                    else if(res === "nok1")
                        alert("این پروژه در مقطع تحصیلی دانش آموز مورد نظر نیست.");
                    else if(res === "nok2")
                        alert("دانش آموز مورد نظر قبلا این پروژه را برداشته است.");
                    else if(res === "nok3")
                        alert("عملیات مورد نظر مجاز نیست.");
                    else if(res === "nok4")
                        alert("سکه های فرد مورد نظر برای این کار کافی نیست.");
                    else if(res === "nok5")
                        alert("ظرفیت پروژه مورد نظر به اتمام رسیده است.");
                }
            });

        }

        function assignProject() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: '{{route('assignProjectToUser')}}',
                data: {
                    projectId: $("#projects").val(),
                    userId: userId
                },
                success: function (res) {
                    if(res === "ok")
                        alert("عملیات مورد نظر باموفقیت انجام شد.");
                    else if(res === "nok1")
                        alert("این پروژه در مقطع تحصیلی دانش آموز مورد نظر نیست.");
                    else if(res === "nok2")
                        alert("دانش آموز مورد نظر قبلا این پروژه را برداشته است.");
                    else if(res === "nok3")
                        alert("عملیات مورد نظر مجاز نیست.");
                    else if(res === "nok4")
                        alert("سکه های فرد مورد نظر برای این کار کافی نیست.");
                    else if(res === "nok5")
                        alert("ظرفیت پروژه مورد نظر به اتمام رسیده است.");
                }
            });

        }

        function chooseSelectedUser(uId) {
            userId = uId;
        }

        function cancelAllSuperActivation() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: '{{route('cancelAllSuperActivation')}}',
                data: {
                    gradeId: '{{$gradeId}}'
                },
                success: function (res) {
                    if(res === "ok")
                        document.location.reload();
                }
            });

        }

        function onAllSuperActivation() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: '{{route('onAllSuperActivation')}}',
                data: {
                    gradeId: '{{$gradeId}}'
                },
                success: function (res) {
                    if(res === "ok")
                        document.location.reload();
                }
            });

        }

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
