@extends("layouts.siteStructure2")

@section("header")
    @parent

    <link rel="stylesheet" href="{{URL::asset('css/usersActivities.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/abbreviations.css')}}">

@stop

@section("content")

    <div id="PAGE">

        <div class="userProfilePageCoverImg"></div>
        <div class="mainBodyUserProfile">
            <div class="mainDivContainerProfilePage row">
                <div class="userPageBodyTopBar">
                    <div class="circleBase profilePicUserProfile"></div>
                    <div class="userProfileInfo">
                        <div>{{\Illuminate\Support\Facades\Auth::user()->first_name . ' ' . \Illuminate\Support\Facades\Auth::user()->last_name}}</div>

                        <div>{{\Illuminate\Support\Facades\DB::select("select name from grade where id = " . \Illuminate\Support\Facades\Auth::user()->grade_id)[0]->name}}
                            {{--                        <span>1396/10/04</span>--}}
                        </div>
                        <div>دوره تحصیلی</div>
                    </div>

                </div>
                <div class="userProfileActivitiesDetailsMainDiv col-xs-8">
                    <div class="userProfilePostsFiltrationContainer">
                        <div class="userProfilePostsFiltration">
                            <span onclick="showMyProjects(this)" class="onClick">پروژه‌های من</span>
                            <span onclick="showMyProducts(this)">محصولات من</span>
                            <span onclick="showMyServices(this)">خدمات من</span>
                            <span onclick="showMyCarts(this)">خریدهای من</span>
                        </div>
                    </div>
                </div>

                <div class="userProfileDetailsMainDiv col-xs-4 float-right">
                    <div class="userProfileLevelMainDiv rightColBoxes">
                        <div class="mainDivHeaderText">
                            <h3>مشخصات کاربر</h3>
                        </div>
                        <div>
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

                    </div>
                    <div class="userProfileMedalsMainDiv rightColBoxes">
                        <div class="mainDivHeaderText">
                            <h3>اعتبارهای من</h3>
                        </div>
                        <div class="medalsMainBox">
                            <div>
                                <img src="{{URL::asset('images/coin.png')}}">
                                <span>{{\Illuminate\Support\Facades\Auth::user()->money}}</span>
                            </div>
                            <div>
                                <img src="{{URL::asset('images/star.png')}}">
                                <span>{{\Illuminate\Support\Facades\Auth::user()->stars}}</span>
                            </div>
                            <div>
                                <div>
                                    <img src="{{URL::asset('images/coin.png')}}">
                                    <img src="{{URL::asset('images/star.png')}}">
                                </div>
                                <span>{{ \App\models\ConfigModel::first()->rev_change_rate * \Illuminate\Support\Facades\Auth::user()->money + \Illuminate\Support\Facades\Auth::user()->stars}}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="userProfileActivitiesMainDiv userActivitiesPhotos col-sm-8 col-xs-12">
                    <div class="userProfilePhotosAndVideos">
                        <div class="photosAndVideosMainDiv" id="myProjects">
                            @foreach($myProjects as $buy)
                                <div onclick="document.location.href = '{{route("showProject", ["id" => $buy->id])}}'" class="sharedPhotosAndVideos" style="font-size: 11px">
                                    <img style="width: 50%; padding: 10px" src="{{$buy->pic}}">
                                    <p>{{$buy->title}}</p>
                                    <span>{{$buy->price}}سکه </span>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <span>تاریخ پذیرش پروژه {{$buy->date}}</span>

                                    @if($buy->status)
                                        <p>وضعیت: تمام شده</p>
                                    @else
                                        <p>وضعیت: در حال انجام</p>
                                    @endif

                                    <p>{{$buy->tagStr}}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="photosAndVideosMainDiv display-none" id="myProducts">
                            @foreach($myProducts as $buy)
                                <div onclick="document.location.href = '{{route("showProduct", ["id" => $buy->id])}}'" class="sharedPhotosAndVideos" style="font-size: 11px">
                                    <img style="width: 50%; padding: 10px" src="{{$buy->pic}}">
                                    <p>{{$buy->name}}</p>
                                    <span>{{$buy->price}}سکه </span>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <span>{{$buy->star}}ستاره </span>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <span>تاریخ ورود محصول به بازار {{$buy->date}}</span>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <span>خریدار: {{$buy->buyer}}</span>

                                    <p>{{$buy->tagStr}}</p>

                                </div>
                            @endforeach
                        </div>
                        <div class="photosAndVideosMainDiv display-none" id="myServices">
                            @foreach($myServices as $service)
                                <div onclick="document.location.href = '{{route('showService', ['id' => $service->id])}}'" class="sharedPhotosAndVideos" style="font-size: 11px">
                                    <img style="width: 50%; padding: 10px" src="{{$service->pic}}">
                                    <p>{{$service->title}}</p>
                                    <span>{{$service->star}}ستاره کل خدمت</span>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <span>وضعیت انجام کار: </span>
                                    @if($service->status)
                                        <span>انجام شده</span>
                                        <span>&nbsp;&nbsp;&nbsp;</span>
                                        <span>تعداد ستاره اخذ شده شما: </span>
                                        <span>{{$service->myStar}}</span>
                                    @else
                                        <span>انجام نشده</span>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                        <div class="photosAndVideosMainDiv display-none" id="myCarts">
                            @foreach($myBuys as $buy)
                                <div onclick="document.location.href = '{{route("showProduct", ["id" => $buy->id])}}'" class="sharedPhotosAndVideos" style="font-size: 11px">
                                    <img style="width: 50%; padding: 10px" src="{{$buy->pic}}">
                                    <p>{{$buy->name}}</p>
                                    <span>{{$buy->price}}سکه </span>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <span>{{$buy->star}}ستاره </span>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <span>تاریخ خرید {{$buy->date}}</span>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <span>فروشنده: {{$buy->seller}}</span>

                                    @if($buy->status)
                                        <p>مرسوله به دست خریدار رسیده است.</p>
                                    @else
                                        <p>
                                            مرسوله به دست خریدار نرسیده است.
                                        </p>
                                        <p>کد پیگیری محصول: {{$buy->follow_code}}</p>
                                    @endif

                                    <p>{{$buy->tagStr}}</p>

                                </div>
                            @endforeach
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
