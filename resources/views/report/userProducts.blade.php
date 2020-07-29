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
                    <td>نام پروژه</td>
                    <td>نام فروشنده</td>
                    <td>هزینه</td>
                    <td>تاریخ</td>
                </tr>

                @foreach($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td>{{$product->seller}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->date . '    ساعت    ' . $product->time}}</td>
                    </tr>
                @endforeach
            </table>
        </center>

    </div>

@stop
