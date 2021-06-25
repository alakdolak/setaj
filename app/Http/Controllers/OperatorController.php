<?php

namespace App\Http\Controllers;

use App\models\Chat;
use App\models\Citizen;
use App\models\CitizenAttach;
use App\models\CitizenBuyers;
use App\models\CitizenGrade;
use App\models\CitizenPic;
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
use App\models\ServiceAttach;
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

    public function setFileStatus() {

        if(isset($_POST["pbId"]) && isset($_POST["status"])) {

            $pb = ProjectBuyers::whereId(makeValidInput($_POST["pbId"]));
            if($pb == null)
                return "nok";

            $status = makeValidInput($_POST["status"]);
            if($status != -1 && $status != 1)
                return "nok";

            $pb->file_status = $status;
            if($status == -1) {
                if(file_exists(__DIR__ . '/../../../public/storage/contents/' . $pb->file))
                    unlink(__DIR__ . '/../../../public/storage/contents/' . $pb->file);

                $pb->file = null;
            }

            $pb->save();
            return "ok";
        }

        return "nok";
    }

    public function setAdvStatus() {

        if(isset($_POST["pbId"]) && isset($_POST["status"])) {

            $pb = ProjectBuyers::whereId(makeValidInput($_POST["pbId"]));
            if($pb == null)
                return "nok";

            $status = makeValidInput($_POST["status"]);
            if($status != -1 && $status != 1)
                return "nok";

            $pb->adv_status = $status;
            if($status == -1) {
                if(file_exists(__DIR__ . '/../../../public/storage/advs/' . $pb->adv))
                    unlink(__DIR__ . '/../../../public/storage/advs/' . $pb->adv);

                $pb->adv = null;
            }

            $pb->save();
            return "ok";
        }

        return "nok";
    }

    public function services() {

        $services = Service::orderBy('id', 'desc')->get();

        foreach ($services as $service) {

            $service->grades = DB::select("select s.id, g.name from service_grade s, grade g where s.grade_id = g.id and s.service_id = " . $service->id);
            $tmpPic = ServicePic::whereServiceId($service->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/servicePic/' . $tmpPic->name))
                $service->pic = URL::asset('servicePic/defaultPic.png');
            else
                $service->pic = URL::asset('servicePic/' . $tmpPic->name);

            $service->hide = (!$service->hide) ? "آشکار" : "مخفی";
            $service->date = MiladyToShamsi('', explode('-', explode(' ', $service->created_at)[0]));
        }

        return view('operator.services', ['services' => $services,
            'grades' => Grade::all()]);
    }

    public function products($err = -1) {

        $products = DB::select("select pb.adv, pb.adv_status, pb.file, pb.file_status, p.*, g.name as grade, g.id as grade_id, concat(u.first_name, ' ', u.last_name) as owner from product p, users u, grade g, project_buyers pb where p.project_id = pb.project_id and pb.user_id = p.user_id and p.user_id = u.id and u.grade_id = g.id order by p.id desc");

        foreach ($products as $product) {

            if($product->adv_status && $product->adv != null &&
                file_exists(__DIR__ . '/../../../storage/app/public/advs/' . $product->adv))
                $product->adv = URL::asset("storage/adv/" . $product->adv);
            else
                $product->adv = null;

            $tmpPic = ProductPic::whereProductId($product->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/productPic/' . $tmpPic->name))
                $product->pic = URL::asset('productPic/defaultPic.png');
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

    public function healthReport($gradeId = -1) {

        if($gradeId == -1)
            return view('operator.chooseGradeHealth');

        $tags = Tag::whereType("CITIZEN")->get();
        $users = User::select(["id", "first_name", "last_name"])->whereGradeId($gradeId)->get();
        $first = true;
        $usersOut = [];

        $tmpArr = [];
        foreach ($tags as $tag) {
            $tmpArr[$tag->name] = 0;
        }


        foreach ($tags as $tag) {

            $points = DB::select("select b.user_id, sum(b.point) as point from citizen_buyers b, citizen c, users u where u.id = b.user_id and u.grade_id = " . $gradeId . " and b.project_id = c.id and c.tag_id = " . $tag->id . " group by(b.user_id)");
            $idx = 0;

            foreach ($users as $user) {

                if($first) {
                    $usersOut[$idx] = [
                        "name" => $user->first_name . " " . $user->last_name,
                        "points" => $tmpArr
                    ];
                }

                foreach ($points as $point) {
                    if($point->user_id == $user->id) {
                        $usersOut[$idx]["points"][$tag->name] = $point->point;
                        break;
                    }
                }

                $idx++;
            }

            $first = false;
        }

        return view('report.health', ['points' => $usersOut, 'tags' => $tags]);
    }

    public function citizensReport() {

        $items = DB::select("select b.created_at, b.description, b.point, c.id as cId, c.title, c.point as totalPoint, " .
            "b.id, g.name as grade, t.name as tag, g.id as gradeId, concat(u.first_name, ' ', u.last_name) as owner ".
            "from citizen_buyers b, tag t, citizen c, users u, grade g where c.id = b.project_id " .
            "and t.id = c.tag_id and b.user_id = u.id and u.grade_id = g.id order by b.id desc");

        foreach ($items as $item)
            $item->date = MiladyToShamsi('', explode('-', explode(' ', $item->created_at)[0]));

        return view('operator.citizensReport', ['items' => $items, 'grades' => Grade::all(),
            "all" => Citizen::select('id', 'title')->get()]);
    }

    public function changePoint() {

        if(isset($_POST["point"]) && isset($_POST["id"])) {

            DB::update("update citizen_buyers set point = " . makeValidInput($_POST["point"]) .
                " where id = " . makeValidInput($_POST["id"]));

            return "ok";
        }

        return "nok";
    }

    public function projects() {

        $projects = Project::orderBy("id", "desc")->get();

        foreach ($projects as $project) {

            $project->grades = DB::select("select p.id, g.name from project_grade p, grade g where p.grade_id = g.id and p.project_id = " . $project->id);
            $tmpPic = ProjectPic::whereProjectId($project->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/projectPic/' . $tmpPic->name))
                $project->pic = URL::asset('projectPic/defaultPic.png');
            else
                $project->pic = URL::asset('projectPic/' . $tmpPic->name);

            $project->date = MiladyToShamsi('', explode('-', explode(' ', $project->created_at)[0]));

            $project->buyers = ProjectBuyers::whereProjectId($project->id)->count();

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

        }

        return view('operator.projects', ['projects' => $projects,
            'grades' => Grade::all(), 'tags' => Tag::all()]);
    }

    public function citizens() {

        $projects = Citizen::orderBy("id", "desc")->get();

        foreach ($projects as $project) {

            $project->grades = DB::select("select p.id, g.name from citizen_grade p, grade g where p.grade_id = g.id and p.project_id = " . $project->id);
            $tmpPic = CitizenPic::whereProjectId($project->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/citizenPic/' . $tmpPic->name))
                $project->pic = URL::asset('citizenPic/defaultPic.png');
            else
                $project->pic = URL::asset('citizenPic/' . $tmpPic->name);

            $project->date = MiladyToShamsi('', explode('-', explode(' ', $project->created_at)[0]));
            $project->buyers = CitizenBuyers::whereProjectId($project->id)->count();

            $project->startReg = convertStringToDate($project->start_reg);
            $project->endReg = convertStringToDate($project->end_reg);

            $project->hide = (!$project->hide) ? "آشکار" : "مخفی";
            $project->tag = Tag::whereId($project->tag_id)->name;
        }

        return view('operator.citizens', ['projects' => $projects,
            'grades' => Grade::all(), 'tags' => Tag::whereType("CITIZEN")->get()]);
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



    public function addGradeCitizen() {

        if(isset($_POST["id"]) && isset($_POST["gradeId"])) {

            $tmp = new CitizenGrade();
            $tmp->project_id = makeValidInput($_POST["id"]);
            $tmp->grade_id = makeValidInput($_POST["gradeId"]);
            try {
                $tmp->save();
                return "ok";
            }
            catch (\Exception $x) {}
        }

        return "nok";
    }

    public function deleteGradeCitizen() {

        if(isset($_POST["id"])) {

            try {
                CitizenGrade::destroy(makeValidInput($_POST["id"]));
                return "ok";
            }
            catch (\Exception $x) {}
        }

        return "nok";
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

                        $newDest = __DIR__ . '/../../../public/servicePic/';

                        foreach ($vals as $val) {
                            $tmp = new ServiceAttach();
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
            $project->physical = (isset($_POST["physical"]));
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

            $project = Project::whereId(makeValidInput($_POST["project"]));
            if($project == null)
                return Redirect::route('products', ['err' => 1]);

            $username = makeValidInput($_POST["username"]);
            $user = DB::select("select id from users where nid = " . $username . ' or username = ' . $username);

            if($user == null || count($user) == 0)
                return Redirect::route('products', ['err' => 1]);

            DB::update("update project_buyers set status = true where user_id = " . $user[0]->id . " and project_id = " . $project->id);

            $product = new Product();
            $product->name = makeValidInput($_POST["name"]);
            $product->description = $_POST["description"];
            $product->price = makeValidInput($_POST["price"]);
            $product->star = makeValidInput($_POST["star"]);
            $product->user_id = $user[0]->id;
            $product->project_id = $project->id;
            $product->physical = $project->physical;

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

    public function addCitizen() {

        if(isset($_POST["name"]) && isset($_POST["description"])
            && isset($_POST["point"]) && isset($_POST["gradeId"])
            && isset($_POST["start_reg"]) && isset($_POST["end_reg"])
            && isset($_POST["tagId"])
        ) {

            $project = new Citizen();
            $project->title = makeValidInput($_POST["name"]);
            $project->description = $_POST["description"];
            $project->point = makeValidInput($_POST["point"]);
            $project->start_reg = convertDateToString(makeValidInput($_POST["start_reg"]));
            $project->end_reg = convertDateToString(makeValidInput($_POST["end_reg"]));
            $project->tag_id = makeValidInput($_POST["tagId"]);

            try {

                $project->save();

                $gradeId = makeValidInput($_POST["gradeId"]);
                $tmp = new CitizenGrade();
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

                        $newDest = __DIR__ . '/../../../public/citizenPic/';

                        foreach ($vals as $val) {
                            $tmp = new CitizenPic();
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

                        $newDest = __DIR__ . '/../../../public/citizenPic/';

                        foreach ($vals as $val) {
                            $tmp = new CitizenAttach();
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

        return Redirect::route('citizens');
    }




    public function toggleHideProject() {

        if(isset($_POST["id"])) {
            DB::update("update project set hide = not hide where id = " . makeValidInput($_POST["id"]));
            return "ok";
        }

        return "nok";
    }

    public function toggleHideCitizen() {

        if(isset($_POST["id"])) {
            DB::update("update citizen set hide = not hide where id = " . makeValidInput($_POST["id"]));
            return "ok";
        }

        return "nok";
    }

    public function toggleHideProduct() {

        if(isset($_POST["id"])) {
            DB::update("update product set hide = not hide where id = " . makeValidInput($_POST["id"]));
            return "ok";
        }

        return "nok";
    }

    public function toggleHideService() {
        if(isset($_POST["id"])) {
            DB::update("update service set hide = not hide where id = " . makeValidInput($_POST["id"]));
            return "ok";
        }

        return "nok";
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

    public function deleteCitizen() {

        if(isset($_POST["id"])) {

            $p = Citizen::whereId(makeValidInput($_POST["id"]));

            if($p != null) {

                $pics = CitizenPic::whereProjectId($p->id)->get();
                foreach ($pics as $pic) {
                    if (file_exists(__DIR__ . '/../../../public/citizenPic/' . $pic->name))
                        unlink(__DIR__ . '/../../../public/citizenPic/' . $pic->name);
                }

                $pics = CitizenAttach::whereProjectId($p->id)->get();
                foreach ($pics as $pic) {
                    if (file_exists(__DIR__ . '/../../../public/citizenPic/' . $pic->name))
                        unlink(__DIR__ . '/../../../public/citizenPic/' . $pic->name);
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

                $pics = ServiceAttach::whereServiceId($p->id)->get();

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



    public function editProject($id) {

        $project = Project::whereId($id);

        if($project == null)
            return Redirect::route('admin');

        $project->start_reg = convertStringToDate($project->start_reg);
        $project->end_reg = convertStringToDate($project->end_reg);

        return view('operator.editProject', ['project' => $project]);
    }

    public function doEditProject($id) {

        $project = Project::whereId($id);

        if($project == null)
            return Redirect::route('admin');


        if(isset($_POST["name"]) && isset($_POST["description"])
            && isset($_POST["price"]) && isset($_POST["capacity"])
            && isset($_POST["start_reg"]) && isset($_POST["end_reg"])
        ) {

            $project->title = makeValidInput($_POST["name"]);
            $project->description = $_POST["description"];
            $project->capacity = makeValidInput($_POST["capacity"]);
            $project->price = makeValidInput($_POST["price"]);
            $project->start_reg = convertDateToString(makeValidInput($_POST["start_reg"]));
            $project->end_reg = convertDateToString(makeValidInput($_POST["end_reg"]));

            try {

                $project->save();

                if(isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {


                    $pics = ProjectPic::whereProjectId($project->id)->get();
                    foreach ($pics as $pic) {

                        if (file_exists(__DIR__ . '/../../../public/projectPic/' . $pic->name))
                            unlink(__DIR__ . '/../../../public/projectPic/' . $pic->name);

                        $pic->delete();
                    }

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

                    $pics = ProjectAttach::whereProjectId($project->id)->get();
                    foreach ($pics as $pic) {

                        if (file_exists(__DIR__ . '/../../../public/projectPic/' . $pic->name))
                            unlink(__DIR__ . '/../../../public/projectPic/' . $pic->name);

                        $pic->delete();
                    }


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



    public function editCitizen($id) {

        $project = Citizen::whereId($id);

        if($project == null)
            return Redirect::route('admin');

        $project->start_reg = convertStringToDate($project->start_reg);
        $project->end_reg = convertStringToDate($project->end_reg);

        return view('operator.editCitizen', ['project' => $project]);
    }

    public function doEditCitizen($id) {

        $project = Citizen::whereId($id);

        if($project == null)
            return Redirect::route('admin');


        if(isset($_POST["name"]) && isset($_POST["description"])
            && isset($_POST["point"])
            && isset($_POST["start_reg"]) && isset($_POST["end_reg"])
        ) {

            $project->title = makeValidInput($_POST["name"]);
            $project->description = $_POST["description"];
            $project->point = makeValidInput($_POST["point"]);
            $project->start_reg = convertDateToString(makeValidInput($_POST["start_reg"]));
            $project->end_reg = convertDateToString(makeValidInput($_POST["end_reg"]));

            try {

                $project->save();

                if(isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {


                    $pics = CitizenPic::whereProjectId($project->id)->get();
                    foreach ($pics as $pic) {

                        if (file_exists(__DIR__ . '/../../../public/citizenPic/' . $pic->name))
                            unlink(__DIR__ . '/../../../public/citizenPic/' . $pic->name);

                        $pic->delete();
                    }

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

                        $newDest = __DIR__ . '/../../../public/citizenPic/';

                        foreach ($vals as $val) {
                            $tmp = new CitizenPic();
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

                    $pics = CitizenAttach::whereProjectId($project->id)->get();
                    foreach ($pics as $pic) {

                        if (file_exists(__DIR__ . '/../../../public/citizenPic/' . $pic->name))
                            unlink(__DIR__ . '/../../../public/citizenPic/' . $pic->name);

                        $pic->delete();
                    }


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

                        $newDest = __DIR__ . '/../../../public/citizenPic/';

                        foreach ($vals as $val) {
                            $tmp = new CitizenAttach();
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

        return Redirect::route('citizens');
    }



    public function editService($id) {

        $service = Service::whereId($id);

        if($service == null)
            return Redirect::route('admin');

        return view('operator.editService', ['service' => $service]);
    }

    public function doEditService($id) {

        if(isset($_POST["name"]) && isset($_POST["description"])
            && isset($_POST["star"]) && isset($_POST["capacity"])
        ) {

            $service = Service::whereId($id);

            if($service == null)
                return Redirect::route('admin');

            $service->title = makeValidInput($_POST["name"]);
            $service->description = $_POST["description"];
            $service->star = makeValidInput($_POST["star"]);
            $service->capacity = makeValidInput($_POST["capacity"]);

            try {

                $service->save();

                if(isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {

                    $pics = ServicePic::whereServiceId($service->id)->get();

                    foreach ($pics as $pic) {
                        if (file_exists(__DIR__ . '/../../../public/servicePic/' . $pic->name))
                            unlink(__DIR__ . '/../../../public/servicePic/' . $pic->name);
                        $pic->delete();
                    }

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


                if(isset($_FILES["attach"]) && !empty($_FILES["attach"]["name"])) {

                    $pics = ServiceAttach::whereServiceId($service->id)->get();

                    foreach ($pics as $pic) {
                        if (file_exists(__DIR__ . '/../../../public/servicePic/' . $pic->name))
                            unlink(__DIR__ . '/../../../public/servicePic/' . $pic->name);
                        $pic->delete();
                    }

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

                        $newDest = __DIR__ . '/../../../public/servicePic/';

                        foreach ($vals as $val) {
                            $tmp = new ServiceAttach();
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

        return Redirect::route("services");

    }


    public function editProduct($id) {

        $product = Product::whereId($id);

        if($product == null)
            return Redirect::route('admin');

        return view('operator.editProduct', ['product' => $product]);

    }

    public function doEditProduct($id) {

        if(isset($_POST["name"]) && isset($_POST["description"])
            && isset($_POST["price"]) && isset($_POST["star"])
        ) {

            $product = Product::whereId($id);

            if($product == null) {
                return Redirect::route("admin");
            }

            $product->name = makeValidInput($_POST["name"]);
            $product->description = $_POST["description"];
            $product->price = makeValidInput($_POST["price"]);
            $product->star = makeValidInput($_POST["star"]);

            try {

                $product->save();

                if(isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {

                    $pics = ProductPic::whereProductId($product->id)->get();

                    foreach ($pics as $pic) {
                        if (file_exists(__DIR__ . '/../../../public/productPic/' . $pic->name))
                            unlink(__DIR__ . '/../../../public/productPic/' . $pic->name);
                        $pic->delete();
                    }

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

                    $pics = ProductAttach::whereProductId($product->id)->get();

                    foreach ($pics as $pic) {
                        if (file_exists(__DIR__ . '/../../../public/productPic/' . $pic->name))
                            unlink(__DIR__ . '/../../../public/productPic/' . $pic->name);
                        $pic->delete();
                    }

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

                    $pics = ProductTrailer::whereProductId($product->id)->get();

                    foreach ($pics as $pic) {
                        if (file_exists(__DIR__ . '/../../../public/productPic/' . $pic->name))
                            unlink(__DIR__ . '/../../../public/productPic/' . $pic->name);
                        $pic->delete();
                    }

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


    public function assignProjectToUser() {


        if(isset($_POST["projectId"]) && isset($_POST["userId"])) {

            $pId = makeValidInput($_POST["projectId"]);
            $uId = makeValidInput($_POST["userId"]);

            if(ProjectBuyers::whereUserId($uId)->whereProjectId($pId)->count() > 0) {
                echo "nok2";
                return;
            }

            $project = Project::whereId($pId);

            if($project == null) {
                echo "nok3";
                return;
            }

            $user = User::whereId($uId);

            if($user == null) {
                echo "nok3";
                return;
            }

            if($project->price > $user->money) {
                echo "nok4";
                return;
            }


            if($project->capacity != -1 &&
                ProjectBuyers::whereProjectId($project->id)->count() >= $project->capacity) {
                echo "nok5";
                return;
            }


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

        echo "nok3";
    }

    public function assignServiceToUser() {


        if(isset($_POST["serviceId"]) && isset($_POST["userId"])) {

            $sId = makeValidInput($_POST["serviceId"]);
            $uId = makeValidInput($_POST["userId"]);

            if(ServiceBuyer::whereUserId($uId)->whereServiceId($sId)->count() > 0) {
                echo "nok2";
                return;
            }

            $service = Service::whereId($sId);

            if($service == null) {
                echo "nok3";
                return;
            }

            $user = User::whereId($uId);

            if($user == null) {
                echo "nok3";
                return;
            }


            if($service->capacity != -1 &&
                ServiceBuyer::whereServiceId($service->id)->count() >= $service->capacity) {
                echo "nok5";
                return;
            }


            $grades = ServiceGrade::whereServiceId($service->id)->get();
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

            try {
                $tmp = new ServiceBuyer();
                $tmp->user_id = $user->id;
                $tmp->service_id = $service->id;
                $tmp->save();

                echo "ok";
                return;
            }
            catch (\Exception $x) {}

        }

        echo "nok3";
    }

    public function assignProductToUser() {

        if(isset($_POST["productId"]) && isset($_POST["userId"])) {

            $pId = makeValidInput($_POST["productId"]);
            $uId = makeValidInput($_POST["userId"]);

            if(Transaction::whereProductId($pId)->count() > 0) {
                echo "nok2";
                return;
            }

            $product = Product::whereId($pId);

            if($product == null) {
                echo "nok3";
                return;
            }

            $user = User::whereId($uId);

            if($user == null) {
                echo "nok3";
                return;
            }


            if($product->price > $user->money) {
                echo "nok4";
                return;
            }

            $product->grade_id = User::whereId($product->user_id)->grade_id;

            if($product->grade_id != $user->grade_id) {
                echo "nok1";
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

        echo "nok3";
    }

    public function deleteTransaction() {

        if(isset($_POST["tId"])) {

            $tId = makeValidInput($_POST["tId"]);

            $t = Transaction::whereId($tId);
            if($t == null)
                return;

            $u = User::whereId($t->user_id);
            if($u == null)
                return;

            $p = Product::whereId($t->product_id);
            if($p == null)
                return;

            try {
                $u->money += $p->price;
                $u->stars -= $p->star;
                $u->save();
                $t->delete();
                echo "ok";
                return;
            }
            catch (\Exception $x) {
                dd($x);
            }
        }

        echo "nok";
    }


    public function deleteJob() {

        if(isset($_POST["sId"]) && isset($_POST["uId"])) {

            $sId = makeValidInput($_POST["sId"]);
            $uId = makeValidInput($_POST["uId"]);

            try {
                ServiceBuyer::whereServiceId($sId)->whereUserId($uId)->delete();
                echo "ok";
                return;
            }
            catch (\Exception $x) {
                dd($x);
            }
        }

        echo "nok";
    }
}
