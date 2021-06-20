<?php

namespace App\Http\Controllers;


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
use App\models\Msg;
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

        $x = -1;

        if(!siteTime()) {
            $x = getReminderToNextTime();
        }

        return view('home', ["reminder" => $x]);
    }

    public function choosePlan() {
        return view('choosePlan');
    }

    public function profile() {

        if(Auth::user()->level == getValueInfo('operatorLevel'))
            return view('adminProfile');

        $myBuys = DB::select("select p.id, t.status, p.name, concat(u.first_name, ' ', u.last_name) as seller, " .
            "pb.project_id, p.price, p.star, t.follow_code, t.created_at from transactions t, product p, project_buyers pb, users u where " .
            " u.id = pb.user_id and pb.project_id = p.project_id and p.user_id = u.id and " .
            " t.product_id = p.id and t.user_id = " . Auth::user()->id);

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
                $myBuy->pic = URL::asset('productPic/defaultPic.jpg');
            else
                $myBuy->pic = URL::asset('productPic/' . $tmpPic->name);

        }


        $myProducts = DB::select("select * from product where " .
            "user_id = " . Auth::user()->id);

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
                $myBuy->pic = URL::asset('productPic/defaultPic.jpg');
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
            "p.id = pb.project_id and pb.user_id = " . Auth::user()->id);

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
                $myProject->pic = URL::asset('projectPic/defaultPic.jpg');
            else
                $myProject->pic = URL::asset('projectPic/' . $tmpPic->name);

            if($myProject->price == 0)
                $myProject->price = "رایگان";
            else
                $myProject->price .= " سکه ";
        }



        $myServices = DB::select("select s.id, sb.status, sb.star myStar, s.star, s.title from service_buyer sb, service s where " .
            " sb.service_id = s.id and sb.user_id = " . Auth::user()->id);

        foreach ($myServices as $myService) {

            $tmpPic = ServicePic::whereServiceId($myService->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/servicePic/' . $tmpPic->name))
                $myService->pic = URL::asset('servicePic/defaultPic.jpg');
            else
                $myService->pic = URL::asset('servicePic/' . $tmpPic->name);

        }

        return view('profile', ['myBuys' => $myBuys, "myServices" => $myServices,
            "myProducts" => $myProducts, 'myProjects' => $myProjects]);
    }

    public function faq() {

        $categories = FAQCategory::all();

        foreach ($categories as $category) {
            $category->items = CommonQuestion::whereCategoryId($category->id)->get();
        }

        return view('FAQ', ['categories' => $categories]);
    }



    public function login() {

        $x = -1;

        if(!siteTime()) {
            $x = getReminderToNextTime();
        }

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



    public function showAllServices($grade = -1) {

        if($grade != -1 && Auth::user()->level == getValueInfo("studentLevel"))
            return Redirect::route("choosePlan");

        if($grade == -1)
            $grade = Auth::user()->grade_id;

        $services = DB::select('select id, title, description, star, capacity, created_at from service where ' .
            '(select count(*) from service_grade where service_id = service.id and grade_id = ' . $grade . ' ) > 0'.
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


            $tmpPic = ServicePic::whereServiceId($service->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/servicePic/' . $tmpPic->name))
                $service->pic = URL::asset('servicePic/defaultPic.jpg');
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

        $service = Service::whereId($id);
        $grade = Auth::user()->grade_id;

        if($service == null || $service->hide) {
            return Redirect::route('home');
        }

        if(Auth::user()->level == getValueInfo('studentLevel')) {

            $grades = ServiceGrade::whereServiceId($service->id)->get();
            $allow = false;

            foreach ($grades as $itr) {
                if ($itr->grade_id == $grade) {
                    $allow = true;
                    break;
                }
            }

            if(!$allow)
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

        $canBuy = true;
        $oldBuy = ServiceBuyer::whereServiceId($id)->whereUserId(Auth::user()->id)->count();

        if(
            ($service->capacity != -1 && ServiceBuyer::whereServiceId($id)->count() == $service->capacity) ||
            $oldBuy > 0
        )
            $canBuy = false;

        return view('showService', ['canBuy' => $canBuy,
            'service' => $service, 'oldBuy' => $oldBuy]);
    }



    public function showAllProjects($grade = -1) {

        if($grade != -1 && Auth::user()->level == getValueInfo("studentLevel"))
            return Redirect::route("choosePlan");

        if($grade == -1)
            $grade = Auth::user()->grade_id;

        $date = getToday()["date"];

        $projects = DB::select('select id, title, physical, description, price, capacity, start_reg, end_reg from project where ' .
            '(select count(*) from project_grade where project_id = project.id and grade_id = ' . $grade . ' ) > 0' .
            ' and hide = false order by id desc');

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

            $tmpPic = ProjectPic::whereProjectId($project->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/projectPic/' . $tmpPic->name))
                $project->pic = URL::asset('projectPic/defaultPic.jpg');
            else
                $project->pic = URL::asset('projectPic/' . $tmpPic->name);

            if($project->price == 0)
                $project->price = "رایگان";
            else
                $project->price = number_format($project->price);

            if($project->capacity == -1)
                $project->canBuy = true;
            else
                $project->canBuy = (ProjectBuyers::whereProjectId($project->id)->count() < $project->capacity);

            if($project->canBuy) {
                if($project->start_reg > $date || $project->end_reg < $date)
                    $project->canBuy = false;
            }

            $project->tags = DB::select("select t.name, t.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $project->id);
            $str = "-";
            foreach ($project->tags as $tag)
                $str .= $tag->id . '-';
            $project->tagStr = $str;
        }

        return view('projects', ['projects' => $projects, 'tags' => Tag::whereType("PROJECT")->get(), 'grade' => $grade]);
    }

    public function showProject($id) {

        $project = Project::whereId($id);
        $grade = Auth::user()->grade_id;

        if($project == null || $project->hide) {
            return Redirect::route('showAllProjects');
        }

        if(Auth::user()->level == getValueInfo('studentLevel')) {

            $grades = ProjectGrade::whereProjectId($project->id)->get();
            $allow = false;

            foreach ($grades as $itr) {
                if ($itr->grade_id == $grade) {
                    $allow = true;
                    break;
                }
            }

            if(!$allow)
                return Redirect::route('home');
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

        $canBuy = true;
        $canAddAdv = false;
        $canAddFile = false;
        $advStatus = -2;
        $fileStatus = -2;

        $date = getToday()["date"];

        $pb = ProjectBuyers::whereUserId(Auth::user()->id)->whereProjectId($id)->first();
        if($pb != null) {
            $canBuy = false;
            if(!$pb->status) {
                if($pb->adv == null)
                    $canAddAdv = true;
                if(!$project->physical && $pb->file == null)
                    $canAddFile = true;
            }

            $project->pbId = $pb->id;

            if((!$canAddAdv && $pb->adv != null) || $pb->adv_status != 0)
                $advStatus = $pb->adv_status;

            if((!$canAddFile && $pb->file != null) || $pb->file_status != 0)
                $fileStatus = $pb->file_status;
        }

        else if($project->start_reg > $date || $project->end_reg < $date)
            $canBuy = false;

        if($canBuy && $project->capacity != -1) {
            $canBuy = (ProjectBuyers::whereProjectId($project->id)->count() < $project->capacity);
        }

        $capacity = ConfigModel::first()->project_limit;
        $nums = DB::select("select count(*) as countNum from project_buyers where status = false and user_id = " . Auth::user()->id)[0]->countNum;

        $reminder = $capacity - $nums;
        if($reminder <= 0 && $canBuy)
            $canBuy = false;

        return view('showProject', ['canBuy' => $canBuy, 'project' => $project,
            "canAddAdv" => $canAddAdv, "canAddFile" => $canAddFile,
            "advStatus" => $advStatus, "fileStatus" => $fileStatus]);
    }


    public function showAllCitizens($grade = -1) {

        if($grade != -1 && Auth::user()->level == getValueInfo("studentLevel"))
            return Redirect::route("choosePlan");

        if($grade == -1)
            $grade = Auth::user()->grade_id;

        $date = getToday()["date"];

        $projects = DB::select('select citizen.id, title, tag_id, description, point, tag.name as tag, start_reg, end_reg from citizen, tag where ' .
            'tag.id = tag_id and (select count(*) from citizen_grade where project_id = citizen.id and grade_id = ' . $grade . ' ) > 0' .
            ' and hide = false order by citizen.id desc');

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
                $project->pic = URL::asset('citizenPic/defaultPic.jpg');
            else
                $project->pic = URL::asset('citizenPic/' . $tmpPic->name);

            $project->canBuy = true;
            if($project->canBuy) {
                if($project->start_reg > $date || $project->end_reg < $date)
                    $project->canBuy = false;
            }
        }

        return view('citizens', ['projects' => $projects, 'tags' => Tag::whereType("CITIZEN")->get(), 'grade' => $grade]);
    }

    public function showCitizen($id) {

        $project = Citizen::whereId($id);

        if($project == null || $project->hide)
            return Redirect::route('showAllCitizens');

        $grade = Auth::user()->grade_id;
        if(Auth::user()->level == getValueInfo('studentLevel')) {

            $grades = CitizenGrade::whereProjectId($project->id)->get();
            $allow = false;

            foreach ($grades as $itr) {
                if ($itr->grade_id == $grade) {
                    $allow = true;
                    break;
                }
            }

            if(!$allow)
                return Redirect::route('home');
        }

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

        $canBuy = true;
        $date = getToday()["date"];

        if(
            CitizenBuyers::whereUserId(Auth::user()->id)->whereProjectId($id)->count() > 0 ||
            $project->start_reg > $date || $project->end_reg < $date
        )
            $canBuy = false;

        return view('showCitizen', ['canBuy' => $canBuy, 'project' => $project]);
    }


    public function showAllProducts($grade = -1) {

        if($grade != -1 && Auth::user()->level == getValueInfo("studentLevel"))
            return Redirect::route("choosePlan");

        if($grade == -1)
            $grade = Auth::user()->grade_id;

        $today = getToday()["date"];
        $products = DB::select('select pb.adv, pb.adv_status, pb.file, pb.file_status, ' .
            'p.id, name, description, price, star, p.project_id, ' .
            'concat(u.first_name, " ", u.last_name) as owner, p.created_at' .
            ' from product p, users u, project_buyers pb  where ' .
            'p.project_id = pb.project_id and pb.user_id = p.user_id and p.user_id = u.id and u.grade_id = ' . $grade . ' and hide = false order by p.id desc');

        $mainDiff = findDiffWithSiteStart();

        foreach ($products as $product) {

            if($product->adv_status && $product->adv != null &&
                file_exists(__DIR__ . '/../../../storage/app/public/advs/' . $product->adv))
                $product->adv = URL::asset("storage/adv/" . $product->adv);
            else
                $product->adv = null;

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
            $product->week--;

            $tmpPic = ProductPic::whereProductId($product->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $product->pic = URL::asset('productPic/defaultPic.jpg');
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

        return view('products', ['products' => $products, 'tags' => Tag::whereType("PROJECT")->get(), 'grade' => $grade]);

    }

    public function showProduct($id) {

        $product = Product::whereId($id);
        $grade = Auth::user()->grade_id;

        if($product == null || $product->hide) {
            return Redirect::route('showAllProducts');
        }

        $u = User::whereId($product->user_id);
        $product->owner = $u->first_name . ' ' . $u->last_name;

        $product->grade_id = User::whereId($product->user_id)->grade_id;

        if(Auth::user()->level == getValueInfo('studentLevel') && $grade != $product->grade_id) {
            return Redirect::route('showAllProducts');
        }

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
            $type = $type[count($type) - 1];

            if(file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $pics[count($pics)] = [
                    "path" => URL::asset('productPic/' . $tmpPic->name),
                    "type" => $type
                ];

        }

        $product->trailer = $pics;



        if($product->price == 0)
            $product->price = "رایگان";
        else
            $product->price = number_format($product->price);

        $canBuy = true;

        $myReminder = ProjectBuyers::whereUserId(Auth::user()->id)->whereStatus(true)->count() - Transaction::whereUserId(Auth::user()->id)->count() - 1;
        if($myReminder < 0)
            $canBuy = false;

        if(Transaction::whereProductId($id)->count() > 0)
            $canBuy = false;

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

            $project = Citizen::whereId(makeValidInput($_POST["id"]));
            $user = Auth::user();

            if($project == null || $project->hide)
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

            $project = Project::whereId(makeValidInput($_POST["id"]));
            $user = Auth::user();

            if($project == null || $project->hide) {
                echo "nok1";
                return;
            }

            if(Auth::user()->level == getValueInfo('studentLevel')) {

                $grades = ProjectGrade::whereProjectId($project->id)->get();
                $allow = false;

                foreach ($grades as $itr) {
                    if ($itr->grade_id == $user->grade_id) {
                        $allow = true;
                        break;
                    }
                }

                if(!$allow) {
                    echo "nok1";
                    return;
                }
            }


            if($project->capacity != -1 &&
                ProjectBuyers::whereProjectId($project->id)->count() >= $project->capacity) {
                echo "nok7";
                return;
            }

            if(ProjectBuyers::whereUserId($user->id)->whereProjectId($project->id)->count() > 0) {
                echo "nok2";
                return;
            }

            if($project->price > $user->money) {
                echo "nok3";
                return;
            }

            $date = getToday()["date"];
            if($project->start_reg > $date || $project->end_reg < $date) {
                echo "nok4";
                return;
            }

            $capacity = ConfigModel::first()->project_limit;
            $openProjects = DB::select("select p.physical from project_buyers pb, project p where pb.status = false and pb.user_id = " . Auth::user()->id);

            if($capacity - count($openProjects) <= 0) {
                echo "nok6";
                return;
            }

            if(count($openProjects) > 0) {

                $allow = false;

                foreach($openProjects as $openProject) {
                    if($openProject->physical) {
                        $allow = true;
                        break;
                    }
                }

                if(!$allow) {
                    echo "nok9";
                    return;
                }

            }

            try {
                $tmp = new ProjectBuyers();
                $tmp->user_id = $user->id;
                $tmp->project_id = $project->id;
                $tmp->save();

                $user->money -= $project->price;
                $user->save();

                echo "ok";
                return;
            }
            catch (\Exception $x) {}
        }

        echo "nok5";
    }

    public function buyProduct() {

        if(isset($_POST["id"])) {

            $product = Product::whereId(makeValidInput($_POST["id"]));
            $user = Auth::user();

            if($product == null || $product->hide) {
                echo "nok1";
                return;
            }

            $product->grade_id = User::whereId($product->user_id)->grade_id;

            if($product->grade_id != $user->grade_id) {
                echo "nok1";
                return;
            }

            if(Transaction::whereProductId($product->id)->count() > 0) {
                echo "nok2";
                return;
            }

            $buys = DB::select("select p.physical from transactions t, product p where p.id = t.product_id and t.user_id = " . $user->id);

            if(ProjectBuyers::whereUserId($user->id)->whereStatus(true)->count() <= count($buys)) {
                echo "nok7";
                return;
            }

            if($product->price > $user->money) {
                echo "nok3";
                return;
            }

            if(count($buys) > 0) {

                $allow = false;

                foreach ($buys as $buy) {
                    if($buy->physical) {
                        $allow = true;
                        break;
                    }
                }

                if(!$allow) {
                    echo "nok9";
                    return;
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

                echo "ok";
                return;
            }
            catch (\Exception $x) {}
        }

        echo "nok5";

    }

    public function buyService() {

        if(isset($_POST["id"])) {

            $service = Service::whereId(makeValidInput($_POST["id"]));
            $user = Auth::user();

            if($service == null || $service->hide) {
                echo "nok1";
                return;
            }

            $grades = ServiceGrade::whereServiceId($service->id)->get();
            $allow = false;

            foreach ($grades as $grade) {
                if($grade->grade_id == $user->grade_id) {
                    $allow = true;
                    break;
                }
            }

            if(!$allow) {
                echo "nok1";
                return;
            }

            if(ServiceBuyer::whereUserId($user->id)->whereStatus(false)->count() >= ConfigModel::first()->service_limit) {
                echo "nok7";
                return;
            }

            if(ServiceBuyer::whereServiceId($service->id)->count() == $service->capacity) {
                echo "nok2";
                return;
            }

            if(ServiceBuyer::whereServiceId($service->id)->whereUserId($user->id)->count() > 0) {
                echo "nok3";
                return;
            }

            try {
                $tmp = new ServiceBuyer();
                $tmp->user_id = $user->id;
                $tmp->service_id = $service->id;
                $tmp->save();

                echo "ok";
                return;
            }
            catch (\Exception $x) {
                dd($x);
            }
        }

        echo "nok5";

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

}
