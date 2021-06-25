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
    </style>

    <style>
        th, td {
            text-align: right;
        }

        .bigTd {
            width: 320px !important;
        }
    </style>

    <script src="//cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>

@stop

@section('content')

    <div style="margin-top: 100px">

        <div style="margin: 20px">
            <button onclick="addTutorial()" class="btn btn-primary">افزودن آموزش جدید</button>
        </div>

        <div class="portlet box purple">

            <div class="portlet-title">
                <div class="caption" style="float: right">
                    <i style="float: right" class="fa fa-cogs"></i>
                    <span style="margin-right: 10px">آموزش های تعریف شده</span>
                </div>
            </div>
            <div class="portlet-body">

                @if(count($tutorials) == 0)
                    <h3>آموزشی تعریف نشده است</h3>
                @else

                    <div class="table-scrollable">

                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th scope="col">ردیف</th>
                                    <th scope="col">عنوان</th>
                                    <th scope="col">تصویر</th>
                                    <th scope="col">فایل</th>
                                    <th scope="col">عملیات</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($tutorials as $itr)

                                <tr id="tr_{{$itr->id}}">
                                    <td>{{$i}}</td>
                                    <td>{{$itr->title}}</td>
                                    @if($itr->pic == null)
                                        <td>تصویری بارگذاری نشده است.</td>
                                    @else
                                        <td><img src="{{$itr->pic}}" width="100px"></td>
                                    @endif

                                    <td><a download href="{{\Illuminate\Support\Facades\URL::asset('storage/tutorials/' . $itr->path)}}">دانلود فایل</a></td>

                                    <td>
                                        <button onclick="removeTutorial('{{$itr->id}}', '{{route('deleteTutorial', ['id' => $itr->id])}}')" class="btn btn-danger" data-toggle="tooltip" title="حذف">
                                            <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-trash"></span>
                                        </button>
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

        <form action="{{route('addTutorial')}}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="modal-content" style="width: 75% !important;">

                <center>

                    <h5 style="padding-right: 5%;">عنوان</h5>
                    <input type="text" name="name" required maxlength="100">

                    <h5>توضیح آموزش</h5>
                    <textarea id="editor1" cols="80" name="description" required></textarea>

                    <h5 style="padding-right: 5%;">فایل آموزشی</h5>
                    <input type="file" name="file">

                    <h5 style="padding-right: 5%;">تصویر آموزش</h5>
                    <input type="file" name="pic" accept="image/png, image/gif, image/jpeg image/jpg">

                </center>

                <div style="margin-top: 20px">
                    <input type="submit" value="افزودن" class="btn green"  style="margin-right: 5%; margin-bottom: 3%">
                    <input type="button" value="انصراف" class="btn green"  style="float: left; margin-bottom: 3%; margin-left: 5%;" onclick="document.getElementById('myAddModal').style.display = 'none'">
                </div>
            </div>
        </form>
    </div>

    <script>

        CKEDITOR.replace('editor1');

        var itemId;

        function addTutorial() {
            document.getElementById('myAddModal').style.display = 'block';
        }

        function removeTutorial(id, url) {

            $.ajax({
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: url,
                data: {
                    id: id
                },
                success: function (res) {

                    if(res === "ok")
                        $("#tr_" + id).remove();

                }
            });

        }

    </script>

@stop
