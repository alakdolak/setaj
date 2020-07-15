<?php

namespace App\Http\Controllers;

use App\models\Chat;
use App\models\Grade;
use App\models\Msg;
use App\models\Product;
use App\models\ProductAttach;
use App\models\ProductPic;
use App\models\ProductTag;
use App\models\ProductTrailer;
use App\models\Project;
use App\models\ProjectAttach;
use App\models\ProjectBuyers;
use App\models\ProjectGrade;
use App\models\ProjectPic;
use App\models\ProjectTag;
use App\models\Service;
use App\models\ServiceBuyer;
use App\models\ServiceGrade;
use App\models\ServicePic;
use App\models\ServiceTag;
use App\models\Tag;
use App\models\Transaction;
use App\models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use ZipArchive;

class OperatorController extends Controller {


    public function doneService() {

        if(isset($_POST["id"]) && isset($_POST["star"]) && isset($_POST["user_id"])) {

            $buyer = ServiceBuyer::whereServiceId(makeValidInput($_POST["id"]))->whereUserId(makeValidInput($_POST["user_id"]))->whereStatus(false)->first();

            if($buyer != null) {

                try {

                    $user = User::whereId($buyer->user_id);
                    $star = makeValidInput($_POST["star"]);

                    if($user != null) {
                        $buyer->star = $star;
                        $buyer->status = true;
                        $buyer->save();
                        $user->stars += $star;
                        $user->save();
                        echo "ok";
                        return;
                    }
                }
                catch (\Exception $x) {}
            }
        }

        echo "nok";
    }




    public function services() {

        $services = Service::orderBy('id', 'desc')->get();

        foreach ($services as $service) {

            $service->grades = DB::select("select s.id, g.name from service_grade s, grade g where s.grade_id = g.id and s.service_id = " . $service->id);
            $tmpPic = ServicePic::whereServiceId($service->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/servicePic/' . $tmpPic->name))
                $service->pic = URL::asset('servicePic/defaultPic.jpg');
            else
                $service->pic = URL::asset('servicePic/' . $tmpPic->name);

            $service->date = MiladyToShamsi('', explode('-', explode(' ', $service->created_at)[0]));

            $t = ServiceBuyer::whereServiceId($service->id)->get();

            $service->hide = (!$service->hide) ? "آشکار" : "مخفی";

            if($t == null)
                $service->buyers = null;
            else {

                $tmp = [];

                foreach ($t as $itr) {
                    $u = User::whereId($itr->user_id);
                    $tmp[count($tmp)] =
                        ["name" => $u->first_name . ' ' . $u->last_name,
                        "id" => $u->id,
                        "status" => $itr->status,
                        "star" => $itr->star];
                }

                $service->buyers = $tmp;
            }
        }

        return view('operator.services', ['services' => $services,
            'grades' => Grade::all()]);
    }

    public function products($err = -1) {

        $products = DB::select("select p.*, g.name as grade, g.id as grade_id, concat(u.first_name, ' ', u.last_name) as owner from product p, users u, grade g where p.user_id = u.id and u.grade_id = g.id order by p.id desc");

        foreach ($products as $product) {

            $tmpPic = ProductPic::whereProductId($product->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $product->pic = URL::asset('productPic/defaultPic.jpg');
            else
                $product->pic = URL::asset('productPic/' . $tmpPic->name);

            $product->date = MiladyToShamsi('', explode('-', explode(' ', $product->created_at)[0]));

            $t = Transaction::whereProductId($product->id)->select('user_id')->get();

            if($product->price == 0)
                $product->price = "رایگان";
            else
                $product->price = number_format($product->price);

            $product->hide = (!$product->hide) ? "آشکار" : "مخفی";

            if($t == null || count($t) == 0)
                $product->buyer = "هنوز خریداری نشده است.";
            else {
                $u = User::whereId($t[0]->user_id);
                $product->buyer = $u->first_name . ' ' . $u->last_name;
            }

        }

        return view('operator.products', ['products' => $products, 'grades' => Grade::all(),
            'err' => $err]);
    }

    public function projects() {

        $projects = Project::orderBy("id", "desc")->get();

        foreach ($projects as $project) {

            $project->grades = DB::select("select p.id, g.name from project_grade p, grade g where p.grade_id = g.id and p.project_id = " . $project->id);
            $tmpPic = ProjectPic::whereProjectId($project->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/projectPic/' . $tmpPic->name))
                $project->pic = URL::asset('projectPic/defaultPic.jpg');
            else
                $project->pic = URL::asset('projectPic/' . $tmpPic->name);

            $project->date = MiladyToShamsi('', explode('-', explode(' ', $project->created_at)[0]));

            $t = ProjectBuyers::whereProjectId($project->id)->select('user_id')->get();

            if($project->price == 0)
                $project->price = "رایگان";
            else
                $project->price = number_format($project->price);

            if($project->capacity == -1)
                $project->capacity = "بی نهایت";

            $project->startReg = convertStringToDate($project->start_reg);
            $project->endReg = convertStringToDate($project->end_reg);

            $project->hide = (!$project->hide) ? "آشکار" : "مخفی";

            $project->tags = DB::select("select t.name, p.id from tag t, project_tag p where t.id = p.tag_id and p.project_id = " . $project->id);

            if($t == null || count($t) == 0)
                $project->buyers = "هنوز خریداری نشده است.";
            else {

                $str = "";
                $first = true;

                foreach ($t as $itr) {
                    $u = User::whereId($itr->user_id);
                    if($first) {
                        $str .= $u->first_name . ' ' . $u->last_name;
                        $first = false;
                    }
                    else {
                        $str .= " - " . $u->first_name . ' ' . $u->last_name;
                    }
                }


                $project->buyers = $str;
            }

        }

        return view('operator.projects', ['projects' => $projects,
            'grades' => Grade::all(), 'tags' => Tag::all()]);
    }





    public function addTagProject() {

        if(isset($_POST["id"]) && isset($_POST["tagId"])) {

            $tmp = new ProjectTag();
            $tmp->project_id = makeValidInput($_POST["id"]);
            $tmp->tag_id = makeValidInput($_POST["tagId"]);
            try {
                $tmp->save();
                echo "ok";
                return;
            }
            catch (\Exception $x) {}
        }

        echo "nok";

    }

    public function deleteTagProject() {

        if(isset($_POST["id"])) {

            try {
                ProjectTag::destroy(makeValidInput($_POST["id"]));
                echo "ok";
                return;
            }
            catch (\Exception $x) {}
        }

        echo "nok";
    }



    public function addGradeService() {

        if(isset($_POST["id"]) && isset($_POST["gradeId"])) {

            $tmp = new ServiceGrade();
            $tmp->service_id = makeValidInput($_POST["id"]);
            $tmp->grade_id = makeValidInput($_POST["gradeId"]);
            try {
                $tmp->save();
                echo "ok";
                return;
            }
            catch (\Exception $x) {}
        }

        echo "nok";

    }

    public function deleteGradeService() {

        if(isset($_POST["id"])) {

            try {
                ServiceGrade::destroy(makeValidInput($_POST["id"]));
                echo "ok";
                return;
            }
            catch (\Exception $x) {}
        }

        echo "nok";
    }



    public function addGradeProject() {

        if(isset($_POST["id"]) && isset($_POST["gradeId"])) {

            $tmp = new ProjectGrade();
            $tmp->project_id = makeValidInput($_POST["id"]);
            $tmp->grade_id = makeValidInput($_POST["gradeId"]);
            try {
                $tmp->save();
                echo "ok";
                return;
            }
            catch (\Exception $x) {}
        }

        echo "nok";

    }

    public function deleteGradeProject() {

        if(isset($_POST["id"])) {

            try {
                ProjectGrade::destroy(makeValidInput($_POST["id"]));
                echo "ok";
                return;
            }
            catch (\Exception $x) {}
        }

        echo "nok";
    }




    public function chats() {

        DB::delete("delete from chat where created_at < DATE_SUB(NOW(), INTERVAL 6 HOUR)");

        $chats = DB::select("select m.chat_id as id, concat(u.first_name, ' ', u.last_name) as name, count(*) as countNum from chat c, users u, msg m where "
            . " c.created_at > DATE_SUB(NOW(), INTERVAL 6 HOUR) and c.user_id = u.id and c.id = chat_id group by(m.chat_id) having countNum > 0");

        return view("chats", ["chats" => $chats]);
    }

    public function msgs($chatId) {

        $msgs = Msg::whereChatId($chatId)->get();
        DB::update("update msg set seen = true where chat_id = " . $chatId);


        foreach ($msgs as $msg) {
            $timestamp = strtotime($msg->created_at);
            $msg->time = MiladyToShamsiTime($timestamp);

            $timestamp = strtotime($msg->created_at);
            $msg->time = MiladyToShamsiTime($timestamp);
        }

        return view("msgs", ['msgs' => $msgs, 'chatId' => $chatId]);
    }

    public function sendRes() {

        if(isset($_POST["msg"]) && isset($_POST["chatId"])) {

            $chat = Chat::whereId(makeValidInput($_POST["chatId"]));
            if($chat == null) {
                echo json_encode(["status" => "nok"]);
                return;
            }

            $msg = new Msg();
            $msg->text = makeValidInput($_POST["msg"]);
            $msg->chat_id = $chat->id;
            $msg->is_me = false;
            $msg->seen = true;
            try {
                $msg->save();
                echo json_encode(["status" => "ok", "sendTime" => convertStringToTime(getToday()["time"])]);
                return;
            }
            catch (\Exception $x) {
                dd($x);
            }

        }

        echo json_encode(["status" => "nok"]);

    }





    public function addService() {

        if(isset($_POST["name"]) && isset($_POST["description"])
            && isset($_POST["star"]) && isset($_POST["gradeId"]) && isset($_POST["capacity"])
        ) {

            $service = new Service();
            $service->title = makeValidInput($_POST["name"]);
            $service->description = $_POST["description"];
            $service->star = makeValidInput($_POST["star"]);
            $service->capacity = makeValidInput($_POST["capacity"]);

            try {

                $service->save();

                $gradeId = makeValidInput($_POST["gradeId"]);

                $tmp = new ServiceGrade();
                $tmp->grade_id = $gradeId;
                $tmp->service_id = $service->id;
                $tmp->save();

                if(isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {

                    $file = Input::file('file');
                    $Image = time() . '_' . $file->getClientOriginalName();
                    $destenationpath = public_path() . '/tmp';
                    $file->move($destenationpath, $Image);

                    $zip = new ZipArchive;
                    $res = $zip->open($destenationpath . '/' . $Image);

                    if ($res === TRUE) {
                        $folder = time();
                        mkdir($destenationpath . '/' . $folder);
                        $zip->extractTo($destenationpath . '/' . $folder);
                        $zip->close();

                        $dir = $destenationpath . '/' . $folder;
                        $q = scandir($dir);
                        $q = array_diff($q, array('.', '..'));
                        natsort($q);

                        $vals = [];
                        foreach ($q as $itr)
                            $vals[count($vals)] = $itr;

                        $newDest = __DIR__ . '/../../../public/servicePic/';

                        foreach ($vals as $val) {
                            $tmp = new ServicePic();
                            $tmp->service_id = $service->id;
                            $tmp->name = time() . $val;
                            $tmp->save();
                            rename($destenationpath . '/' . $folder . '/' . $val,
                                $newDest . $tmp->name);
                        }

                        rrmdir($destenationpath . '/' . $folder);
                        unlink($destenationpath . '/' . $Image);

                    }
                }
            }
            catch (\Exception $x) {
                dd($x);
            }

        }

        return Redirect::route('services');
    }

    public function addProject() {

        if(isset($_POST["name"]) && isset($_POST["description"])
            && isset($_POST["price"]) && isset($_POST["gradeId"]) && isset($_POST["capacity"])
            && isset($_POST["start_reg"]) && isset($_POST["end_reg"])
        ) {

            $project = new Project();
            $project->title = makeValidInput($_POST["name"]);
            $project->description = $_POST["description"];
            $project->capacity = makeValidInput($_POST["capacity"]);
            $project->price = makeValidInput($_POST["price"]);
            $project->start_reg = convertDateToString(makeValidInput($_POST["start_reg"]));
            $project->end_reg = convertDateToString(makeValidInput($_POST["end_reg"]));

            try {

                $project->save();

                $gradeId = makeValidInput($_POST["gradeId"]);
                $tmp = new ProjectGrade();
                $tmp->grade_id = $gradeId;
                $tmp->project_id = $project->id;
                $tmp->save();


                if(isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {

                    $file = Input::file('file');
                    $Image = time() . '_' . $file->getClientOriginalName();
                    $destenationpath = public_path() . '/tmp';
                    $file->move($destenationpath, $Image);

                    $zip = new ZipArchive;
                    $res = $zip->open($destenationpath . '/' . $Image);

                    if ($res === TRUE) {
                        $folder = time();
                        mkdir($destenationpath . '/' . $folder);
                        $zip->extractTo($destenationpath . '/' . $folder);
                        $zip->close();

                        $dir = $destenationpath . '/' . $folder;
                        $q = scandir($dir);
                        $q = array_diff($q, array('.', '..'));
                        natsort($q);

                        $vals = [];
                        foreach ($q as $itr)
                            $vals[count($vals)] = $itr;

                        $newDest = __DIR__ . '/../../../public/projectPic/';

                        foreach ($vals as $val) {
                            $tmp = new ProjectPic();
                            $tmp->project_id = $project->id;
                            $tmp->name = time() . $val;
                            $tmp->save();
                            rename($destenationpath . '/' . $folder . '/' . $val,
                                $newDest . $tmp->name);
                        }

                        rrmdir($destenationpath . '/' . $folder);
                        unlink($destenationpath . '/' . $Image);

                    }
                }

                if(isset($_FILES["attach"]) && !empty($_FILES["attach"]["name"])) {

                    $file = Input::file('attach');
                    $Image = time() . '_' . $file->getClientOriginalName();
                    $destenationpath = public_path() . '/tmp';
                    $file->move($destenationpath, $Image);

                    $zip = new ZipArchive;
                    $res = $zip->open($destenationpath . '/' . $Image);

                    if ($res === TRUE) {
                        $folder = time();
                        mkdir($destenationpath . '/' . $folder);
                        $zip->extractTo($destenationpath . '/' . $folder);
                        $zip->close();

                        $dir = $destenationpath . '/' . $folder;
                        $q = scandir($dir);
                        $q = array_diff($q, array('.', '..'));
                        natsort($q);

                        $vals = [];
                        foreach ($q as $itr)
                            $vals[count($vals)] = $itr;

                        $newDest = __DIR__ . '/../../../public/projectPic/';

                        foreach ($vals as $val) {
                            $tmp = new ProjectAttach();
                            $tmp->project_id = $project->id;
                            $tmp->name = time() . $val;
                            $tmp->save();
                            rename($destenationpath . '/' . $folder . '/' . $val,
                                $newDest . $tmp->name);
                        }

                        rrmdir($destenationpath . '/' . $folder);
                        unlink($destenationpath . '/' . $Image);

                    }
                }
            }
            catch (\Exception $x) {
                dd($x);
            }

        }

        return Redirect::route('projects');
    }

    public function addProduct() {

        if(isset($_POST["name"]) && isset($_POST["description"])
            && isset($_POST["price"]) && isset($_POST["project"])
            && isset($_POST["star"]) && isset($_POST["username"])
        ) {

            $username = makeValidInput($_POST["username"]);

            $user = DB::select("select id from users where nid = " . $username . ' or username = ' . $username);

            if($user == null || count($user) == 0) {
                return Redirect::route('products', ['err' => 1]);
            }

            $project = makeValidInput($_POST["project"]);
            $p = ProjectBuyers::whereUserId($user[0]->id)->whereProjectId($project)->first();

            if($p == null)
                return Redirect::route('products', ['err' => 1]);

            $p->status = 1;
            $p->save();

            $product = new Product();
            $product->name = makeValidInput($_POST["name"]);
            $product->description = $_POST["description"];
            $product->price = makeValidInput($_POST["price"]);
            $product->star = makeValidInput($_POST["star"]);
            $product->user_id = $user[0]->id;
            $product->project_id = $project;

            try {

                $product->save();

                if(isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {

                    $file = Input::file('file');
                    $Image = time() . '_' . $file->getClientOriginalName();
                    $destenationpath = public_path() . '/tmp';
                    $file->move($destenationpath, $Image);

                    $zip = new ZipArchive;
                    $res = $zip->open($destenationpath . '/' . $Image);

                    if ($res === TRUE) {
                        $folder = time();
                        mkdir($destenationpath . '/' . $folder);
                        $zip->extractTo($destenationpath . '/' . $folder);
                        $zip->close();

                        $dir = $destenationpath . '/' . $folder;
                        $q = scandir($dir);
                        $q = array_diff($q, array('.', '..'));
                        natsort($q);

                        $vals = [];
                        foreach ($q as $itr)
                            $vals[count($vals)] = $itr;

                        $newDest = __DIR__ . '/../../../public/productPic/';

                        foreach ($vals as $val) {
                            $tmp = new ProductPic();
                            $tmp->product_id = $product->id;
                            $tmp->name = time() . $val;
                            $tmp->save();
                            rename($destenationpath . '/' . $folder . '/' . $val,
                                $newDest . $tmp->name);
                        }

                        rrmdir($destenationpath . '/' . $folder);
                        unlink($destenationpath . '/' . $Image);

                    }
                }

                if(isset($_FILES["attach"]) && !empty($_FILES["attach"]["name"])) {

                    $file = Input::file('attach');
                    $Image = time() . '_' . $file->getClientOriginalName();
                    $destenationpath = public_path() . '/tmp';
                    $file->move($destenationpath, $Image);

                    $zip = new ZipArchive;
                    $res = $zip->open($destenationpath . '/' . $Image);

                    if ($res === TRUE) {
                        $folder = time();
                        mkdir($destenationpath . '/' . $folder);
                        $zip->extractTo($destenationpath . '/' . $folder);
                        $zip->close();

                        $dir = $destenationpath . '/' . $folder;
                        $q = scandir($dir);
                        $q = array_diff($q, array('.', '..'));
                        natsort($q);

                        $vals = [];
                        foreach ($q as $itr)
                            $vals[count($vals)] = $itr;

                        $newDest = __DIR__ . '/../../../public/productPic/';

                        foreach ($vals as $val) {
                            $tmp = new ProductAttach();
                            $tmp->product_id = $product->id;
                            $tmp->name = time() . $val;
                            $tmp->save();
                            rename($destenationpath . '/' . $folder . '/' . $val,
                                $newDest . $tmp->name);
                        }

                        rrmdir($destenationpath . '/' . $folder);
                        unlink($destenationpath . '/' . $Image);

                    }
                }

                if(isset($_FILES["trailer"]) && !empty($_FILES["trailer"]["name"])) {

                    $file = Input::file('trailer');
                    $Image = time() . '_' . $file->getClientOriginalName();
                    $destenationpath = public_path() . '/tmp';
                    $file->move($destenationpath, $Image);

                    $zip = new ZipArchive;
                    $res = $zip->open($destenationpath . '/' . $Image);

                    if ($res === TRUE) {
                        $folder = time();
                        mkdir($destenationpath . '/' . $folder);
                        $zip->extractTo($destenationpath . '/' . $folder);
                        $zip->close();

                        $dir = $destenationpath . '/' . $folder;
                        $q = scandir($dir);
                        $q = array_diff($q, array('.', '..'));
                        natsort($q);

                        $vals = [];
                        foreach ($q as $itr)
                            $vals[count($vals)] = $itr;

                        $newDest = __DIR__ . '/../../../public/productPic/';

                        foreach ($vals as $val) {
                            $tmp = new ProductTrailer();
                            $tmp->product_id = $product->id;
                            $tmp->name = time() . $val;
                            $tmp->save();
                            rename($destenationpath . '/' . $folder . '/' . $val,
                                $newDest . $tmp->name);
                        }

                        rrmdir($destenationpath . '/' . $folder);
                        unlink($destenationpath . '/' . $Image);

                    }
                }
            }
            catch (\Exception $x) {
                dd($x);
            }

        }

        return Redirect::route('products');
    }



    public function toggleHideProject() {

        if(isset($_POST["id"])) {

            $p = Project::whereId(makeValidInput($_POST["id"]));
            if($p != null) {
                $p->hide = !$p->hide;
                try {
                    $p->save();
                    echo "ok";
                    return;
                }
                catch (\Exception $x) {}
            }
        }

        echo "nok";
    }

    public function toggleHideProduct() {

        if(isset($_POST["id"])) {

            $p = Product::whereId(makeValidInput($_POST["id"]));
            if($p != null) {
                $p->hide = !$p->hide;
                try {
                    $p->save();
                    echo "ok";
                    return;
                }
                catch (\Exception $x) {}
            }
        }

        echo "nok";
    }

    public function toggleHideService() {

        if(isset($_POST["id"])) {

            $p = Service::whereId(makeValidInput($_POST["id"]));
            if($p != null) {
                $p->hide = !$p->hide;
                try {
                    $p->save();
                    echo "ok";
                    return;
                }
                catch (\Exception $x) {}
            }
        }

        echo "nok";
    }



    public function deleteProject() {

        if(isset($_POST["id"])) {

            $p = Project::whereId(makeValidInput($_POST["id"]));

            if($p != null) {

                $pics = ProjectPic::whereProjectId($p->id)->get();
                foreach ($pics as $pic) {
                    if (file_exists(__DIR__ . '/../../../public/projectPic/' . $pic->name))
                        unlink(__DIR__ . '/../../../public/projectPic/' . $pic->name);
                }

                $pics = ProjectAttach::whereProjectId($p->id)->get();
                foreach ($pics as $pic) {
                    if (file_exists(__DIR__ . '/../../../public/projectPic/' . $pic->name))
                        unlink(__DIR__ . '/../../../public/projectPic/' . $pic->name);
                }

                try {
                    $p->delete();
                    echo "ok";
                    return;
                }
                catch (\Exception $x) {
                    dd($x);
                }
            }
        }

        echo "nok";
    }

    public function deleteProduct() {

        if(isset($_POST["id"])) {

            $p = Product::whereId(makeValidInput($_POST["id"]));

            if($p != null) {

                $pics = ProductPic::whereProductId($p->id)->get();

                foreach ($pics as $pic) {
                    if (file_exists(__DIR__ . '/../../../public/productPic/' . $pic->name))
                        unlink(__DIR__ . '/../../../public/productPic/' . $pic->name);
                }

                $pics = ProductAttach::whereProductId($p->id)->get();

                foreach ($pics as $pic) {
                    if (file_exists(__DIR__ . '/../../../public/productPic/' . $pic->name))
                        unlink(__DIR__ . '/../../../public/productPic/' . $pic->name);
                }

                $pics = ProductTrailer::whereProductId($p->id)->get();

                foreach ($pics as $pic) {
                    if (file_exists(__DIR__ . '/../../../public/productPic/' . $pic->name))
                        unlink(__DIR__ . '/../../../public/productPic/' . $pic->name);
                }

                try {
                    $p->delete();
                    echo "ok";
                    return;
                }
                catch (\Exception $x) {
                    dd($x);
                }
            }
        }
    }

    public function deleteService() {

        if(isset($_POST["id"])) {

            $p = Service::whereId(makeValidInput($_POST["id"]));

            if($p != null) {

                $pics = ServicePic::whereServiceId($p->id)->get();

                foreach ($pics as $pic) {
                    if (file_exists(__DIR__ . '/../../../public/servicePic/' . $pic->name))
                        unlink(__DIR__ . '/../../../public/servicePic/' . $pic->name);
                }

                try {
                    $p->delete();
                    echo "ok";
                    return;
                }
                catch (\Exception $x) {
                    dd($x);
                }
            }
        }
    }




    public function getOpenProject() {

        if(isset($_POST["username"])) {

            $username = makeValidInput($_POST["username"]);

            $user = DB::select("select id from users where username = " . $username . ' or nid = ' . $username);

            if($user == null || count($user) == 0) {
                echo json_encode([]);
                return;
            }

            $user = $user[0];

            $projects = DB::select("select p.id, p.title from project p, project_buyers b where p.id = b.project_id and b.status = false and b.user_id = " . $user->id);
            echo json_encode($projects);
        }

    }
}
