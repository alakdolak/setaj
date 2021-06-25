@extends("layouts.siteStructure2")

@section("header")
    @parent

    <link rel="stylesheet" href="{{URL::asset('css/usersActivities.css?v=1.3')}}">
    <link rel="stylesheet" href="{{URL::asset('css/abbreviations.css?v=1.3')}}">
    <link rel="stylesheet" href="{{URL::asset('css/profile.css?v=1.4')}}">
    <link rel="stylesheet" href="{{URL::asset('css/card.css?v=1.4')}}">

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
            <div class="col-sm-12 pr_scoreBodyBox">
                <div class="pr_scoreBody">
                    <div class="pr_arrows leftArrow"></div>
                    <div class="pr_scoreBox">
                        @foreach($tags as $tag)
                            <div class="pr_scoreRow">
                                <div class="pr_scoreText">{{$tag->name}}</div>
                                @if($tag->name == "تندرستی")
                                    <div class="pr_scoreIcone healthIcone"></div>
                                @elseif($tag->name == "تفکـــــر")
                                    <div class="pr_scoreIcone thinkIcone"></div>
                                @else
                                    <div class="pr_scoreIcone behaviorIcone"></div>
                                @endif
                                <div class="pr_scorePointBox">
                                    <div id="score_{{$tag->id}}" class="pr_scorePoint"></div>
                                </div>

                                <?php
                                    $class = "pr_scoreHealthyBox";

                                    if($tag->name == "تفکـــــر")
                                        $class = "pr_scoreThinkBox";
                                    elseif($tag->name == "کــــردار")
                                        $class = "pr_scoreBehaviorBox";
                                ?>

                                <div class="pr_scoreFieldBox {{$class}}">
                                    <div id="curr_score_{{$tag->id}}" class="pr_scoreNum"></div>
                                </div>
                            </div>
                        @endforeach

                        <div class="pr_scoreRow">
                            <div class="pr_scoreText">دست‌رنج</div>
                            <div class="pr_scoreIcone karestonIcone"></div>
                            <div class="pr_scorePointBox">
                                <div id="score_karestoon" class="pr_scorePoint"></div>
                            </div>
                            <div class="pr_scoreFieldBox pr_scoreKarestonBox">
                                <div id="curr_score_karestoon" class="pr_scoreNum"></div>
                            </div>
                        </div>

                    </div>
                    <div class="pr_arrows rightArrow"></div>
                </div>
            </div>
            <div class="mainDivContainerProfilePage row">
                <div class="col-sm-12" style="margin-top: 40px; padding: 0 !important;">
                    <div class="rightColBoxes col-md-4 col-xs-12">
                        <div class="honorsMainDiv col-md-12 col-xs-12">
                            <div class="honors_headerBox"></div>
                            <div class="honors_titleBox">جعبه‌ی افتخارات</div>
                            <div class="honors_picBox">
                                <div class="honors_pic"></div>
                                <div class="honors_picText"></div>
                            </div>
                            <div class="honors_footerBox"></div>
                        </div>
                        <div class="userProfileDetailsMainDiv rightColBox col-md-12 col-xs-12">
                            <div class="profileDescript col-md-12 col-xs-6" style="float: right;">
                                <div class="mainDivHeaderText">
                                    <h3>مشخصات کاربر</h3>
                                </div>
                                <div style="width: 100%; height: 100px;">

                                    <div class="personalFieldsBox col-xs-6">
                                        <div class="personalFields">نام</div>
                                        <div class="personalFields">نام خانوادگی</div>
                                        <div class="personalFields">کدملی</div>
                                        <div class="personalFields">نام کاربری</div>
                                    </div>

                                    <div class="col-xs-6">
                                        <div class="personalFields">{{\Illuminate\Support\Facades\Auth::user()->first_name}}</div>
                                        <div class="personalFields">{{\Illuminate\Support\Facades\Auth::user()->last_name}}</div>
                                        <div class="personalFields">{{\Illuminate\Support\Facades\Auth::user()->nid}}</div>
                                        <div class="personalFields">{{\Illuminate\Support\Facades\Auth::user()->username}}</div>
                                    </div>

                                </div>
                            </div>
                            <div class="profileDescript col-md-12 col-xs-6">
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
                                    <div style="display: flex;align-items: center;justify-content: space-evenly;line-height: 30px;">
                                        <div>بنابراین امتیاز فعلی شما:</div>
                                        <div style="display: flex; align-items: center">
                                            <img src="{{URL::asset('images/star.png')}}">
                                            <span class="pointNumber">{{$total}}</span>
                                        </div>
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
                                    <div class="shopOneBox col-lg-4 col-xs-6">
                                        <div onclick="document.location.href = '{{route('showProject', ['id' => $buy->id])}}'" class="sh_mainBox">
                                            <div style="background-image: url('{{$buy->pic}}')" class="sh_mainPic"></div>
                                            <div class="sh_descript">
                                                <div class="sh_descriptRow sh_title">{{$buy->title}}</div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons coinIcon"></div>
                                                    <div class="priceText">قیمت: {{$buy->price}} </div>
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons statusIcon"></div>
                                                    @if($buy->status)
                                                        <div class="priceText">وضعیت: انجام شد</div>
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
                                @foreach($myCitizens as $buy)
                                    <div class="shopOneBox col-lg-4 col-xs-6">
                                        <div onclick="document.location.href = '{{route('showCitizen', ['id' => $buy->id])}}'" class="sh_mainBox">
                                            <div style="background-image: url('{{$buy->pic}}')" class="sh_mainPic"></div>
                                            <div class="sh_descript">
                                                <div class="sh_descriptRow sh_title">{{$buy->title}}</div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons coinIcon"></div>
                                                    <div class="priceText">امتیاز: {{$buy->point}} </div>
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons statusIcon"></div>
                                                    <div class="priceText">وضعیت: انجام شد</div>
                                                </div>

                                                <div class="sh_descriptRow sh_priceBox">
                                                    <div class="priceIcons calenderIcon"></div>
                                                    <div class="priceText" style="font-size: 0.9em">تاریخ انجام پروژه: {{$buy->date}}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sh_ownerBox_finish">
                                            <div style="font-size: 0.9em">سفارش مدرسه سراج</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div id="advModal" class="modal fade" role="dialog">

                                <div id="confirmationModalDialogAlert" class="modal-content alertDiv hidden">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <div id="alertText"></div>
                                    </div>
                                </div>

                                <form id="advForm" method="post" action="{{route('addAdv')}}" enctype="multipart/form-data">

                                    <input type="hidden" name="id" id="advId">
                                    {{csrf_field()}}

                                    <div class="modal-dialog">
                                        <div class="modal-content" style="width: 100% !important;">

                                            <div class="modal-header">
                                                <button id="closeAdvBtn" type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">افزودن تبلیغ</h4>
                                            </div>

                                            <div class="modal-body">
                                                <p>فایل مورد نظر</p>
                                                <input type="file" name="file">
                                            </div>

                                            <div class="modal-footer">
                                                <button onclick="$('#advForm').submit()" type="button" class="btn btn-success">بله</button>
                                                <button id="closeBtn" type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                                            </div>

                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="photosAndVideosMainDiv display-none" id="myProducts">
                                @foreach($myProducts as $buy)
                                    <div onclick="document.location.href = '{{route("showProduct", ["id" => $buy->id])}}'" class="shopOneBox col-lg-4 col-xs-6">

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
                                    <div onclick="document.location.href = '{{route("showService", ["id" => $service->id])}}'" class="shopOneBox col-lg-4 col-xs-6">

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
                                                        <div class="priceText">وضعیت: انجام شد</div>
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
                                    <div onclick="document.location.href = '{{route("showProduct", ["id" => $buy->id])}}'" class="shopOneBox col-lg-4 col-xs-6">

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

{{--                                                <div class="sh_descriptRow sh_priceBox">--}}
{{--                                                    <div class="priceIcons statusIcon"></div>--}}
{{--                                                    @if($buy->status)--}}
{{--                                                        <div class="priceText">وضعیت: مرسوله به دست خریدار رسیده است.</div>--}}
{{--                                                    @else--}}
{{--                                                        <div class="priceText" style="font-size: 0.9em">وضعیت: مرسوله به دست خریدار نرسیده است.(کد پیگیری شما {{$buy->follow_code}} می باشد.</div>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
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

            var total = '{{\Illuminate\Support\Facades\Auth::user()->stars}}';

            $(document).ready(function () {

                $.ajax({
                    type: 'post',
                    url: '{{route('getMyCitizenPoints')}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function (res) {

                        res = JSON.parse(res);
                        if(res.status === "nok")
                            return;

                        $(".honors_pic").css("background-image", 'url("' + res.medal.pic + '")');
                        $(".honors_picText").append(res.medal.name);

                        for(var i = 0; i < res.points.length; i++) {
                            $("#score_" + res.points[i].id).animate({
                                width: res.points[i].point + "%"
                            });

                            $("#curr_score_" + res.points[i].id).append(res.points[i].point);
                        }

                        $("#score_karestoon").animate({
                            width: total + "%"
                        });

                        $("#curr_score_karestoon").append(total);
                    }
                });
            });

        </script>
    </div>

@stop
