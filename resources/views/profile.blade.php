@extends("layouts.siteStructure2")

@section("header")
    @parent

    <link rel="stylesheet" href="{{URL::asset('css/usersActivities.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/abbreviations.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/profile.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/card.css')}}">

    <style>
        .userActivitiesPhotos {
            padding: 20px 0 !important;
        }
        .sh_descript{
            font-size: 1em !important;
        }
        /*.shopOneBox:nth-child(1){*/
        /*    padding: 0 0 0 20px !important;*/
        /*}*/
        /*.shopOneBox:nth-child(2){*/
        /*    padding: 0 10px !important;*/
        /*}*/
        /*.shopOneBox:nth-child(3){*/
        /*    padding: 0 20px 0 0 !important;*/
        /*}*/
    </style>

@stop

@section("content")

    <div id="PAGE">

        <div class="userProfilePageCoverImg">
            <div class="userPageBodyTopBar">
                <div class="profileRightImg">
                    <div class="profileImg framePng">
                        @if(\Illuminate\Support\Facades\Auth::user()->pic != null && file_exists(__DIR__ . '/../../../public/userPics/' . \Illuminate\Support\Facades\Auth::user()->pic))
                            <div style="background-image: url('{{\Illuminate\Support\Facades\URL::asset("userPics/" . \Illuminate\Support\Facades\Auth::user()->pic)}}')" class="profileImg userPic"></div>
                        @else
                            <div style="background-image: url('{{\Illuminate\Support\Facades\URL::asset("userPics/defaultPic.png")}}')" class="profileImg userPic"></div>
                        @endif
                    </div>
                    <div class="profileImg lanternPng"></div>
                </div>
                <div class="profileLeftImg">
                    <div class="profileImg bagPng"></div>
                    <div class="profileImg binPng"></div>
                </div>
{{--                <div class="circleBase profilePicUserProfile"></div>--}}
{{--                <div class="userProfileInfo">--}}
{{--                    <div>{{\Illuminate\Support\Facades\Auth::user()->first_name . ' ' . \Illuminate\Support\Facades\Auth::user()->last_name}}</div>--}}

{{--                    <div>{{\Illuminate\Support\Facades\DB::select("select name from grade where id = " . \Illuminate\Support\Facades\Auth::user()->grade_id)[0]->name}}--}}
{{--                        --}}{{--                        <span>1396/10/04</span>--}}
{{--                    </div>--}}
{{--                    <div>دوره تحصیلی</div>--}}
{{--                </div>--}}
            </div>
        </div>
        </div>
        <div class="mainBodyUserProfile">
            <div class="mainDivContainerProfilePage row">
                <div class="col-sm-12" style="margin-top: 40px; padding: 0 !important;">
                    <div class="userProfileDetailsMainDiv rightColBoxes col-md-4 col-xs-12">
                        <div class="mainDivHeaderText">
                            <h3>مشخصات کاربر</h3>
                        </div>
                        <div style="width: 100%; height: 100px;">
                            <div class="personalFields col-xs-6">
                                نام
                            </div>
                            <div class="personalFieldsContents col-xs-6">{{\Illuminate\Support\Facades\Auth::user()->first_name}}</div>
                            <div class="personalFields col-xs-6">
                                نام خانوادگی
                            </div>
                            <div class="personalFieldsContents col-xs-6">{{\Illuminate\Support\Facades\Auth::user()->last_name}}</div>
                            <div class="personalFields col-xs-6">
                                کدملی
                            </div>
                            <div class="personalFieldsContents col-xs-6">{{\Illuminate\Support\Facades\Auth::user()->nid}}</div>
                            <div class="personalFields col-xs-6">
                                نام کاربری
                            </div>
                            <div class="personalFieldsContents col-xs-6">{{\Illuminate\Support\Facades\Auth::user()->username}}</div>
                        </div>
                        <div>
                            <div class="medalsMainBox">
                                <div>
                                    <img src="{{URL::asset('images/coin.png')}}">
                                    <span>{{\Illuminate\Support\Facades\Auth::user()->money}}</span>
                                </div>
                                <div>
                                    <img src="{{URL::asset('images/star.png')}}">
                                    <span>{{\Illuminate\Support\Facades\Auth::user()->stars}}</span>
                                </div>
                            </div>
                            <div class="pointDescript">
                                <?php
                                $per = \App\models\ConfigModel::first()->change_rate;
                                $total = floor((\Illuminate\Support\Facades\Auth::user()->money - 2000) / $per) + \Illuminate\Support\Facades\Auth::user()->stars;
                                ?>
                                <div style="line-height: 30px">هر {{$per}} سکه معادل یک ستاره می باشد</div>
                                <div style="display: flex;align-items: center;justify-content: space-around;line-height: 30px;">
                                    <div>بنابراین امتیاز فعلی شما برابر است با:</div>
                                    <div>
                                        <span>{{$total}}</span>
                                        <img src="{{URL::asset('images/star.png')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="userProfileActivitiesDetailsMainDiv col-md-8 col-xs-12">
                        <div style="padding: 0 !important; text-align: center;" class="userProfilePostsFiltrationContainer col-sm-12">
                            <div class="userProfilePostsFiltration">
                                <span onclick="showMyProjects(this)" class="onClick">پروژه‌های من</span>
                                <span onclick="showMyProducts(this)">محصولات من</span>
                                <span onclick="showMyServices(this)">همیاری‌های من</span>
                                <span onclick="showMyCarts(this)">خریدهای من</span>
                            </div>
                        </div>

                        <div class="userProfileActivitiesMainDiv userActivitiesPhotos col-sm-12">

                            <div class="photosAndVideosMainDiv" id="myProjects">
                                @foreach($myProjects as $buy)
                                    <div onclick="document.location.href = '{{route('showProject', ['id' => $buy->id])}}'" class="shopOneBox col-md-6 col-sm-4 col-xs-6">
                                        <div class="sh_mainBox">
                                            <div style="background-image: url('{{$buy->pic}}')" class="sh_mainPic"></div>
                                            <div class="sh_descript">
                                                <div class="sh_descriptRow sh_title">{{$buy->title}}</div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons coinIcon"></div>
                                                    <div class="priceText">قیمت: {{$buy->price}} سکه</div>
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons statusIcon"></div>
                                                    @if($buy->status)
                                                        <div class="priceText">وضعیت: تمام شده</div>
                                                    @else
                                                        <div class="priceText">وضعیت: در حال انجام</div>
                                                    @endif
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons calenderIcon"></div>
                                                    <div class="priceText" style="font-size: 0.9em">تاریخ پذیرش پروژه: {{$buy->date}}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sh_ownerBox_finish">
                                            <div style="font-size: 0.9em">سفارش مدرسه سراج</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="photosAndVideosMainDiv display-none" id="myProducts">
                                @foreach($myProducts as $buy)
                                    <div onclick="document.location.href = '{{route("showProduct", ["id" => $buy->id])}}'" class="shopOneBox col-md-6 col-sm-4 col-xs-6">

                                        <div class="sh_mainBox">
                                            <div style="background-image: url('{{$buy->pic}}')" class="sh_mainPic"></div>
                                            <div class="sh_descript">
                                                <div class="sh_descriptRow sh_title">{{$buy->name}}</div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons coinIcon"></div>
                                                    <div class="priceText">قیمت: {{$buy->price}} سکه</div>
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons starIcon"></div>
                                                    <div class="priceText">تعداد ستاره محصول: {{$buy->star}} </div>
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons calenderIcon"></div>
                                                    <div class="priceText" style="font-size: 0.9em">تاریخ ورود محصول به بازار: {{$buy->date}}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sh_ownerBox_finish">
                                            @if($buy->buyer == "هنوز به فروش نرسیده است.")
                                                <div style="font-size: 0.9em">{{$buy->buyer}}</div>
                                            @else
                                                <div style="font-size: 0.9em">خریدار: {{$buy->buyer}}</div>
                                            @endif
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            <div class="photosAndVideosMainDiv display-none" id="myServices">
                                @foreach($myServices as $service)
                                    <div onclick="document.location.href = '{{route("showService", ["id" => $service->id])}}'" class="shopOneBox col-md-6 col-sm-4 col-xs-6">

                                        <div class="sh_mainBox">
                                            <div style="background-image: url('{{$service->pic}}')" class="sh_mainPic"></div>
                                            <div class="sh_descript">
                                                <div class="sh_descriptRow sh_title">{{$service->title}}</div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons starIcon"></div>
                                                    <div class="priceText">حداکثر ستاره قابل دریافت: {{$service->star}} </div>
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons statusIcon"></div>
                                                    @if($service->status)
                                                        <div class="priceText">وضعیت: تمام شده</div>
                                                    @else
                                                        <div class="priceText">وضعیت: در حال انجام</div>
                                                    @endif
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons starIcon"></div>
                                                    @if($service->status)
                                                        <div class="priceText">تعداد ستاره اخذ شده: {{$service->myStar}} </div>
                                                    @else
                                                        <div class="priceText">تعداد ستاره اخذ شده: - </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="sh_ownerBox_finish">
                                                <div style="font-size: 0.9em">سفارش مدرسه سراج</div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            <div class="photosAndVideosMainDiv display-none" id="myCarts">
                                @foreach($myBuys as $buy)
                                    <div onclick="document.location.href = '{{route("showProduct", ["id" => $buy->id])}}'" class="shopOneBox col-md-6 col-sm-4 col-xs-6">

                                        <div class="sh_mainBox">
                                            <div style="background-image: url('{{$buy->pic}}')" class="sh_mainPic"></div>
                                            <div class="sh_descript">
                                                <div class="sh_descriptRow sh_title">{{$buy->name}}</div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons coinIcon"></div>
                                                    <div class="priceText">قیمت: {{$buy->price}} </div>
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons starIcon"></div>
                                                    <div class="priceText">ستاره دریافتی: {{$buy->star}} </div>
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons statusIcon"></div>
                                                    @if($buy->status)
                                                        <div class="priceText">وضعیت: مرسوله به دست خریدار رسیده است.</div>
                                                    @else
                                                        <div class="priceText" style="font-size: 0.9em">وضعیت: مرسوله به دست خریدار نرسیده است.(کد پیگیری شما {{$buy->follow_code}} می باشد.</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="sh_ownerBox_finish">
                                                <div style="font-size: 0.9em">فروشنده: {{$buy->seller}}</div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>

        <script>
            autosize(document.getElementsByClassName("inputBoxInputSearch"));
            autosize(document.getElementsByClassName("inputBoxInputAnswer"));
            autosize(document.getElementsByClassName("inputBoxInputComment"));

            function showMyProjects(element) {

                $('#myProjects').addClass('display-block').removeClass('display-none');

                $(element).addClass('onClick');
                $(element).nextAll().removeClass('onClick');
                $(element).prevAll().removeClass('onClick');

                $('#myProducts').addClass('display-none');
                $('#myServices').addClass('display-none');
                $('#myCarts').addClass('display-none');
            }

            function showMyProducts(element) {
                $('#myProjects').addClass('display-none');

                $('#myProducts').addClass('display-block').removeClass('display-none');
                $(element).addClass('onClick');
                $(element).nextAll().removeClass('onClick');
                $(element).prevAll().removeClass('onClick');

                $('#myServices').addClass('display-none');
                $('#myCarts').addClass('display-none');
            }

            function showMyServices(element) {

                $('#myProjects').addClass('display-none');
                $('#myProducts').addClass('display-none');

                $('#myServices').addClass('display-block').removeClass('display-none');

                $(element).addClass('onClick');
                $(element).nextAll().removeClass('onClick');
                $(element).prevAll().removeClass('onClick');
                $('#myCarts').addClass('display-none');
            }

            function showMyCarts(element) {
                $('#myProjects').addClass('display-none');
                $('#myProducts').addClass('display-none');
                $('#myServices').addClass('display-none');

                $('#myCarts').addClass('display-block').removeClass('display-none');

                $(element).addClass('onClick');
                $(element).nextAll().removeClass('onClick');
                $(element).prevAll().removeClass('onClick');
            }
        </script>
    </div>

@stop
