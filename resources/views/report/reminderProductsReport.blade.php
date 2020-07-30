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

            <p><span>تعداد کل: </span><span>&nbsp;</span><span id="totalCount">{{count($products)}}</span></p>

            <table style="margin-top: 20px">
                <tr>
                    <td>ردیف</td>
                    <td>کد محصول</td>
                    <td>فروشنده</td>
                    <td>محصول</td>
                    <td>قیمت</td>
                    <td>ستاره محصول</td>
                </tr>

                <?php $i = 0; ?>
                @foreach($products as $product)
                    <tr id="{{$i}}">
                        <td>{{($i + 1)}}</td>
                        <td>{{$product->id}}</td>
                        <td>{{$product->seller}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->star}}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </table>
        </center>

    </div>


@stop
