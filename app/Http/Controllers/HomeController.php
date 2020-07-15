<?php

namespace App\Http\Controllers;


use App\models\Bookmark;
use App\models\Chat;
use App\models\CommonQuestion;
use App\models\ConfigModel;
use App\models\FAQCategory;
use App\models\Likes;
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
use App\models\ServiceBuyer;
use App\models\ServiceGrade;
use App\models\ServicePic;
use App\models\Tag;
use App\models\Transaction;
use App\models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

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

//        if(Auth::user()->level == getValueInfo('adminLevel') ||
//            Auth::user()->level == getValueInfo('operatorLevel')
//        )
//            return view('adminProfile');

        $myBuys = DB::select("select p.id, t.status, p.name, concat(u.first_name, ' ', u.last_name) as seller, " .
            "pb.project_id, p.price, p.star, t.follow_code, t.created_at from transactions t, product p, project_buyers pb, users u where " .
            " u.id = pb.user_id and pb.project_id = p.project_id and " .
            " t.product_id = p.id and t.user_id = " . Auth::user()->id);

        foreach ($myBuys as $myBuy) {

            $myBuy->date = MiladyToShamsi('', explode('-', explode(' ', $myBuy->created_at)[0]));

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

            $myBuy->date = MiladyToShamsi('', explode('-', explode(' ', $myBuy->created_at)[0]));

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

            $myProject->date = MiladyToShamsi('', explode('-', explode(' ', $myProject->created_at)[0]));

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
        return view('home');
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



    public function showAllServices() {

        $grade = Auth::user()->grade_id;

        $services = DB::select('select id, title, description, star, capacity, created_at from service where ' .
            '(select count(*) from service_grade where service_id = service.id and grade_id = ' . $grade . ' ) > 0'.
            ' and hide = false order by id desc');

        $today = getToday()["date"];

        foreach ($services as $service) {

            $date = MiladyToShamsi('', explode('-', explode(' ', $service->created_at)[0]));
            $date = convertDateToString2($date, "-");

            $service->week = floor(($today - $date) / 7.0);

            $tmpPic = ServicePic::whereServiceId($service->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/servicePic/' . $tmpPic->name))
                $service->pic = URL::asset('servicePic/defaultPic.jpg');
            else
                $service->pic = URL::asset('servicePic/' . $tmpPic->name);

            if($service->capacity == -1)
                $service->canBuy = true;
            else
                $service->canBuy = (ServiceBuyer::whereServiceId($service->id)->count() < $service->capacity);

            $service->likes = Likes::whereItemId($service->id)->whereMode(getValueInfo('serviceMode'))->count();
            $service->reminder = $service->capacity - ServiceBuyer::whereServiceId($service->id)->count();
        }

        return view('services', ['services' => $services]);
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

        $bookmark = true;
//        $bookmark = (Bookmark::whereUserId(Auth::user()->id)->whereItemId($id)->whereMode(getValueInfo('serviceMode'))->count() > 0);

        $like = (Likes::whereUserId(Auth::user()->id)->whereItemId($id)->whereMode(getValueInfo('serviceMode'))->count() > 0);

        $canBuy = true;

        if(
            ($service->capacity != -1 && ServiceBuyer::whereServiceId($id)->count() == $service->capacity) ||
            ServiceBuyer::whereServiceId($id)->whereUserId(Auth::user()->id)->count() > 0
        )
            $canBuy = false;

        return view('showService', ['bookmark' => $bookmark, 'canBuy' => $canBuy,
            'service' => $service, 'like' => $like]);
    }



    public function showAllProjects() {

        $grade = Auth::user()->grade_id;
        $date = getToday()["date"];

        $projects = DB::select('select id, title, description, price, capacity, start_reg from project where ' .
            '(select count(*) from project_grade where project_id = project.id and grade_id = ' . $grade . ' ) > 0' .
            ' and start_reg <= ' . $date . ' and end_reg >= ' . $date . ' and hide = false order by id desc');

        foreach ($projects as $project) {

            $project->week = floor(($date - $project->start_reg) / 7.0);

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

            $project->likes = Likes::whereItemId($project->id)->whereMode(getValueInfo('projectMode'))->count();
            $project->tags = DB::select("select t.name, t.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $project->id);
            $str = "-";
            foreach ($project->tags as $tag)
                $str .= $tag->id . '-';
            $project->tagStr = $str;
        }

        return view('projects', ['projects' => $projects, 'tags' => Tag::all()]);
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

        $bookmark = (Bookmark::whereUserId(Auth::user()->id)->whereItemId($id)->whereMode(getValueInfo('projectMode'))->count() > 0);
        $like = (Likes::whereUserId(Auth::user()->id)->whereItemId($id)->whereMode(getValueInfo('projectMode'))->count() > 0);
        $canBuy = true;
        $date = getToday()["date"];

        if(
            ProjectBuyers::whereUserId(Auth::user()->id)->whereProjectId($id)->count() > 0 ||
            $project->start_reg > $date || $project->end_reg < $date
        )
            $canBuy = false;

        if($canBuy && $project->capacity != -1) {
            $canBuy = (ProjectBuyers::whereProjectId($project->id)->count() < $project->capacity);
        }

        $capacity = ConfigModel::first()->project_limit;
        $nums = DB::select("select count(*) as countNum from project_buyers where status = false and user_id = " . Auth::user()->id)[0]->countNum;

        $reminder = $capacity - $nums;
        if($reminder <= 0 && $canBuy)
            $canBuy = false;

        return view('showProject', ['bookmark' => $bookmark, 'canBuy' => $canBuy,
            'project' => $project, 'like' => $like]);
    }



    public function showAllProducts() {

        $grade = Auth::user()->grade_id;

        $today = getToday()["date"];
        $products = DB::select('select p.id, name, description, price, star, project_id, ' .
            'concat(u.first_name, " ", u.last_name) as owner, p.created_at' .
            ' from product p, users u where ' .
            'p.user_id = u.id and u.grade_id = ' . $grade . ' and hide = false order by p.id desc');

        foreach ($products as $product) {

            $date = MiladyToShamsi('', explode('-', explode(' ', $product->created_at)[0]));
            $date = convertDateToString2($date, "-");

            $product->week = floor(($today - $date) / 7.0);

            $tmpPic = ProductPic::whereProductId($product->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $product->pic = URL::asset('productPic/defaultPic.jpg');
            else
                $product->pic = URL::asset('productPic/' . $tmpPic->name);

            if($product->price == 0)
                $product->price = "رایگان";
            else
                $product->price = number_format($product->price);

            $product->likes = Likes::whereItemId($product->id)->whereMode(getValueInfo('productMode'))->count();

            $product->tags = DB::select("select t.name, t.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $product->project_id);

            $str = "-";
            foreach ($product->tags as $tag)
                $str .= $tag->id . '-';

            $product->tagStr = $str;

            $product->canBuy = (Transaction::whereProductId($product->id)->count() == 0);
        }

        return view('products', ['products' => $products, 'tags' => Tag::all()]);

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

//        $bookmark = (Bookmark::whereUserId(Auth::user()->id)->whereItemId($id)->whereMode(getValueInfo('productMode'))->count() > 0);
        $bookmark = true;
        $like = (Likes::whereUserId(Auth::user()->id)->whereItemId($id)->whereMode(getValueInfo('productMode'))->count() > 0);

        $canBuy = true;

        if(Transaction::whereUserId(Auth::user()->id)->whereProductId($id)->count() > 0)
            $canBuy = false;

        return view('showProduct', ['bookmark' => $bookmark, 'canBuy' => $canBuy,
            'product' => $product, 'like' => $like]);
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

    public function bookmark() {

        if(isset($_POST["id"]) && isset($_POST["mode"])) {

            $item_id = makeValidInput($_POST["id"]);
            $mode = makeValidInput($_POST["mode"]);

            $uId = Auth::user()->id;

            $bookmark = Bookmark::whereItemId($item_id)->whereUserId($uId)->whereMode($mode)->first();
            if($bookmark == null) {
                $bookmark = new Bookmark();
                $bookmark->item_id = $item_id;
                $bookmark->user_id = $uId;
                $bookmark->mode = $mode;
                $bookmark->save();
                echo "ok";
                return;
            }
            else {
                $bookmark->delete();
                echo "nok";
            }
        }

    }

    public function like() {

        if(isset($_POST["id"]) && isset($_POST["mode"])) {

            $item_id = makeValidInput($_POST["id"]);
            $mode = makeValidInput($_POST["mode"]);

            $uId = Auth::user()->id;

            $like = Likes::whereItemId($item_id)->whereUserId($uId)->whereMode($mode)->first();
            if($like == null) {
                $like = new Likes();
                $like->item_id = $item_id;
                $like->user_id = $uId;
                $like->mode = $mode;
                $like->save();
                echo "ok";
                return;
            }
            else {
                $like->delete();
                echo "nok";
            }
        }

    }

    public function bookmarks($mode) {

        $items = Bookmark::whereUserId(Auth::user()->id)->whereMode($mode)->get();

        if($mode == getValueInfo('productMode')) {

            $out = [];

            foreach ($items as $product) {

                $product = Product::whereId($product->item_id);

                $tmpPic = ProductPic::whereProductId($product->id)->first();

                if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                    $product->pic = URL::asset('productPic/defaultPic.jpg');
                else
                    $product->pic = URL::asset('productPic/' . $tmpPic->name);

                if($product->price == 0)
                    $product->price = "رایگان";
                else
                    $product->price = number_format($product->price);

                $product->likes = Likes::whereItemId($product->id)->whereMode(getValueInfo('productMode'))->count();
                $out[count($out)] = $product;
            }

            return view('products', ['products' => $out]);

        }
        else {

            $out = [];

            foreach ($items as $project) {

                $project = Project::whereId($project->item_id);

                $tmpPic = ProjectPic::whereProjectId($project->id)->first();

                if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/projectPic/' . $tmpPic->name))
                    $project->pic = URL::asset('projectPic/defaultPic.jpg');
                else
                    $project->pic = URL::asset('projectPic/' . $tmpPic->name);

                if($project->price == 0)
                    $project->price = "رایگان";
                else
                    $project->price = number_format($project->price);

                $project->likes = Likes::whereItemId($project->id)->whereMode(getValueInfo('projectMode'))->count();
                $out[count($out)] = $project;
            }

            return view('projects', ['projects' => $out]);
        }

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
            $nums = DB::select("select count(*) as countNum from project_buyers where status = false and user_id = " . Auth::user()->id)[0]->countNum;

            $reminder = $capacity - $nums;
            if($reminder <= 0) {
                echo "nok6";
                return;
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

            if(Transaction::whereUserId($user->id)->whereProductId($product->id)->count() > 0) {
                echo "nok2";
                return;
            }

            $countBuys = Transaction::whereUserId($user->id)->count();
            if(ProjectBuyers::whereUserId($user->id)->whereStatus(true)->count() <= $countBuys) {
                echo "nok7";
                return;
            }

            if($product->price > $user->money) {
                echo "nok3";
                return;
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

}
