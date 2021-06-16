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

    </style>

@stop

@section('content')
    <div class="row">
        <div class="col-md-12">


            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-header-fixed" id="sample_1">
                    <thead>
                        <tr class="">
                            <th> نام دانش آموز </th>
                            @foreach($tags as $tag)
                                <th>{{$tag->name}}</th>
                            @endforeach
                            <th> جمع کل </th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($points as $point)
                            <tr>
                                <td>{{$point["name"]}}</td>
                                <?php $sum = 0; ?>
                                @foreach($point["points"] as $p)
                                    <td>{{$p}}</td>
                                    <?php $sum += $p; ?>
                                @endforeach
                                <td>{{$sum}}</td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </div>

@stop
