<?php

namespace App\Http\Controllers;


use App\models\Activation;
use App\models\Bookmark;
use App\models\Chat;
use App\models\Citizen;
use App\models\CitizenAttach;
use App\models\CitizenBuyers;
use App\models\CitizenGrade;
use App\models\CitizenPic;
use App\models\CommonQuestion;
use App\models\ConfigModel;
use App\models\FAQCategory;
use App\models\Good;
use App\models\GoodPic;
use App\models\Grade;
use App\models\Msg;
use App\models\PayPingTransaction;
use App\models\Product;
use App\models\ProductAttach;
use App\models\ProductPic;
use App\models\ProductTrailer;
use App\models\Project;
use App\models\ProjectAttach;
use App\models\ProjectBuyers;
use App\models\ProjectGrade;
use App\models\ProjectPic;
use App\models\Service;
use App\models\ServiceAttach;
use App\models\ServiceBuyer;
use App\models\ServiceGrade;
use App\models\ServicePic;
use App\models\Tag;
use App\models\Transaction;
use App\models\Tutorial;
use App\models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use ZipArchive;

class HomeController extends Controller {

    public function home() {

//        $x = -1;
//
//        if(!siteTime()) {
//            $x = getReminderToNextTime();
//        }

        if(Auth::check())
            return Redirect::route('choosePlan');

        return view('home', ["reminder" => -1]);
    }

    public function choosePlan() {
        return view('choosePlan');
    }

    public function profile() {

        if(Auth::user()->level == getValueInfo('operatorLevel'))
            return view('adminProfile');

        $uId = Auth::user()->id;

        $myBuys = DB::select("select p.id, p.extra, p.grade_id, p.physical, ".
            "t.status, p.name, concat(u.first_name, ' ', u.last_name) as seller, " .
            "pb.project_id, p.price, p.star, t.follow_code, t.created_at from transactions t, product p, project_buyers pb, users u where " .
            " u.id = pb.user_id and pb.project_id = p.project_id and p.user_id = u.id and " .
            " t.product_id = p.id and t.user_id = " . $uId . " order by p.id desc");

        foreach ($myBuys as $myBuy) {

            $myBuy->date = getCustomDate($myBuy->created_at);

            $tags = DB::select("select t.name, t.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $myBuy->project_id);

            $str = "";
            $first = true;

            foreach ($tags as $tag) {
                if($first) {
                    $str .= "#" . $tag->name;
                    $first = false;
                }
                else {
                    $str .= " #" . $tag->name;
                }
            }

            $myBuy->tagStr = $str;

            $tmpPic = ProductPic::whereProductId($myBuy->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $myBuy->pic = URL::asset('productPic/defaultPic.png');
            else
                $myBuy->pic = URL::asset('productPic/' . $tmpPic->name);

        }


        $myProducts = DB::select("select * from product where user_id = " . $uId . " order by id desc");

        foreach ($myProducts as $myBuy) {

            $myBuy->date = getCustomDate($myBuy->created_at);

            $tags = DB::select("select t.name, t.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $myBuy->project_id);

            $str = "";
            $first = true;

            foreach ($tags as $tag) {
                if($first) {
                    $str .= "#" . $tag->name;
                    $first = false;
                }
                else {
                    $str .= " #" . $tag->name;
                }
            }

            $myBuy->tagStr = $str;

            $tmpPic = ProductPic::whereProductId($myBuy->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $myBuy->pic = URL::asset('productPic/defaultPic.png');
            else
                $myBuy->pic = URL::asset('productPic/' . $tmpPic->name);

            $t = Transaction::whereProductId($myBuy->id)->first();
            if($t != null) {
                $u = User::whereId($t->user_id);
                $myBuy->buyer = $u->first_name . ' ' . $u->last_name;
            }
            else {
                $myBuy->buyer = "هنوز به فروش نرسیده است.";
            }

        }


        $myProjects = DB::select("select p.*, pb.status from project p, project_buyers pb where " .
            "p.id = pb.project_id and pb.user_id = " . $uId . " order by id desc");

        foreach ($myProjects as $myProject) {

            $myProject->date = getCustomDate($myProject->created_at);

            $tags = DB::select("select t.name, t.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $myProject->id);

            $str = "";
            $first = true;

            foreach ($tags as $tag) {
                if($first) {
                    $str .= "#" . $tag->name;
                    $first = false;
                }
                else {
                    $str .= " #" . $tag->name;
                }
            }

            $myProject->tagStr = $str;

            $tmpPic = ProjectPic::whereProjectId($myProject->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/projectPic/' . $tmpPic->name))
                $myProject->pic = URL::asset('projectPic/defaultPic.png');
            else
                $myProject->pic = URL::asset('projectPic/' . $tmpPic->name);

            if($myProject->price == 0)
                $myProject->price = "رایگان";
            else
                $myProject->price .= " سکه ";
        }


        $myCitizens = DB::select("select p.* from citizen p, citizen_buyers pb where " .
            "p.id = pb.project_id and pb.user_id = " . $uId . " order by id desc");

        foreach ($myCitizens as $myProject) {

            $myProject->date = getCustomDate($myProject->created_at);

            $tags = DB::select("select t.name, t.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $myProject->id);

            $str = "";
            $first = true;

            foreach ($tags as $tag) {
                if($first) {
                    $str .= "#" . $tag->name;
                    $first = false;
                }
                else {
                    $str .= " #" . $tag->name;
                }
            }

            $myProject->tagStr = $str;

            $tmpPic = CitizenPic::whereProjectId($myProject->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/citizenPic/' . $tmpPic->name))
                $myProject->pic = URL::asset('citizenPic/defaultPic.png');
            else
                $myProject->pic = URL::asset('citizenPic/' . $tmpPic->name);
        }


        $myServices = DB::select("select s.id, sb.status, sb.star myStar, s.star, s.title from service_buyer sb, service s where " .
            " sb.service_id = s.id and sb.user_id = " . Auth::user()->id . " order by id desc");

        foreach ($myServices as $myService) {

            $tmpPic = ServicePic::whereServiceId($myService->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/servicePic/' . $tmpPic->name))
                $myService->pic = URL::asset('servicePic/defaultPic.png');
            else
                $myService->pic = URL::asset('servicePic/' . $tmpPic->name);

        }

        return view('profile', ['myBuys' => $myBuys, "myServices" => $myServices,
            "myCitizens" => $myCitizens,
            "myProducts" => $myProducts, 'myProjects' => $myProjects, 'tags' => Tag::whereType("CITIZEN")->get()]);
    }

    public function showTutorial($id) {

        $tutorial = Tutorial::whereId($id);
        if($tutorial == null)
            return Redirect::route('faq');

        $tutorial->path = URL::asset("storage/tutorials/" . $tutorial->path);

        if($tutorial->pic != null &&
            file_exists(__DIR__ . '/../../../public/storage/tutorials/' . $tutorial->pic))
            $tutorial->pic = URL::asset("storage/tutorials/" . $tutorial->pic);
        else
            $tutorial->pic = URL::asset("images/defaultTutorial.jpg");

        return view('showTutorial', ['tutorial' => $tutorial]);
    }

    public function faq() {

        $categories = FAQCategory::all();

        foreach ($categories as $category)
            $category->items = CommonQuestion::whereCategoryId($category->id)->get();

        $tutorials = Tutorial::orderBy('id', 'desc')->get();
        foreach ($tutorials as $tutorial) {

            if($tutorial->pic != null &&
                file_exists(__DIR__ . '/../../../public/storage/tutorials/' . $tutorial->pic))
                $tutorial->pic = URL::asset("storage/tutorials/" . $tutorial->pic);
            else
                $tutorial->pic = URL::asset("images/defaultTutorial.jpg");
        }

        return view('FAQ', ['categories' => $categories, 'tutorials' => $tutorials]);
    }



    public function login() {

        $x = -1;

//        if(!siteTime()) {
//            $x = getReminderToNextTime();
//        }

        return view('home', ["reminder" => $x]);
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        return Redirect::route('home');
    }

    public function doLogin() {

        $username = makeValidInput(Input::get('username'));
        $password = makeValidInput(Input::get('password'));

        if(Auth::attempt(['username' => $username, 'password' => $password], true)) {

            if(!Auth::user()->status) {
                $msg = "حساب کاربری شما هنوز فعال نشده است";
                Auth::logout();

                $x = -1;

                if(!siteTime()) {
                    $x = getReminderToNextTime();
                }

                return view('home', ['loginErr' => $msg, "reminder" => $x]);
            }

            if(Auth::user()->level == getValueInfo('studentLevel'))
                return Redirect::route('choosePlan');

            return redirect::route('profile');
        }
        else {
            $msg = 'نام کاربری و یا رمزعبور اشتباه است';
        }

        $x = -1;

        if(!siteTime()) {
            $x = getReminderToNextTime();
        }

        return view('home', ['loginErr' => $msg, "reminder" => $x]);
    }

    public function secondLogin() {

        $username = makeValidInput(Input::get('username'));
        $password = makeValidInput(Input::get('password'));

        if(Auth::attempt(['username' => $username, 'password' => $password], true)) {

            if(!Auth::user()->status)
                return "nok";

            return "ok";
        }

        return "nok";
    }



    public function showAllServices($grade = -1) {

        $config = ConfigModel::first();
        if(!$config->show_service)
            return Redirect::route('home');

        $today = getToday();
        $date = $today["date"];
        $time = (int)$today["time"];

        if(Auth::check() && Auth::user()->level == 1)
            $grade = Auth::user()->grade_id;

        if($grade == -1)
            $grade = Grade::first()->id;

        $services = DB::select('select id, title, start_show, description, star, capacity, created_at from service where ' .
            '(select count(*) from service_grade where service_id = service.id and grade_id = ' . $grade . ' ) > 0'.
            ' and (start_show < ' . $date . ' or (start_show = ' . $date . ' and start_time <= ' . $time . '))' .
            ' and hide = false order by id desc');

        $today = getToday()["date"];
        $mainDiff = findDiffWithSiteStart();

        foreach ($services as $service) {

            $date = MiladyToShamsi('', explode('-', explode(' ', $service->created_at)[0]));
            $date = convertDateToString2($date, "-");

            $diff = 0;

            if ($today != $date) {

                for ($i = 1; $i <= 63; $i++) {
                    if (
                        ($i == 1 && $date == getPast("- " . $i . ' day')) ||
                        ($i > 1 && $date == getPast("- " . $i . ' days'))
                    ) {
                        $diff = $i;
                        break;
                    }
                }
            }

            $service->week = floor(($mainDiff - $diff) / 7);

            if($service->week == 3 && $service->start_show == "14000428")
                $service->week = 4;

            else if($service->week == 2 && $service->start_show != "14000416")
                $service->week = 3;

            $tmpPic = ServicePic::whereServiceId($service->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/servicePic/' . $tmpPic->name))
                $service->pic = URL::asset('servicePic/defaultPic.png');
            else
                $service->pic = URL::asset('servicePic/' . $tmpPic->name);

            if($service->capacity == -1)
                $service->canBuy = true;
            else
                $service->canBuy = (ServiceBuyer::whereServiceId($service->id)->count() < $service->capacity);

            $service->reminder = $service->capacity - ServiceBuyer::whereServiceId($service->id)->count();
        }

        return view('services', ['services' => $services, 'grade' => $grade]);
    }

    public function showService($id) {

        $today = getToday();
        $date = $today["date"];
        $time = (int)$today["time"];

        $service = Service::whereId($id);

        if($service == null || $service->hide  || $service->start_show > $date ||
            ($service->start_show == $date && $service->start_time > $time)) {
            return Redirect::route('home');
        }

        $tmpPics = ServicePic::whereServiceId($service->id)->get();
        $pics = [];

        foreach ($tmpPics as $tmpPic) {

            if(file_exists(__DIR__ . '/../../../public/servicePic/' . $tmpPic->name))
                $pics[count($pics)] = URL::asset('servicePic/' . $tmpPic->name);

        }

        $service->pics = $pics;

        $tmpPics = ServiceAttach::whereServiceId($service->id)->get();
        $pics = [];

        foreach ($tmpPics as $tmpPic) {


            $type = explode(".", $tmpPic->name);
            $type = $type[count($type) - 1];

            if(file_exists(__DIR__ . '/../../../public/servicePic/' . $tmpPic->name))
                $pics[count($pics)] = [
                    "path" => URL::asset('servicePic/' . $tmpPic->name),
                    "type" => $type
                ];


        }

        $service->attaches = $pics;

        $canBuy = (Auth::check()) ? true : false;
        $canAddFile = false;
        $fileStatus = -2;
        $sbId = -1;
        $content = null;

        if($canBuy) {

            $sb = ServiceBuyer::whereServiceId($id)->whereUserId(Auth::user()->id)->first();

            if ($sb != null && !$sb->status && !$service->physical && $sb->file == null) {
                $canAddFile = true;
                $sbId = $sb->id;
            }

            if (!$canAddFile && $sb != null && !$service->physical && $sb->file != null &&
                file_exists(__DIR__ . '/../../../storage/app/public/service_contents/' . $sb->file)) {
                if($sb->complete_upload_file)
                    $content = URL::asset("storage/service_contents/" . $sb->file);
                else {
                    unlink(__DIR__ . '/../../../storage/app/public/service_contents/' . $sb->file);
                    $sb->file = null;
                    $sb->file_status = 0;
                    $sb->start_uploading = null;
                    $sb->save();

                    if(!$sb->status)
                        $canAddFile = true;
                }
            }

            $oldBuy = ($sb != null);

            if (
                $sb != null ||
                ($service->capacity != -1 && ServiceBuyer::whereServiceId($id)->count() == $service->capacity)
            )
                $canBuy = false;

            if ($sb != null &&
                ((!$canAddFile && $sb->file != null) || $sb->file_status != 0))
                $fileStatus = $sb->file_status;

            if ($canBuy && (
                    $service->start_buy > $date ||
                    ($service->start_buy == $date && $service->buy_time > $time)
                )
            )
                $canBuy = false;
        }
        else
            $oldBuy = false;

        return view('showService', ['canBuy' => $canBuy, 'canAddFile' => $canAddFile, 'content' => $content,
            'fileStatus' => $fileStatus, 'service' => $service, 'oldBuy' => $oldBuy, 'sbId' => $sbId]);
    }



    public function showAllGoods($grade = -1) {

        $config = ConfigModel::first();
        if(!$config->show_shop)
            return Redirect::route('home');

        DB::delete("delete from pay_ping_transactions where status = 0 and created_at < date_sub(CURRENT_TIMESTAMP, interval 15 minute)");

        $today = getToday();
        $date = $today["date"];
        $time = (int)$today["time"];

        $grades = DB::select("select g.* from grade g, good gd, users u where gd.user_id = u.id and g.id = u.grade_id group by (g.id)");
        if(count($grades) == 0)
            return Redirect::route('home');

        if($grade == -1)
            $grade = $grades[0]->id;

        $goods = DB::select('select good.id, good.name, code, price, tag, owner, start_date_buy, start_time_buy from good, users where ' .
            ' grade_id = ' . $grade . ' and users.id = user_id' .
            ' and (start_show < ' . $date . ' or (start_show = ' . $date . ' and start_time <= ' . $time . '))' .
            ' and hide = false order by id desc');

        $distinctTags = [];

        foreach ($goods as $good) {

            $tmpPic = GoodPic::whereGoodId($good->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/goodPic/' . $tmpPic->name))
                $good->pic = URL::asset('projectPic/defaultPic.png');
            else
                $good->pic = URL::asset('goodPic/' . $tmpPic->name);

            if($good->price == 0)
                $good->price = "رایگان";
            else
                $good->price = number_format($good->price);

            if ($good->start_date_buy > $date ||
                ($good->start_date_buy == $date && $good->start_time_buy > $time)
            )
                $good->canBuy = false;
            else if(PayPingTransaction::whereGoodId($good->id)->count() > 0)
                $good->canBuy = false;
            else
                $good->canBuy = true;

            if(!empty($good->tag)) {
                $good->tags = explode('-', $good->tag);
                foreach ($good->tags as $tag) {
                    $distinct = true;
                    foreach ($distinctTags as $distinctTag) {
                        if ($tag == $distinctTag) {
                            $distinct = false;
                            break;
                        }
                    }

                    if ($distinct)
                        $distinctTags[count($distinctTags)] = $tag;
                }
            }
            else
                $good->tags = [];

        }

        return view('goods', ['goods' => $goods, 'grades' => $grades,
            'tags' => $distinctTags, 'grade' => $grade]);
    }

    public function showGood($id) {

        DB::delete("delete from pay_ping_transactions where status = 0 and created_at < date_sub(CURRENT_TIMESTAMP, interval 15 minute)");

        $today = getToday();
        $date = $today["date"];
        $time = (int)$today["time"];

        $good = Good::whereId($id);

        if($good == null || $good->hide || $good->start_show > $date ||
            ($good->start_show == $date && $good->start_time > $time))
            return Redirect::route('showAllGoods');

        $tmpPics = GoodPic::whereGoodId($good->id)->get();
        $pics = [];

        foreach ($tmpPics as $tmpPic) {
            if(file_exists(__DIR__ . '/../../../public/goodPic/' . $tmpPic->name))
                $pics[count($pics)] = URL::asset('goodPic/' . $tmpPic->name);
        }

        $good->pics = $pics;

        if($good->price == 0)
            $good->price = "رایگان";
        else
            $good->price = number_format($good->price);

        $canBuy = true;

        $date = getToday()["date"];

        if($canBuy) {

            if (
                $good->start_date_buy > $date ||
                ($good->start_date_buy == $date && $good->start_time_buy > $time)
            )
                $canBuy = false;

            else if(PayPingTransaction::whereGoodId($good->id)->count() > 0)
                $canBuy = false;
        }

        if($good->adv != null && !empty($good->adv) &&
            file_exists(__DIR__ . '/../../../public/goodAdvs/' . $good->adv)
        )
            $good->adv = URL::asset('goodAdvs/' . $good->adv);
        else
            $good->adv = null;

        return view('showGood', ['canBuy' => $canBuy, 'good' => $good]);
    }




    public function showAllProjects($extra, $grade = -1) {

        $extra = boolval($extra);

        $config = ConfigModel::first();
        if((!$extra && !$config->show_project) || ($extra && !$config->show_extra))
            return Redirect::route('home');
//        if($grade != -1 && Auth::user()->level == getValueInfo("studentLevel"))
//            return Redirect::route("choosePlan");

//        if($grade == -1)
//            $grade = Auth::user()->grade_id;

        if(Auth::check() && Auth::user()->level == 1) {
            $grade = Auth::user()->grade_id;
            $canBuy = true;
        }
        else
            $canBuy = false;

        if($extra) {

            $grades = DB::select("select g.* from grade g, project p, project_grade pg where g.id = pg.grade_id " .
                "and pg.project_id = p.id and p.extra = true group by (g.id) order by g.priority asc");
            if (count($grades) == 0)
                return Redirect::route('home');

        }
        else
            $grades = Grade::orderBy('priority', 'asc')->get();

        if($extra) {

            if ($grade == -1)
                $grade = $grades[0]->id;
            else {
                $find = false;
                foreach ($grades as $itr) {
                    if($itr->id == $grade) {
                        $find = true;
                        break;
                    }
                }
                if(!$find)
                    return Redirect::route('home');
            }
        }
        else if(!Auth::check() || $grade == -1)
            $grade = $grades[0]->id;

        $today = getToday();
        $date = $today["date"];
        $time = (int)$today["time"];

        $projects = DB::select('select id, title, physical, description, price, capacity, start_reg_time, start_reg, end_reg from project where ' .
            '(select count(*) from project_grade where project_id = project.id and grade_id = ' . $grade . ' ) > 0' .
            ' and (start_show < ' . $date . ' or (start_show = ' . $date . ' and start_time <= ' . $time . '))' .
            ' and extra = ' . (($extra) ? 1 : 0) . ' and hide = false order by id desc');

        $mainDiff = findDiffWithSiteStart();

        foreach ($projects as $project) {

            $diff = 0;

            if ($date != $project->start_reg) {

                for ($i = 1; $i <= 63; $i++) {
                    if (
                        ($i == 1 && $project->start_reg == getPast("- " . $i . ' day')) ||
                        ($i > 1 && $project->start_reg == getPast("- " . $i . ' days'))
                    ) {
                        $diff = $i;
                        break;
                    }
                }
            }

            $project->week = floor(($mainDiff - $diff) / 7);

            if($project->week == 3 && $project->start_reg == "14000429")
                $project->week = 4;

            else if($project->week == 2 && $project->start_reg != "14000417")
                $project->week = 3;

            $tmpPic = ProjectPic::whereProjectId($project->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/projectPic/' . $tmpPic->name))
                $project->pic = URL::asset('projectPic/defaultPic.png');
            else
                $project->pic = URL::asset('projectPic/' . $tmpPic->name);

            if($project->price == 0)
                $project->price = "رایگان";
            else
                $project->price = number_format($project->price);

            if($canBuy) {

                if ($project->start_reg > $date || $project->end_reg < $date ||
                    ($project->start_reg == $date && $project->start_reg_time > $time)
                )
                    $project->canBuy = false;
                else if ($project->capacity != -1)
                    $project->canBuy = (ProjectBuyers::whereProjectId($project->id)->count() < $project->capacity);
                else
                    $project->canBuy = true;

            }
            else
                $project->canBuy = false;

            $project->tags = DB::select("select t.name, t.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $project->id);
            $str = "-";
            foreach ($project->tags as $tag)
                $str .= $tag->id . '-';
            $project->tagStr = $str;
        }

        return view('projects', ['projects' => $projects,
            'tags' => Tag::whereType("PROJECT")->get(),
            'grade' => $grade,
            'extra' => ($extra) ? 1 : 0,
            'grades' => $grades
            ]);
    }

    public function showProject($id) {

        $today = getToday();
        $date = $today["date"];
        $time = (int)$today["time"];

        $project = Project::whereId($id);

        if($project == null || $project->hide || $project->start_show > $date ||
            ($project->start_show == $date && $project->start_time > $time)) {
            if($project != null && $project->extra)
                return Redirect::route('showAllProjects', ['extra' => true]);
            else
                return Redirect::route('showAllProjects', ['extra' => false]);
        }

        $tmpPics = ProjectPic::whereProjectId($project->id)->get();
        $pics = [];

        foreach ($tmpPics as $tmpPic) {

            if(file_exists(__DIR__ . '/../../../public/projectPic/' . $tmpPic->name))
                $pics[count($pics)] = URL::asset('projectPic/' . $tmpPic->name);

        }

        $project->pics = $pics;

        $tmpPics = ProjectAttach::whereProjectId($project->id)->get();
        $pics = [];

        foreach ($tmpPics as $tmpPic) {

            $type = explode(".", $tmpPic->name);
            $type = $type[count($type) - 1];

            if(file_exists(__DIR__ . '/../../../public/projectPic/' . $tmpPic->name))
                $pics[count($pics)] = [
                    "path" => URL::asset('projectPic/' . $tmpPic->name),
                    "type" => $type
                ];

        }

        $project->attach = $pics;

        if($project->price == 0)
            $project->price = "رایگان";
        else
            $project->price = number_format($project->price);

        $canBuy = (Auth::check()) ? true : false;
        $canAddAdv = false;
        $canAddFile = false;
        $advStatus = -2;
        $fileStatus = -2;
        $content = null;
        $advContent = null;

        $date = getToday()["date"];

        if($canBuy) {

            $pb = ProjectBuyers::whereUserId(Auth::user()->id)->whereProjectId($id)->first();

            if ($pb != null) {
                $canBuy = false;

//                !$pb->status &&
                if (!$project->physical && $pb->file == null)
                    $canAddFile = true;

                if ($pb->adv == null)
                    $canAddAdv = true;

                $project->pbId = $pb->id;

                if (!$canAddFile && !$project->physical && $pb->file != null &&
                    file_exists(__DIR__ . '/../../../storage/app/public/contents/' . $pb->file)) {
                    if($pb->complete_upload_file)
                        $content = URL::asset("storage/contents/" . $pb->file);
                    else {
                        unlink(__DIR__ . '/../../../storage/app/public/contents/' . $pb->file);
                        $pb->file = null;
                        $pb->start_uploading = null;
                        $pb->file_status = 0;
                        $pb->save();

                        if(!$pb->status)
                            $canAddFile = true;
                    }
                }

                if (!$canAddAdv && $pb->adv != null &&
                    file_exists(__DIR__ . '/../../../storage/app/public/advs/' . $pb->adv)) {

                    if($pb->complete_upload_adv)
                        $advContent = URL::asset("storage/advs/" . $pb->adv);
                    else {
                        unlink(__DIR__ . '/../../../storage/app/public/advs/' . $pb->adv);
                        $pb->adv = null;
                        $pb->start_uploading_adv = null;
                        $pb->adv_status = 0;
                        $pb->save();
                        $canAddAdv = true;
                    }
                }

                if ($pb->adv != null || $pb->adv_status != 0)
                    $advStatus = $pb->adv_status;

                if ((!$canAddFile && $pb->file != null) || $pb->file_status != 0)
                    $fileStatus = $pb->file_status;
            }

            if ($canBuy && (
                    $project->start_reg > $date || $project->end_reg < $date ||
                    ($project->start_reg == $date && $project->start_reg_time > $time)
                )
            )
                $canBuy = false;

            elseif ($canBuy && $project->capacity != -1) {
                $canBuy = (ProjectBuyers::whereProjectId($project->id)->count() < $project->capacity);
            }

            if($project->extra)
                $capacity = getExtraProjectLimit(Auth::user());
            else
                $capacity = getProjectLimit(Auth::user()->grade_id);

            $nums = DB::select("select count(*) as countNum from project_buyers pb, project p where pb.project_id = p.id and pb.status = false and p.extra = " . (($project->extra) ? 1 : 0) . " and pb.user_id = " . Auth::user()->id)[0]->countNum;

            $reminder = $capacity - $nums;
            if ($reminder <= 0 && $canBuy)
                $canBuy = false;
        }

        return view('showProject', ['canBuy' => $canBuy, 'project' => $project,
            "canAddAdv" => $canAddAdv, "canAddFile" => $canAddFile, 'content' => $content,
            'advContent' => $advContent, "advStatus" => $advStatus, "fileStatus" => $fileStatus]);
    }


    public function showAllCitizens($grade = -1) {

        $config = ConfigModel::first();
        if(!$config->show_citizen)
            return Redirect::route('home');

        if(Auth::check()) {
            if(Auth::user()->level == 1)
                $grade = Auth::user()->grade_id;
            else if($grade == -1)
                $grade = Grade::first()->id;

            $canBuy = true;
        }
        else
            $canBuy = false;

        if($grade == -1)
            $grade = Grade::first()->id;

        $today = getToday();
        $date = $today["date"];
        $time = (int)$today["time"];

        $projects = DB::select('select citizen.id, title, tag_id, description, point, tag.name as tag, start_reg, end_reg, start_reg_time from citizen, tag where ' .
            'tag.id = tag_id and (select count(*) from citizen_grade where project_id = citizen.id and grade_id = ' . $grade . ' ) > 0' .
            ' and hide = false and (start_show < ' . $date . ' or (start_show = ' . $date . ' and start_time <= ' . $time . ')) order by citizen.id desc');

        $mainDiff = findDiffWithSiteStart();

        foreach ($projects as $project) {

            $diff = 0;

            if ($date != $project->start_reg) {

                for ($i = 1; $i <= 63; $i++) {
                    if (
                        ($i == 1 && $project->start_reg == getPast("- " . $i . ' day')) ||
                        ($i > 1 && $project->start_reg == getPast("- " . $i . ' days'))
                    ) {
                        $diff = $i;
                        break;
                    }
                }
            }

            $project->week = floor(($mainDiff - $diff) / 7);

            $tmpPic = CitizenPic::whereProjectId($project->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/citizenPic/' . $tmpPic->name))
                $project->pic = URL::asset('citizenPic/defaultPic.png');
            else
                $project->pic = URL::asset('citizenPic/' . $tmpPic->name);

            if($canBuy) {
                if ($project->start_reg > $date || $project->end_reg < $date ||
                    ($project->start_reg == $date && $project->start_reg_time > $time)
                )
                    $project->canBuy = false;
                else
                    $project->canBuy = true;
            }
            else
                $project->canBuy = false;
        }

        return view('citizens', ['projects' => $projects,
            'tags' => Tag::whereType("CITIZEN")->get(), 'grade' => $grade]);
    }

    public function showCitizen($id) {

        $today = getToday();
        $date = $today["date"];
        $time = (int)$today["time"];

        $project = Citizen::whereId($id);

        if($project == null || $project->hide || $project->start_show > $date ||
            ($project->start_show == $date && $project->start_time > $time))
            return Redirect::route('showAllCitizens');

        if($project == null || $project->hide)
            return Redirect::route('showAllCitizens');

//        $grade = Auth::user()->grade_id;
//        if(Auth::user()->level == getValueInfo('studentLevel')) {
//
//            $grades = CitizenGrade::whereProjectId($project->id)->get();
//            $allow = false;
//
//            foreach ($grades as $itr) {
//                if ($itr->grade_id == $grade) {
//                    $allow = true;
//                    break;
//                }
//            }
//
//            if(!$allow)
//                return Redirect::route('home');
//        }

        $tmpPics = CitizenPic::whereProjectId($project->id)->get();
        $pics = [];

        foreach ($tmpPics as $tmpPic) {

            if(file_exists(__DIR__ . '/../../../public/citizenPic/' . $tmpPic->name))
                $pics[count($pics)] = URL::asset('citizenPic/' . $tmpPic->name);

        }

        $project->pics = $pics;

        $tmpPics = CitizenAttach::whereProjectId($project->id)->get();
        $pics = [];

        foreach ($tmpPics as $tmpPic) {

            $type = explode(".", $tmpPic->name);
            $type = $type[count($type) - 1];

            if(file_exists(__DIR__ . '/../../../public/citizenPic/' . $tmpPic->name))
                $pics[count($pics)] = [
                    "path" => URL::asset('citizenPic/' . $tmpPic->name),
                    "type" => $type
                ];

        }

        $project->attach = $pics;

        $canBuy = (Auth::check()) ? true : false;
        $date = getToday()["date"];

        if($canBuy &&
            CitizenBuyers::whereUserId(Auth::user()->id)->whereProjectId($id)->count() > 0 ||
            $project->start_reg > $date || $project->end_reg < $date ||
            ($project->start_reg == $date && $project->start_reg_time > $time)
        )
            $canBuy = false;

        return view('showCitizen', ['canBuy' => $canBuy, 'project' => $project]);
    }


    public function showAllProducts($extra, $grade = -1) {

        $extra = boolval($extra);

        $config = ConfigModel::first();
        if((!$extra && !$config->show_product) || ($extra && !$config->show_sell_extra))
            return Redirect::route('home');

        if(Auth::check() && Auth::user()->level == 1) {
            $grade = Auth::user()->grade_id;
            $gradeName = Grade::whereId($grade)->name;
        }

        if($grade == -1) {
            $g = Grade::first();
            $grade = $g->id;
            $gradeName = $g->name;
        }

        $today = getToday();
        $time = $today["time"];
        $today = $today["date"];

        if(Auth::check() && Auth::user()->level != 1) {
            if($extra)
                $unVisualProducts = DB::select('select (select count(*) from product where project_id = project.id and extra = true and hide = false) as total, title as name, end_reg, created_at, id' .
                    ' from project where physical = 0' .
                    ' and extra = true and hide = false group by(id) having total > 0');
            else
                $unVisualProducts = DB::select('select (select count(*) from product where project_id = project.id and extra = ' . (($extra) ? 1 : 0) . ' and hide = false and grade_id = ' . $grade . ') as total, title as name, end_reg, created_at, id' .
                    ' from project where physical = 0 and ' . $grade . ' in (select grade_id from project_grade where project_id = project.id)' .
                    ' and extra = ' . (($extra) ? 1 : 0) . ' and hide = false group by(id) having total > 0');
        }
        else {
            if($extra)
                $unVisualProducts = DB::select('select (select count(*) from product where (start_show < ' . $today .
                    ' or (start_show = ' . $today . ' and start_time <= ' . $time . ')) and ' .
                    'project_id = project.id and extra = true and hide = false) as total, ' .
                    'title as name, end_reg, created_at, id' .
                    ' from project where physical = 0' .
                    ' and extra = true and hide = false group by(id) having total > 0');
            else
                $unVisualProducts = DB::select('select (select count(*) from product where (start_show < ' . $today .
                    ' or (start_show = ' . $today . ' and start_time <= ' . $time . ')) and ' .
                    'project_id = project.id and extra = false and hide = false and grade_id = ' .
                    $grade . ') as total, title as name, end_reg, created_at, id' .
                    ' from project where physical = 0 and ' . $grade . ' in (select grade_id from project_grade where project_id = project.id)' .
                    ' and extra = false and hide = false group by(id) having total > 0');
        }

        $mainDiff = findDiffWithSiteStart();

        foreach ($unVisualProducts as $product) {

            if(!$extra) {

                $date = MiladyToShamsi('', explode('-', explode(' ', $product->created_at)[0]));
                $date = convertDateToString2($date, "-");
                $diff = 0;

                if ($today != $date) {

                    for ($i = 1; $i <= 63; $i++) {
                        if (
                            ($i == 1 && $date == getPast("- " . $i . ' day')) ||
                            ($i > 1 && $date == getPast("- " . $i . ' days'))
                        ) {
                            $diff = $i;
                            break;
                        }
                    }
                }

                $product->week = floor(($mainDiff - $diff) / 7);

                if ($product->week == 2 && $product->end_reg == 14000428)
                    $product->week = 3;

                if ($product->end_reg == 14000507)
                    $product->week = 5;
            }

            $product->name = $product->name . ' ها';

            $tmpPic = ProjectPic::whereProjectId($product->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/projectPic/' . $tmpPic->name))
                $product->pic = URL::asset('projectPic/defaultPic.png');
            else
                $product->pic = URL::asset('projectPic/' . $tmpPic->name);

            $product->tags = DB::select("select t.name, t.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $product->id);

            $str = "-";
            foreach ($product->tags as $tag)
                $str .= $tag->id . '-';

            if($extra)
                $tmp = DB::select("select count(*) as count_, max(price) as maxPrice, max(star) as maxStar from product where " .
                    "id not in (select product_id from transactions where 1) " .
                    "and project_id = " . $product->id . " and extra = true and hide = false group by(project_id)");
            else
                $tmp = DB::select("select count(*) as count_, max(price) as maxPrice, max(star) as maxStar from product where " .
                    "id not in (select product_id from transactions where 1) and grade_id = " .
                    $grade . " and project_id = " . $product->id . " and extra = " . (($extra) ? 1 : 0) . " and hide = false group by(project_id)");

            $product->tagStr = $str;

            if($tmp != null && count($tmp) > 0) {
                $tmp = $tmp[0];
                $reminder = $tmp->count_;
                $product->star = $tmp->maxStar;
                $product->price = $tmp->maxPrice;
                $product->canBuy = (Auth::check() && $reminder > 0) ? true : false;
                $product->owner = "ظرفیت باقی مانده: " . $reminder;
            }
            else {

                if($extra)
                    $tmp = DB::select("select min(price) as minPrice, min(star) as minStar from product where " .
                        " project_id = " . $product->id . " and extra = true and hide = false group by(project_id)")[0];
                else
                    $tmp = DB::select("select min(price) as minPrice, min(star) as minStar from product where " .
                        "grade_id = " . $grade . " and project_id = " . $product->id . " and extra = false and hide = false group by(project_id)")[0];

                $product->star = $tmp->minStar;
                $product->price = $tmp->minPrice;
                $product->canBuy = false;
                $product->owner = "ظرفیت باقی مانده: 0";
            }

            $product->adv_status = false;
            $product->physical = 0;
        }

        if(Auth::check() && Auth::user()->level != 1) {
            if($extra)
                $visualProducts = DB::select('select pb.adv_status, p.start_date_buy, ' .
                    'p.id, name, description, p.physical, price, star, p.project_id, ' .
                    'concat(u.first_name, " ", u.last_name) as owner, p.created_at' .
                    ' from product p, users u, project_buyers pb where p.physical = 1 ' .
                    'and p.extra = true and p.project_id = pb.project_id ' .
                    'and pb.user_id = p.user_id and p.user_id = u.id' .
                    ' and hide = false order by p.id desc');
            else
                $visualProducts = DB::select('select pb.adv_status, p.start_date_buy, ' .
                    'p.id, name, description, p.physical, price, star, p.project_id, ' .
                    'concat(u.first_name, " ", u.last_name) as owner, p.created_at' .
                    ' from product p, users u, project_buyers pb where p.physical = 1 ' .
                    'and p.extra = false and p.project_id = pb.project_id ' .
                    'and pb.user_id = p.user_id and p.user_id = u.id and u.grade_id = ' . $grade .
                    ' and hide = false order by p.id desc');
        }
        else {
            if($extra)
                $visualProducts = DB::select('select pb.adv_status, p.start_date_buy, ' .
                    'p.id, name, description, p.physical, price, star, p.project_id, ' .
                    'concat(u.first_name, " ", u.last_name) as owner, p.created_at' .
                    ' from product p, users u, project_buyers pb where p.physical = 1 and ' .
                    '(start_show < ' . $today . ' or (start_show = ' . $today .
                    ' and start_time <= ' . $time . ')) and p.project_id = pb.project_id and ' .
                    'pb.user_id = p.user_id and p.user_id = u.id' .
                    ' and p.extra = true and hide = false order by p.id desc');
            else
                $visualProducts = DB::select('select pb.adv_status, p.start_date_buy, ' .
                    'p.id, name, description, p.physical, price, star, p.project_id, ' .
                    'concat(u.first_name, " ", u.last_name) as owner, p.created_at' .
                    ' from product p, users u, project_buyers pb where p.physical = 1 and ' .
                    '(start_show < ' . $today . ' or (start_show = ' . $today .
                    ' and start_time <= ' . $time . ')) and p.project_id = pb.project_id and ' .
                    'pb.user_id = p.user_id and p.user_id = u.id and u.grade_id = ' . $grade .
                    ' and p.extra = false and hide = false order by p.id desc');
        }

        foreach ($visualProducts as $product) {

            if(!$extra) {

                $date = MiladyToShamsi('', explode('-', explode(' ', $product->created_at)[0]));
                $date = convertDateToString2($date, "-");

                $diff = 0;

                if ($today != $date) {

                    for ($i = 1; $i <= 63; $i++) {
                        if (
                            ($i == 1 && $date == getPast("- " . $i . ' day')) ||
                            ($i > 1 && $date == getPast("- " . $i . ' days'))
                        ) {
                            $diff = $i;
                            break;
                        }
                    }

                    if ($diff == 0) {

                        for ($i = 1; $i <= 63; $i++) {
                            if (
                                ($i == 1 && $date == getPast("+ " . $i . ' day')) ||
                                ($i > 1 && $date == getPast("+ " . $i . ' days'))
                            ) {
                                $diff = -$i;
                                break;
                            }
                        }

                    }
                }

                $product->week = floor(($mainDiff - $diff) / 7);
                $product->week--;

                if ($product->week == 2 && $product->start_date_buy >= 14000428)
                    $product->week = 3;

                if ($product->start_date_buy == 14000512)
                    $product->week = 5;
            }

            $tmpPic = ProductPic::whereProductId($product->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $product->pic = URL::asset('productPic/defaultPic.png');
            else
                $product->pic = URL::asset('productPic/' . $tmpPic->name);

            if($product->price == 0)
                $product->price = "رایگان";
            else
                $product->price = number_format($product->price);

            $product->tags = DB::select("select t.name, t.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $product->project_id);

            $str = "-";
            foreach ($product->tags as $tag)
                $str .= $tag->id . '-';

            $product->tagStr = $str;

            $product->canBuy = (Transaction::whereProductId($product->id)->count() == 0);
        }

        return view('products', ['products' => array_merge($unVisualProducts, $visualProducts),
            'tags' => Tag::whereType("PROJECT")->get(), 'extra' => ($extra) ? 1 : 0,
            'grade' => $grade, 'grades' => ($extra) ? Grade::take(1)->get() : Grade::orderBy('priority', 'asc')->get()]);

    }

    public function showAllProductsInner($projectId, $gradeId) {

        $today = getToday();
        $time = $today["time"];
        $today = $today["date"];

        if(Auth::check() && Auth::user()->level != 1) {
            $products = DB::select('select pb.adv_status, ' .
                'p.id, name, description, price, star, p.project_id, p.start_date_buy, p.start_time_buy, ' .
                '(select count(*) from transactions where product_id = p.id) > 0 as sold, ' .
                'concat(u.first_name, " ", u.last_name) as owner, p.created_at' .
                ' from product p, users u, project_buyers pb where p.physical = 0 and p.project_id = ' . $projectId . ' and' .
                ' p.project_id = pb.project_id and pb.user_id = p.user_id and p.user_id = u.id and u.grade_id = ' . $gradeId . ' and hide = false order by p.price desc');
        }
        else {
            $products = DB::select('select pb.adv_status, ' .
                'p.id, name, description, price, star, p.project_id, p.start_date_buy, p.start_time_buy, ' .
                '(select count(*) from transactions where product_id = p.id) > 0 as sold, ' .
                'concat(u.first_name, " ", u.last_name) as owner, p.created_at' .
                ' from product p, users u, project_buyers pb where p.physical = 0 and p.project_id = ' . $projectId .
                ' and (start_show < ' . $today . ' or (start_show = ' . $today . ' and start_time <= ' . $time . ')) and ' .
                ' p.project_id = pb.project_id and pb.user_id = p.user_id and p.user_id = u.id and u.grade_id = ' . $gradeId . ' and hide = false order by p.price desc');
        }

        if($products == null || count($products) == 0)
            return Redirect::route("showAllProducts", ['extra' => false]);

        foreach ($products as $product) {

            $tmpPic = ProductPic::whereProductId($product->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $product->pic = URL::asset('productPic/defaultPic.png');
            else
                $product->pic = URL::asset('productPic/' . $tmpPic->name);

            if($product->price == 0)
                $product->price = "رایگان";
            else
                $product->price = number_format($product->price);
        }

        $reminder = DB::select("select count(*) as count_ from product where " .
            "id not in (select product_id from transactions where 1) and grade_id = " .
            $gradeId . " and project_id = " . $projectId . " and hide = false group by(project_id)");

        if($reminder != null && count($reminder) > 0)
            $reminder = $reminder[0]->count_;
        else
            $reminder = 0;

        $canBuy = (Auth::check()) ? ($reminder > 0) : false;
        $myReminder = 0;

        if($canBuy) {
            $uId = Auth::user()->id;
            if($products[0]->start_date_buy > $today || $products[0]->start_time_buy > $time)
                $canBuy = false;
            else {
                $myReminder = ProjectBuyers::whereUserId($uId)->whereStatus(true)->count() - Transaction::whereUserId($uId)->count() - 1;
                if ($myReminder < 0)
                    $canBuy = false;
            }
        }

        return view('productsInner', ['products' => $products, 'canBuy' => $canBuy,
            'projectId' => $projectId, 'grade' => $gradeId, 'myReminder' => $myReminder]);
    }

    public function showAllExtraProductsInner($projectId) {

        $today = getToday();
        $time = $today["time"];
        $today = $today["date"];

        if(Auth::check() && Auth::user()->level != 1) {
            $products = DB::select('select pb.adv_status, ' .
                'p.id, name, description, price, star, p.project_id, p.start_date_buy, p.start_time_buy, ' .
                '(select count(*) from transactions where product_id = p.id) > 0 as sold, ' .
                'concat(u.first_name, " ", u.last_name) as owner, p.created_at' .
                ' from product p, users u, project_buyers pb where p.physical = 0 and p.project_id = ' . $projectId . ' and' .
                ' p.project_id = pb.project_id and pb.user_id = p.user_id and p.user_id = u.id and hide = false order by p.price desc');
        }
        else {
            $products = DB::select('select pb.adv_status, ' .
                'p.id, name, description, price, star, p.project_id, p.start_date_buy, p.start_time_buy, ' .
                '(select count(*) from transactions where product_id = p.id) > 0 as sold, ' .
                'concat(u.first_name, " ", u.last_name) as owner, p.created_at' .
                ' from product p, users u, project_buyers pb where p.physical = 0 and p.project_id = ' . $projectId .
                ' and (start_show < ' . $today . ' or (start_show = ' . $today . ' and start_time <= ' . $time . ')) and ' .
                ' p.project_id = pb.project_id and pb.user_id = p.user_id and p.user_id = u.id and hide = false order by p.price desc');
        }

        if($products == null || count($products) == 0)
            return Redirect::route("showAllProducts", ['extra' => true]);

        foreach ($products as $product) {

            $tmpPic = ProductPic::whereProductId($product->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $product->pic = URL::asset('productPic/defaultPic.png');
            else
                $product->pic = URL::asset('productPic/' . $tmpPic->name);

            if($product->price == 0)
                $product->price = "رایگان";
            else
                $product->price = number_format($product->price);
        }

        $reminder = DB::select("select count(*) as count_ from product where " .
            "id not in (select product_id from transactions where 1) " .
            " and project_id = " . $projectId . " and hide = false group by(project_id)");

        if($reminder != null && count($reminder) > 0)
            $reminder = $reminder[0]->count_;
        else
            $reminder = 0;

        $canBuy = (Auth::check()) ? ($reminder > 0) : false;
        $myReminder = 0;

        if($canBuy) {
            $uId = Auth::user()->id;
            if($products[0]->start_date_buy > $today || $products[0]->start_time_buy > $time)
                $canBuy = false;
            else {
                $myReminder = ProjectBuyers::whereUserId($uId)->whereStatus(true)->count() - Transaction::whereUserId($uId)->count() - 1;
                if ($myReminder < 0)
                    $canBuy = false;
            }
        }

        return view('productsInner', ['products' => $products, 'canBuy' => $canBuy,
            'projectId' => $projectId, 'grade' => Grade::first()->id, 'myReminder' => $myReminder]);
    }

    public function buyUnPhysicalProduct() {

        if(isset($_POST["projectId"]) && isset($_POST["gradeId"])) {

            $projectId = makeValidInput($_POST["projectId"]);
            $gradeId = makeValidInput($_POST["gradeId"]);

            $proj = Project::whereId($projectId);
            if($proj == null)
                return "nok2";

            $user = Auth::user();

            if(!$proj->extra) {
                if ($gradeId != $user->grade_id)
                    return "nok4";

                $product = DB::select(
                    ' select * from product where physical = 0 and project_id = ' . $projectId .
                    ' and grade_id = ' . $gradeId . ' and hide = false ' .
                    'and id not in (select product_id from transactions) order by price desc limit 0, 1');
            }
            else {
                $product = DB::select(
                    ' select * from product where physical = 0 and project_id = ' . $projectId .
                    ' and hide = false ' .
                    'and id not in (select product_id from transactions) order by price desc limit 0, 1');
            }

            if($product == null || count($product) == 0)
                return "nok2";

            $product = $product[0];

            $today = getToday();
            $date = $today["date"];
            $time = (int)$today["time"];

            if(
                ($product->start_date_buy == $date && $product->start_time_buy > $time) ||
                $product->start_date_buy > $date
            )
                return "nok1";


            if($product->price > $user->money)
                return "nok3";

            if(!$product->extra) {

                $totalBuys = DB::select("select count(*) as countNum from transactions t, product p where p.id = t.product_id and p.extra = false and t.user_id = " . $user->id)[0]->countNum;
                $doneProjects = DB::select("select count(*) as countNum from project_buyers pb, project p where p.id = pb.project_id and p.extra = false and pb.status = true and pb.user_id = " . $user->id)[0]->countNum;

                $canBuyItems = $doneProjects - $totalBuys;

                if ($canBuyItems <= 0)
                    return "nok7";

                $buys = DB::select("select count(*) as countNum from transactions t, product p where t.created_at > date_sub(CURDATE(), interval 1 day) and p.id = t.product_id and p.extra = false and t.user_id = " . $user->id)[0]->countNum;

                if ($buys > 0) {
                    $time = (int)$time;
                    if (
                        ($time >= 1200 && $time < 1204) ||
                        ($time >= 1204 && $time <= 1209 && $buys > 1)
                    )
                        return "nok8";
                }
            }

            try {
                $tmp = new Transaction();
                $tmp->user_id = $user->id;
                $tmp->product_id = $product->id;
                $tmp->follow_code = generateActivationCode();
                $tmp->save();

                $user->money -= $product->price;
                $user->stars += $product->star;
                $user->save();

                $tmpUser = User::whereId($product->user_id);

                if($tmpUser != null) {
                    $tmpUser->money += $product->price;
                    $tmpUser->save();
                }

                return "ok";
            }
            catch (\Exception $x) {}
        }

        return "nok";
    }

    public function showProduct($id) {

        $today = getToday();
        $time = $today["time"];
        $today = $today["date"];

        if(Auth::check() && Auth::user()->level != 1) {
            $product = DB::select('select pb.adv, pb.adv_status, pb.file, pb.file_status, ' .
                'p.* from product p, project_buyers pb where ' .
                'p.project_id = pb.project_id and pb.user_id = p.user_id and p.id = ' . $id . ' and hide = false order by p.id desc');
        }
        else {
            $product = DB::select('select pb.adv, pb.adv_status, pb.file, pb.file_status, ' .
                'p.* from product p, project_buyers pb where ' .
                '(start_show < ' . $today . ' or (start_show = ' . $today . ' and start_time <= ' . $time . ')) and ' .
                'p.project_id = pb.project_id and pb.user_id = p.user_id and p.id = ' . $id . ' and hide = false order by p.id desc');
        }

        if($product == null || count($product) == 0)
            return Redirect::route('showAllProducts', ['extra' => false]);

//        $grade = Auth::user()->grade_id;

        $product = $product[0];
        $u = User::whereId($product->user_id);
        $product->owner = $u->first_name . ' ' . $u->last_name;

//        $product->grade_id = $u->grade_id;

//        if(Auth::user()->level == getValueInfo('studentLevel') && $grade != $product->grade_id) {
//            return Redirect::route('showAllProducts');
//        }

        $tmpPics = ProductPic::whereProductId($product->id)->get();
        $pics = [];

        foreach ($tmpPics as $tmpPic) {

            if(file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $pics[count($pics)] = URL::asset('productPic/' . $tmpPic->name);

        }

        $product->pics = $pics;

        $tmpPics = ProductAttach::whereProductId($product->id)->get();
        $pics = [];

        foreach ($tmpPics as $tmpPic) {

            $type = explode(".", $tmpPic->name);
            $type = $type[count($type) - 1];

            if(file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $pics[count($pics)] = [
                    "path" => URL::asset('productPic/' . $tmpPic->name),
                    "type" => $type
                ];

        }

        $product->attach = $pics;

        $tmpPics = ProductTrailer::whereProductId($product->id)->get();
        $pics = [];

        foreach ($tmpPics as $tmpPic) {

            $type = explode(".", $tmpPic->name);
            $type = strtolower($type[count($type) - 1]);
            if(file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $pics[count($pics)] = [
                    "path" => URL::asset('productPic/' . $tmpPic->name),
                    "type" => $type
                ];

        }

        $product->trailer = $pics;

        if(Auth::check() && !$product->physical && $product->file_status &&
            $product->file != null &&
            file_exists(__DIR__ . '/../../../public/storage/contents/' . $product->file)) {

            if(Auth::user()->level == 1) {
                $me = Auth::user();
                $buys = DB::select('select count(*) as count_ from transactions t, product p where t.user_id = ' . $me->id
                    . ' and t.product_id = p.id and project_id = ' . $product->project_id
                    . ' and p.grade_id = ' . $me->grade_id
                )[0]->count_;
            }
            else
                $buys = 1;

            if ($buys > 0)
                $product->file = URL::asset("storage/contents/" . $product->file);
            else
                $product->file = null;
        }
        else
            $product->file = null;

        if($product->price == 0)
            $product->price = "رایگان";
        else
            $product->price = number_format($product->price);

        $canBuy = (Auth::check()) ? true : false;
        $myReminder = 0;

        if($canBuy) {

            if($product->start_date_buy > $today ||
                ($product->start_date_buy == $today && $product->start_time_buy > $time))
                $canBuy = false;

            else {

                if(!$product->extra) {
                    $myReminder = ProjectBuyers::whereUserId(Auth::user()->id)->whereStatus(true)->count() - Transaction::whereUserId(Auth::user()->id)->count() - 1;
                    if ($myReminder < 0)
                        $canBuy = false;
                }

                if (Transaction::whereProductId($id)->count() > 0)
                    $canBuy = false;
            }
        }

        if($product->adv_status && $product->adv != null &&
            file_exists(__DIR__ . '/../../../public/storage/advs/' . $product->adv))
            $product->adv = URL::asset("storage/advs/" . $product->adv);
        else
            $product->adv = null;

//        if($product->file_status && $product->file != null &&
//            file_exists(__DIR__ . '/../../../public/storage/advs/' . $product->file))
//            $product->file = URL::asset("storage/contents/" . $product->file);
//        else
//            $product->file = null;

        return view('showProduct', ['canBuy' => $canBuy,
            'product' => $product, 'myReminder' => $myReminder]);
    }



    public function convertStarToCoin() {

        if (isset($_POST["stars"])) {

            $user = Auth::user();
            $stars = makeValidInput($_POST['stars']);

            if($user->stars >= $stars) {
                $rate = ConfigModel::first()->change_rate;
                $user->money += $rate * $stars;
                $user->stars -= $stars;
                try {
                    $user->save();
                    echo "ok";
                    return;
                }
                catch (\Exception $x) {}
            }

        }

        echo "nok";
    }


    public function buyCitizen() {

        if(isset($_POST["id"])) {

            $today = getToday();
            $date = $today["date"];
            $time = (int)$today["time"];

            $project = Citizen::whereId(makeValidInput($_POST["id"]));
            $user = Auth::user();

            if($project == null || $project->hide || $project->start_show > $date ||
                ($project->start_show == $date && $project->start_time > $time))
                return "nok1";

            if(Auth::user()->level == getValueInfo('studentLevel')) {

                $grades = CitizenGrade::whereProjectId($project->id)->get();
                $allow = false;

                foreach ($grades as $itr) {
                    if ($itr->grade_id == $user->grade_id) {
                        $allow = true;
                        break;
                    }
                }

                if(!$allow)
                    return "nok1";
            }

            if(CitizenBuyers::whereUserId($user->id)->whereProjectId($project->id)->count() > 0)
                return "ok";

            $date = getToday()["date"];
            if($project->start_reg > $date || $project->end_reg < $date)
                return "nok4";

            try {
                $tmp = new CitizenBuyers();
                $tmp->user_id = $user->id;
                $tmp->project_id = $project->id;
                if(isset($_POST["desc"]) && !empty($_POST["desc"]))
                    $tmp->description = makeValidInput($_POST["desc"]);
                $tmp->point = $project->point;

                $tmp->save();

                return "ok";
            }
            catch (\Exception $x) {}
        }

        return "nok5";
    }

    public function buyProject() {

        if(isset($_POST["id"])) {

            $today = getToday();
            $date = $today["date"];
            $time = (int)$today["time"];

            $project = Project::whereId(makeValidInput($_POST["id"]));
            $user = Auth::user();

            if($project == null || $project->hide || $project->extra ||
                $project->start_reg > $date ||
                ($project->start_reg == $date && $project->start_reg_time > $time) ||
                $project->end_reg < $date
            )
                return "nok1";

            if($user->level == getValueInfo('studentLevel')) {

                $grades = ProjectGrade::whereProjectId($project->id)->get();
                $allow = false;

                foreach ($grades as $itr) {
                    if ($itr->grade_id == $user->grade_id) {
                        $allow = true;
                        break;
                    }
                }

                if(!$allow)
                    return "nok1";
            }

            if($project->capacity != -1 &&
                ProjectBuyers::whereProjectId($project->id)->count() >= $project->capacity)
                return "nok7";

            if(ProjectBuyers::whereUserId($user->id)->whereProjectId($project->id)->count() > 0)
                return "nok2";

            if($project->price > $user->money)
                return "nok3";

            $date = getToday()["date"];
            if($project->start_reg > $date || $project->end_reg < $date)
                return "nok4";

            $capacity = getProjectLimit($user->grade_id);
            $openProjects = DB::select("select p.physical, pb.id from project_buyers pb, project p where pb.created_at > date_sub(CURDATE(), interval 1 day) and p.extra = false and pb.status = false and pb.project_id = p.id and pb.user_id = " . Auth::user()->id);

            if($capacity - count($openProjects) <= 0)
                return "nok6";

            if(count($openProjects) > 0) {

                $time = getToday()["time"];

                $time = (int)$time;
                if (
                    ($time >= 1000 && $time < 1004) ||
                    ($time >= 1004 && $time <= 1009 && count($openProjects) > 1)
                )
                    return "nok8";

                if($project->physical && $capacity - 1 == count($openProjects)) {

                    $allow = false;

                    foreach ($openProjects as $openProject) {
                        if (!$openProject->physical) {
                            $allow = true;
                            break;
                        }
                    }

                    if (!$allow)
                        return "nok9";
                }
            }

            try {
                $tmp = new ProjectBuyers();
                $tmp->user_id = $user->id;
                $tmp->project_id = $project->id;
                $tmp->save();

                $user->money -= $project->price;
                $user->save();

                return "ok";
            }
            catch (\Exception $x) {}
        }

        return "nok5";
    }

    public function buyExtraProject() {

        if(isset($_POST["id"])) {

            $today = getToday();
            $date = $today["date"];
            $time = (int)$today["time"];

            $project = Project::whereId(makeValidInput($_POST["id"]));
            $user = Auth::user();

            if($project == null || $project->hide || !$project->extra ||
                $project->start_reg > $date ||
                ($project->start_reg == $date && $project->start_reg_time > $time) ||
                $project->end_reg < $date
            )
                return "nok1";

            if($user->level == getValueInfo('studentLevel')) {

                $grades = ProjectGrade::whereProjectId($project->id)->get();
                $allow = false;

                foreach ($grades as $itr) {
                    if ($itr->grade_id == $user->grade_id) {
                        $allow = true;
                        break;
                    }
                }

                if(!$allow)
                    return "nok1";
            }

            if($project->capacity != -1 &&
                ProjectBuyers::whereProjectId($project->id)->count() >= $project->capacity)
                return "nok7";

            if(ProjectBuyers::whereUserId($user->id)->whereProjectId($project->id)->count() > 0)
                return "nok2";

            if($project->price > $user->money)
                return "nok3";

            $date = getToday()["date"];
            if($project->start_reg > $date || $project->end_reg < $date)
                return "nok4";

            $capacity = getExtraProjectLimit(Auth::user());

            if($capacity == -1)
                return "nok11";

            $openProjects = DB::select("select pb.id from project_buyers pb, project p where pb.status = false and p.extra = true and pb.project_id = p.id and pb.user_id = " . Auth::user()->id);

            if($capacity - count($openProjects) <= 0)
                return "nok6";

            try {
                $tmp = new ProjectBuyers();
                $tmp->user_id = $user->id;
                $tmp->project_id = $project->id;
                $tmp->save();

                $user->money -= $project->price;
                $user->save();

                return "ok";
            }
            catch (\Exception $x) {}
        }

        return "nok5";

    }

    public function buyProduct() {

        if(isset($_POST["id"])) {

            $product = Product::whereId(makeValidInput($_POST["id"]));

            if($product == null || $product->hide || !$product->physical)
                return "nok1";

            $today = getToday();
            $date = $today["date"];
            $time = (int)$today["time"];

            if(
                ($product->start_date_buy == $date && $product->start_time_buy > $time) ||
                $product->start_date_buy > $date
            )
                return "nok1";

            $user = Auth::user();
            if(!$product->extra) {
                $product->grade_id = User::whereId($product->user_id)->grade_id;

                if ($product->grade_id != $user->grade_id)
                    return "nok1";
            }

            if($product->price > $user->money)
                return "nok3";

            if(Transaction::whereProductId($product->id)->count() > 0)
                return "nok2";

            if(!$product->extra) {

                $totalBuys = DB::select("select count(*) as countNum from transactions t, product p where p.id = t.product_id and p.extra = false and t.user_id = " . $user->id)[0]->countNum;
                $doneProjects = DB::select("select count(*) as countNum from project_buyers pb, project p where p.id = pb.project_id and p.extra = false and pb.status = true and pb.user_id = " . $user->id)[0]->countNum;

                $canBuyItems = $doneProjects - $totalBuys;

                if ($canBuyItems <= 0)
                    return "nok7";

                $buys = DB::select("select p.physical from transactions t, product p where t.created_at > date_sub(CURDATE(), interval 2 day) and p.id = t.product_id and p.extra = false and t.user_id = " . $user->id);

                if (count($buys) > 0) {

                    $time = (int)$time;
                    if (
                        ($time >= 1200 && $time < 1204) ||
                        ($time >= 1204 && $time <= 1209 && count($buys) > 1)
                    )
                        return "nok8";

                    if ($canBuyItems == 1) {

                        $countNum = DB::select("select count(*) as count_num from product where physical = 0 "
                            . "and extra = false and grade_id = " . $user->grade_id . " and id not in"
                            . " (select product_id from transactions where 1)")[0]->count_num;

                        if ($countNum > 0) {

                            $allow = false;
                            foreach ($buys as $buy) {
                                if (!$buy->physical) {
                                    $allow = true;
                                    break;
                                }
                            }

                            if (!$allow)
                                return "nok9";
                        }
                    }
                }
            }

            try {
                $tmp = new Transaction();
                $tmp->user_id = $user->id;
                $tmp->product_id = $product->id;
                $tmp->follow_code = generateActivationCode();
                $tmp->save();

                $user->money -= $product->price;
                $user->stars += $product->star;
                $user->save();

                $tmpUser = User::whereId($product->user_id);

                if($tmpUser != null) {
                    $tmpUser->money += $product->price;
                    $tmpUser->save();
                }

                return "ok";
            }
            catch (\Exception $x) {}
        }

        return "nok5";
    }

    public function buyService() {

        if(isset($_POST["id"])) {

            $service = Service::whereId(makeValidInput($_POST["id"]));
            $user = Auth::user();

            if($service == null || $service->hide)
                return "nok1";

            $today = getToday();
            $date = $today["date"];
            $time = (int)$today["time"];

            if(
                ($service->start_buy == $date && $service->buy_time > $time) ||
                $service->start_buy > $date
            )
                return "nok1";

            $grades = ServiceGrade::whereServiceId($service->id)->get();
            $allow = false;

            foreach ($grades as $grade) {
                if($grade->grade_id == $user->grade_id) {
                    $allow = true;
                    break;
                }
            }

            if(!$allow)
                return "nok1";

            if(ServiceBuyer::whereUserId($user->id)->whereStatus(false)->count() >= ConfigModel::first()->service_limit)
                return "nok7";

            if(ServiceBuyer::whereServiceId($service->id)->count() == $service->capacity)
                return "nok2";

            if(ServiceBuyer::whereServiceId($service->id)->whereUserId($user->id)->count() > 0)
                return "nok3";

            try {
                $tmp = new ServiceBuyer();
                $tmp->user_id = $user->id;
                $tmp->service_id = $service->id;
                $tmp->save();

                return "ok";
            }
            catch (\Exception $x) {
                dd($x);
            }
        }

        return "nok5";
    }

    public function reloadMsgs() {

        if(isset($_POST["lastId"])) {

            $msg = Msg::whereId(makeValidInput($_POST["lastId"]));
            if($msg == null) {
                echo json_encode(["status" => "nok"]);
                return;
            }

            $msgs = DB::select("select * from msg where chat_id = " . $msg->chat_id .
                " and id > " . makeValidInput($_POST["lastId"]));

            foreach ($msgs as $msg) {
                $timestamp = strtotime($msg->created_at);
                $msg->time = MiladyToShamsiTime($timestamp);

                $timestamp = strtotime($msg->created_at);
                $msg->time = MiladyToShamsiTime($timestamp);
            }


            echo json_encode(["status" => "ok", "msgs" => $msgs]);
            return;
        }

        echo json_encode(["status" => "nok"]);
    }

    public function sendMsg() {

        if(isset($_POST["msg"])) {

            $chat = DB::select("select id from chat where user_id = " . Auth::user()->id
                . " and created_at > DATE_SUB(NOW(), INTERVAL 6 HOUR)");

            if($chat != null && count($chat) > 0) {

                $msg = new Msg();
                $msg->text = makeValidInput($_POST["msg"]);
                $msg->chat_id = $chat[0]->id;
                $msg->is_me = true;
                try {
                    $msg->save();
                    echo json_encode(["status" => "ok",
                        "sendTime" => convertStringToTime(getToday()["time"]),
                        "id" => $msg->id
                    ]);
                    return;
                }
                catch (\Exception $x) {
                    dd($x);
                }
            }
            else {

                try {

                    $c = new Chat();
                    $c->user_id = Auth::user()->id;
                    $c->save();

                    $msg = new Msg();
                    $msg->text = makeValidInput($_POST["msg"]);
                    $msg->chat_id = $c->id;
                    $msg->is_me = true;

                    $msg->save();
                    echo json_encode(["status" => "ok",
                        "sendTime" => convertStringToTime(getToday()["time"]),
                        "id" => $msg->id
                    ]);
                    return;
                }
                catch (\Exception $x) {
                    dd($x);
                }

            }
        }

        echo json_encode(["status" => "nok"]);
    }


    public function myProjects() {
        return Redirect::route("profile");
    }

    public function myProducts() {
        return Redirect::route("profile");
    }

    public function myServices() {
        return Redirect::route("profile");
    }


    public function rules() {
        return view("rules");
    }

    public function contactUs() {
        return view("contactUs");
    }


    public function downloadAllProjectAttaches($pId) {

        $zip = new ZipArchive();

        $DelFilePath = time() . ".zip";

        if ($zip->open(__DIR__ . '/../../../public/tmp/' . $DelFilePath, ZIPARCHIVE::CREATE) != TRUE) {
            dd ("Could not open archive");
        }

        $attaches = ProjectAttach::whereProjectId($pId)->get();

        foreach ($attaches as $attach) {
            $zip->addFile(__DIR__ . '/../../../public/projectPic/' . $attach->name, $attach->name);
        }

        $zip->close();

        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename= files.zip");
        header("Content-length: " . filesize(__DIR__ . '/../../../public/tmp/' . $DelFilePath));
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile(__DIR__ . '/../../../public/tmp/' . $DelFilePath);
        unlink(__DIR__ . '/../../../public/tmp/' . $DelFilePath);
        exit();
    }


    public function getVerificationCode() {

        if(isset($_POST["nid"]) && isset($_POST["phone"]) &&
            isset($_POST["name"]) && isset($_POST["last_name"])) {

            $name = makeValidInput($_POST["name"]);
            $lasName = makeValidInput($_POST["last_name"]);

            if(empty($name) || empty($lasName))
                return json_encode(["status" => "nok", "msg" => "لطفا نام و نام خانوادگی خود را وارد نمایید."]);

            $nid = translatePersian(makeValidInput($_POST["nid"]));

            if(!_custom_check_national_code($nid))
                return json_encode(["status" => "nok", "msg" => "کد ملی وارد شده معتبر نمی باشد."]);

            $phone = translatePersian(makeValidInput($_POST["phone"]));

            if(!preg_match('/^(?:98|\+98|0098|0)?9[0-9]{9}$/', $phone))
                return json_encode(["status" => "nok", "msg" => "شماره همراه وارد شده معتبر نمی باشد."]);

            if(User::whereNid($nid)->count() > 0)
                return json_encode(["status" => "nok", "msg" => "کد ملی وارد شده در سیستم موجود است."]);

            if(User::wherePhone($phone)->count() > 0)
                return json_encode(["status" => "nok", "msg" => "شماره همراه وارد شده در سیستم موجود است."]);

            $activation = Activation::whereNid($nid)->first();

            if($activation != null && $activation->phone != $phone)
                return json_encode(["status" => "nok", "msg" => "کد ملی وارد شده در سیستم موجود است."]);

            if($activation == null) {
                $activation = new Activation();
                $activation->name = makeValidInput($_POST["name"]);
                $activation->last_name = makeValidInput($_POST["last_name"]);
                $activation->nid = $nid;
                $activation->phone = $phone;
                $activation->send_time = time();

                $token = str_random(100);
                $code = rand(10000, 99999);

                $activation->token = $token;
                $activation->code = $code;
                $activation->save();
                sendSMS($phone, $code, "");

                return json_encode(["status" => "ok", "token" => $activation->token]);
            }

            if(time() - $activation->send_time < 180)
                return json_encode(["status" => "ok", "token" => $activation->token]);

            $token = str_random(100);
            $code = rand(10000, 99999);

            $activation->token = $token;
            $activation->code = $code;
            $activation->save();

            sendSMS($phone, $code, "");
            return json_encode(["status" => "ok", "token" => $activation->token]);
        }

        return json_encode(["status" => "nok", "msg" => "not valid params"]);
    }

    function resend() {

        if(isset($_POST["token"]) && isset($_POST["phone"])) {

            $phone = translatePersian(makeValidInput($_POST["phone"]));
            $a = Activation::wherePhone($phone)->first();
            if ($a == null)
                return "nok1";

            if ($a->token != makeValidInput($_POST["token"]))
                return "nok2";

            if(time() - $a->send_time < 180)
                return "nok3";

            $token = str_random(100);
            $code = rand(10000, 99999);

            $a->send_time = time();
            $a->token = $token;
            $a->code = $code;
            $a->save();

            sendSMS($phone, $code, "");

            return $token;
        }

        return "nok";
    }

    function verify() {

        if(isset($_POST["token"]) && isset($_POST["code"])) {

            $code = translatePersian(makeValidInput($_POST["code"]));
            $a = Activation::whereCode($code)->first();
            if($a == null)
                return "nok1";

            if($a->token != makeValidInput($_POST["token"]))
                return "nok1";

            $user = new User();
            $user->first_name = $a->name;
            $user->last_name = $a->last_name;
            $user->nid = $a->nid;
            $user->password = Hash::make($a->nid);
            $user->username = $a->phone;
            $user->phone = $a->phone;
            $user->grade_id = Grade::first()->id;
            $user->level = 1;
            $user->status = 1;
            $user->stars = 0;
            $user->money = 0;
            $user->save();

            $a->delete();
            Auth::attempt(['username' => $user->username, 'password' => $a->nid], true);

            return "ok";
        }

        return "nok1";
    }

    public function failTransaction() {
        return view('fail');
    }

    public function failTransaction2() {
        return view('fail2');
    }

    public function successTransaction($id) {

        $transaction = DB::select('select gd.name, gd.owner, gd.code, p.ref_id, p.created_at ' .
            'from pay_ping_transactions p, good gd where p.good_id = gd.id and ' .
            'p.user_id = ' . Auth::user()->id . ' and p.id = ' . $id
        );

        if($transaction == null || count($transaction) == 0)
            return Redirect::route('home');

        $transaction = $transaction[0];
        $date = MiladyToShamsi('', explode('-', explode(' ', $transaction->created_at)[0]));
        $date = explode("-", $date);

        return view('successTrans', ['ref' => $transaction->ref_id,
            "name" => $transaction->name, 'owner' => $transaction->owner,
            'code' => $transaction->code, 'date' => $date]
        );
    }
}
