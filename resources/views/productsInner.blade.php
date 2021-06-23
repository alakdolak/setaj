@extends("layouts.siteStructure3")


@section("header")
    @parent

@stop

@section("banner")

    <div class="banner">
        <div class="bannerGrayBox"></div>
        <div class="bannerBorderBox bannerLightBlueBox"></div>
        <div class="bannerMainBox productsBanner"></div>
    </div>

@stop

@section("content")

    <div class="shopBox row">

            <div class="weekContainer shopEachRow col-xs-12">

                <div class="shopEachRow col-xs-12">

                    @if($canBuy)
                        <center>
                            <button onclick="buy()" class="btn btn-primary">خرید</button>
                        </center>
                    @endif

                    @foreach($products as $product)

                        <div onclick="document.location.href = '{{route('showProduct', ['id' => $product->id])}}'" class="myItem shopOneBox col-md-3 col-sm-4 col-xs-6">

                            <div class="sh_mainBox">

                                @if($product->adv_status)
                                    <div class="sh_advPic"></div>
                                @endif

                                <div style="background-image: url('{{$product->pic}}')" class="sh_mainPic"></div>
                                <div class="sh_descript">
                                    <div class="sh_descriptRow sh_title">{{$product->name}}</div>
                                    <div class="sh_descriptRow sh_priceBox">
                                        <div class="priceIcons coinIcon"></div>
                                        <div class="priceText">قیمت: {{$product->price}} سکه</div>
                                    </div>
                                    <div class="sh_descriptRow sh_priceBox">
                                        <div class="priceIcons starIcon"></div>
                                        <div class="priceText">ستاره ی دریافتی: {{$product->star}}</div>
                                    </div>

                                </div>

                            </div>

                            <div class="sh_ownerBox">
                                <div>تولیدکننده: {{$product->owner}}</div>
                            </div>

                        </div>

                    @endforeach

                </div>
            </div>
    </div>

    <script>

        function buy() {

            $.ajax({
                type: 'post',
                url: '{{route('buyUnPhysicalProduct')}}',
                data: {
                    projectId: '{{$projectId}}',
                    gradeId: '{{$grade}}'
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function (res) {
                    alert(res);
                }
            });

        }

    </script>

@stop
