<?php

namespace App\Http\Controllers;

use App\models\CommonQuestion;
use App\models\ConfigModel;
use App\models\FAQCategory;
use App\models\Good;
use App\models\GoodPic;
use App\models\Grade;
use App\models\PayPingTransaction;
use App\models\ProjectBuyers;
use App\models\Tag;
use App\models\Tutorial;
use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use PHPExcel_IOFactory;
use ZipArchive;

class AdminController extends Controller {

    public function config() {
        return view('config', ['config' => ConfigModel::first()]);
    }

    public function doConfig() {

        if(isset($_POST["initial_point"]) && isset($_POST["initial_star"]) &&
            isset($_POST["change_rate"]) && isset($_POST["project_limit_7"]) &&
            isset($_POST["rev_change_rate"]) && isset($_POST["service_limit"]) &&
            isset($_POST["project_limit_4"]) && isset($_POST["project_limit_1"]) &&
            isset($_POST["project_limit_5"]) && isset($_POST["project_limit_2"]) &&
            isset($_POST["project_limit_6"]) && isset($_POST["project_limit_3"])
        ) {
            $tmp = ConfigModel::first();
            $tmp->initial_point = makeValidInput($_POST["initial_point"]);
            $tmp->initial_star = makeValidInput($_POST["initial_star"]);
            $tmp->change_rate = makeValidInput($_POST["change_rate"]);
            $tmp->project_limit_7 = makeValidInput($_POST["project_limit_7"]);
            $tmp->project_limit_6 = makeValidInput($_POST["project_limit_6"]);
            $tmp->project_limit_5 = makeValidInput($_POST["project_limit_5"]);
            $tmp->project_limit_4 = makeValidInput($_POST["project_limit_4"]);
            $tmp->project_limit_3 = makeValidInput($_POST["project_limit_3"]);
            $tmp->project_limit_2 = makeValidInput($_POST["project_limit_2"]);
            $tmp->project_limit_1 = makeValidInput($_POST["project_limit_1"]);
            $tmp->rev_change_rate = makeValidInput($_POST["rev_change_rate"]);
            $tmp->min_health = makeValidInput($_POST["min_health"]);
            $tmp->min_think = makeValidInput($_POST["min_think"]);
            $tmp->min_behavior = makeValidInput($_POST["min_behavior"]);
            $tmp->min_money = makeValidInput($_POST["min_money"]);
            $tmp->min_star = makeValidInput($_POST["min_star"]);
            $tmp->extra_limit = makeValidInput($_POST["extra_limit"]);

            $tmp->show_project = (isset($_POST["show_project"]));
            $tmp->show_product = (isset($_POST["show_product"]));
            $tmp->show_extra = (isset($_POST["show_extra"]));
            $tmp->show_sell_extra = (isset($_POST["show_sell_extra"]));
            $tmp->show_shop = (isset($_POST["show_shop"]));
            $tmp->show_citizen = (isset($_POST["show_citizen"]));
            $tmp->show_service = (isset($_POST["show_service"]));

            $tmp->service_limit = makeValidInput($_POST["service_limit"]);
            $tmp->save();
        }

        return Redirect::route('profile');
    }

    public function commonQuestionsPanel() {

        $categories = FAQCategory::all();

        foreach ($categories as $category) {
            $category->questions = CommonQuestion::whereCategoryId($category->id)->get();
        }

        return view('commonQuestions', ['categories' => $categories]);
    }

    public function deleteCommonQuestion() {

        if(isset($_POST["id"])) {
            CommonQuestion::destroy(makeValidInput($_POST["id"]));
        }

        return Redirect::route('commonQuestionsPanel');
    }

    public function addCommonQuestion() {

        if(isset($_POST["catId"]) && isset($_POST["question"]) && isset($_POST["answer"])) {


            $q = new CommonQuestion();
            $q->category_id = makeValidInput($_POST["catId"]);
            $q->answer = $_POST["answer"];
            $q->question = $_POST["question"];

            $q->save();

        }

        return Redirect::route('commonQuestionsPanel');

    }


    public function tutorials() {

        $tutorials = Tutorial::all();
        foreach ($tutorials as $tutorial) {

            if($tutorial->pic != null &&
                file_exists(__DIR__ . '/../../../public/storage/tutorials/' . $tutorial->pic))
                $tutorial->pic = URL::asset("storage/tutorials/" . $tutorial->pic);
            else
                $tutorial->pic = URL::asset("images/defaultTutorial.jpg");
        }

        return view('operator.tutorials', ['tutorials' => $tutorials]);
    }

    public function addTutorial(Request $request) {

        if($request->has("name") && $request->hasFile("file") &&
            $request->has("description")) {

            $tmp = new Tutorial();
            $tmp->title = $request["name"];
            $tmp->description = $request["description"];

            if($request->hasFile("pic"))
                $tmp->pic = str_replace("public/tutorials/", "", $request->pic->store("public/tutorials"));
            else
                $tmp->pic = null;

            $tmp->path = str_replace("public/tutorials/", "", $request->file->store("public/tutorials"));
            $tmp->save();

        }

        return Redirect::route('tutorials');
    }

    public function editTutorial($id) {

        $t = Tutorial::whereId($id);
        if($t == null)
            return Redirect::route("home");

        return view('operator.editTutorial', ['tutorial' => $t]);
    }

    public function doEditTutorial(Request $request, $id) {

        if($request->has("title") && $request->has("description")) {

            $tutorial = Tutorial::whereId($id);
            if($tutorial == null)
                return Redirect::route("home");

            $tutorial->title = makeValidInput($request["title"]);
            $tutorial->description = $request["description"];

            try {

                if($request->hasFile("file")) {

                    if(!empty($tutorial->path) &&
                        file_exists(__DIR__ . '/../../../storage/app/public/tutorials/' . $tutorial->path))
                        unlink(__DIR__ . '/../../../storage/app/public/tutorials/' . $tutorial->path);

                    $tutorial->path = str_replace("public/tutorials/", "", $request->file->store("public/tutorials"));
                }

                if($request->hasFile("pic")) {

                    if($tutorial->pic != null && !empty($tutorial->pic) &&
                        file_exists(__DIR__ . '/../../../storage/app/public/tutorials/' . $tutorial->pic))
                        unlink(__DIR__ . '/../../../storage/app/public/tutorials/' . $tutorial->pic);

                    $tutorial->pic = str_replace("public/tutorials/", "", $request->pic->store("public/tutorials"));
                }

                $tutorial->save();
            }

            catch (\Exception $x) {
                dd($x);
            }
        }

        return Redirect::route("tutorials");
    }

    public function deleteTutorial($id) {
        try {

            $t = Tutorial::whereId($id);
            if($t == null)
                return "nok";

            if($t->pic != null &&
                file_exists(__DIR__ . '/../../../public/storage/tutorials/' . $t->pic))
                unlink(__DIR__ . '/../../../public/storage/tutorials/' . $t->pic);

            if(file_exists(__DIR__ . '/../../../public/storage/tutorials/' . $t->path))
                unlink(__DIR__ . '/../../../public/storage/tutorials/' . $t->path);

            $t->delete();
            return "ok";
        }
        catch (\Exception $x) {
            return "nok";
        }
    }

    public function faqCategories($err = "") {
        return view('faqCategories', ['items' => FAQCategory::all(), 'err' => $err]);
    }

    public function addFaqCategory() {

        if(isset($_POST["name"])) {

            $tmp = new FAQCategory();
            $tmp->name = makeValidInput($_POST["name"]);

            try {
                $tmp->save();
            }
            catch (\Exception $x) {
                return $this->faqCategories('دسته مورد نظر در سامانه موجود است');
            }
        }

        return Redirect::route('faqCategories');
    }

    public function editFaqCategory() {

        if(isset($_POST["newName"]) && isset($_POST["categoryId"])) {

            $cat = FaqCategory::whereId(makeValidInput($_POST["categoryId"]));

            if($cat != null) {
                $cat->name = makeValidInput($_POST["newName"]);
                try {
                    $cat->save();
                }
                catch (\Exception $x) {
                    return $this->faqCategories('نام دسته مورد نظر در سامانه موجود است');
                }
            }
        }

        return Redirect::route('faqCategories');
    }

    public function deleteFaqCategory() {
        if(isset($_POST["categoryId"])) {
            FAQCategory::destroy(makeValidInput($_POST["categoryId"]));
        }
        return Redirect::route('faqCategories');
    }


    public function tags($err = "") {
        return view('tags', ['items' => Tag::all(), 'err' => $err]);
    }

    public function addTag() {

        if(isset($_POST["name"])) {

            $tmp = new Tag();
            $tmp->name = makeValidInput($_POST["name"]);

            try {
                $tmp->save();
            }
            catch (\Exception $x) {
                return $this->tags('تگ مورد نظر در سامانه موجود است');
            }
        }

        return Redirect::route('tags');
    }

    public function editTag() {

        if(isset($_POST["newName"]) && isset($_POST["tagId"])) {

            $cat = Tag::whereId(makeValidInput($_POST["tagId"]));

            if($cat != null) {
                $cat->name = makeValidInput($_POST["newName"]);
                try {
                    $cat->save();
                }
                catch (\Exception $x) {
                    return $this->tags('تگ مورد نظر در سامانه موجود است');
                }
            }
        }

        return Redirect::route('tags');
    }

    public function deleteTag() {

        if(isset($_POST["tagId"])) {
            Tag::destroy(makeValidInput($_POST["tagId"]));
        }
        return Redirect::route('tags');
    }



    public function grades($err = "") {
        return view('grades', ['items' => Grade::all(), 'err' => $err]);
    }

    public function addGrade() {

        if(isset($_POST["name"])) {

            $tmp = new Grade();
            $tmp->name = makeValidInput($_POST["name"]);

            try {
                $tmp->save();
            }
            catch (\Exception $x) {
                return $this->grades('پایه تحصیلی مورد نظر در سامانه موجود است');
            }
        }

        return Redirect::route('grades');
    }

    public function editGrade() {

        if(isset($_POST["newName"]) && isset($_POST["gradeId"])) {

            $cat = Grade::whereId(makeValidInput($_POST["gradeId"]));

            if($cat != null) {
                $cat->name = makeValidInput($_POST["newName"]);
                try {
                    $cat->save();
                }
                catch (\Exception $x) {
                    return $this->grades('پایه تحصیلی مورد نظر در سامانه موجود است');
                }
            }
        }

        return Redirect::route('grades');
    }

    public function deleteGrade() {

        if(isset($_POST["gradeId"])) {
            Grade::destroy(makeValidInput($_POST["gradeId"]));
        }
        return Redirect::route('grades');
    }

    public function doAddUsers($users, $gradeId, $mode) {

        $errs = '';

        $config = ConfigModel::first();

        foreach ($users as $user) {

            if(count($user) != 5)
                continue;

//            if(User::whereNid($user[1])->count() > 0 || !_custom_check_national_code($user[1]))
//                continue;

            $gradeTmp = Grade::whereId($gradeId);
            if($gradeTmp == null)
                continue;

            $tmp = new User();
            $tmp->first_name = $user[0];
            $tmp->last_name = $user[1];

//            $tmp->first_name = explode(" ", $user[0])[0];
//            $sss = explode(" ", $user[0]);
//            $reminder = "";
//            $first = true;
//
//            for($i = 1; $i < count($sss); $i++) {
//                if($first) {
//                    $reminder .= $sss[$i];
//                    $first = false;
//                }
//                else
//                    $reminder .= ' ' . $sss[$i];
//            }

//            $tmp->last_name = $reminder;

            $tmp->level = $mode;
            $tmp->money = $config->initial_point;
            $tmp->stars = $config->initial_star;

//            $tmp->username = $user[2];
            $tmp->username = $user[3];
//            $tmp->password = Hash::make($user[1]);
            $tmp->password = Hash::make($user[2]);
            $tmp->status = true;
//            $tmp->nid = $user[1];
            $tmp->nid = $user[2];
            $tmp->grade_id = $gradeId;
//            $tmp->pic = $user[3] . '.png';
            $tmp->pic = $user[4] . '.png';

            try {
                $tmp->save();
            }
            catch (\Exception $x) {
                dd($x);
                $errs .= $user[0] . ' ' . $user[1] . '<br/>';
            }
        }

        return $errs;
    }

    public function deleteBuyProject() {

        if(isset($_POST["id"])) {

            try {
                ProjectBuyers::destroy(makeValidInput($_POST["id"]));
                return "ok";
            }
            catch (\Exception $x) {}
        }

        return "nok";
    }


    public function addUsers($gradeId) {

        $err = "";

        if(isset($_FILES["file"])) {

            $file = $_FILES["file"]["name"];

            if(!empty($file)) {

                $path = __DIR__ . '/../../../public/tmp/' . $file;

                $err = uploadCheck($path, "file", "اکسل ثبت نام گروهی", 20000000, "xlsx");

                if (empty($err)) {
                    upload($path, "file", "اکسل ثبت نام گروهی");
                    $excelReader = PHPExcel_IOFactory::createReaderForFile($path);
                    $excelObj = $excelReader->load($path);
                    $workSheet = $excelObj->getSheet(0);
                    $users = array();
                    $lastRow = $workSheet->getHighestRow();
                    $cols = $workSheet->getHighestColumn();

                    if ($cols < 'E') {
                        unlink($path);
                        $err = "تعداد ستون های فایل شما معتبر نمی باشد";
                    }
                    else {

                        for ($row = 1; $row <= $lastRow; $row++) {

                            if($workSheet->getCell('A' . $row)->getValue() == "")
                                break;

                            $users[$row - 1][0] = $workSheet->getCell('A' . $row)->getValue();
                            $users[$row - 1][1] = $workSheet->getCell('B' . $row)->getValue();
                            $users[$row - 1][2] = $workSheet->getCell('C' . $row)->getValue();
                            $users[$row - 1][3] = $workSheet->getCell('D' . $row)->getValue();
                            $users[$row - 1][4] = $workSheet->getCell('E' . $row)->getValue();
                        }

                        unlink($path);

                        $err = $this->doAddUsers($users, $gradeId, getValueInfo('studentLevel'));
                        if(empty($err)) {
                            return Redirect::route('usersReport', ['gradeId' => $gradeId]);
                        }
                        else {
                            $err = "بجز موارد زیر سایر دانش آموزان اضافه شدند." . "<br/>" . $err;
                        }
                    }
                }
            }
        }

        if(empty($err))
            $err = "لطفا فایل اکسل مورد نیاز را آپلود نمایید";

        return view('registrationResult', ['err' => $err, 'gradeId' => $gradeId]);
    }

    public function addOperators() {

        $err = "";

        if(isset($_FILES["file"])) {

            $file = $_FILES["file"]["name"];

            if(!empty($file)) {

                $path = __DIR__ . '/../../../public/tmp/' . $file;

                $err = uploadCheck($path, "file", "اکسل ثبت نام گروهی", 20000000, "xlsx");

                if (empty($err)) {
                    upload($path, "file", "اکسل ثبت نام گروهی");
                    $excelReader = PHPExcel_IOFactory::createReaderForFile($path);
                    $excelObj = $excelReader->load($path);
                    $workSheet = $excelObj->getSheet(0);
                    $users = array();
                    $lastRow = $workSheet->getHighestRow();
                    $cols = $workSheet->getHighestColumn();

                    if ($cols < 'E') {
                        unlink($path);
                        $err = "تعداد ستون های فایل شما معتبر نمی باشد";
                    }
                    else {

                        for ($row = 1; $row <= $lastRow; $row++) {

                            if($workSheet->getCell('A' . $row)->getValue() == "")
                                break;

                            $users[$row - 1][0] = $workSheet->getCell('A' . $row)->getValue();
                            $users[$row - 1][1] = $workSheet->getCell('B' . $row)->getValue();
                            $users[$row - 1][2] = $workSheet->getCell('C' . $row)->getValue();
                            $users[$row - 1][3] = $workSheet->getCell('D' . $row)->getValue();
                            $users[$row - 1][4] = $workSheet->getCell('E' . $row)->getValue();
                        }

                        unlink($path);

                        $err = $this->doAddUsers($users, Grade::first()->id, getValueInfo('operatorLevel'));
                        if(empty($err)) {
                            return Redirect::route('operators');
                        }
                        else {
                            $err = "بجز موارد زیر سایر دانش آموزان اضافه شدند." . "<br/>" . $err;
                        }
                    }
                }
            }
        }

        if(empty($err))
            $err = "لطفا فایل اکسل مورد نیاز را آپلود نمایید";

        dd($err);
    }


    public function toggleSuperStatusUser() {

        if(isset($_POST["id"])) {

            $user = User::whereId(makeValidInput($_POST["id"]));

            if($user == null)
                return;

            if($user->super_active)
                $user->super_active = false;
            else
                $user->super_active = true;

            $user->save();
            echo "ok";
        }

    }

    public function toggleStatusUser() {

        if(isset($_POST["id"])) {

            $user = User::whereId(makeValidInput($_POST["id"]));

            if($user == null)
                return;

            if($user->status)
                $user->status = false;
            else
                $user->status = true;

            $user->save();
            echo "ok";
        }

    }


    public function editMoney() {

        if(isset($_POST["id"]) && isset($_POST["coin"]) && isset($_POST["star"])) {

            $user = User::whereId(makeValidInput($_POST["id"]));

            if($user == null)
                return Redirect::route("profile");

            $user->money = makeValidInput($_POST["coin"]);
            $user->stars = makeValidInput($_POST["star"]);
            $user->save();

            return Redirect::route("usersReport", ["gradeId" => $user->grade_id]);
        }

    }

    public function cancelAllSuperActivation() {

        if(isset($_POST["gradeId"])) {

            $gradeId = makeValidInput($_POST["gradeId"]);
            DB::update("update users set super_active = false where grade_id = " . $gradeId);
            echo "ok";
            return;
        }

    }

    public function onAllSuperActivation() {

        if(isset($_POST["gradeId"])) {

            $gradeId = makeValidInput($_POST["gradeId"]);
            DB::update("update users set super_active = true where grade_id = " . $gradeId);
            echo "ok";
            return;
        }

    }


    public function goods() {

        $goods = DB::select("select g.name as grade, g.id as grade_id, concat(u.first_name, ' ', u.last_name) as user_name, gd.* from good gd, users u, grade g where gd.user_id = u.id and u.grade_id = g.id order by gd.id desc");

        foreach ($goods as $good) {

            if($good->adv != null &&
                file_exists(__DIR__ . '/../../../public/goodAdvs/' . $good->adv))
                $good->adv = URL::asset("public/goodAdvs/" . $good->adv);
            else
                $good->adv = null;

            $tmpPic = GoodPic::whereGoodId($good->id)->first();

            if($tmpPic == null || !file_exists(__DIR__ . '/../../../public/goodPic/' . $tmpPic->name))
                $good->pic = URL::asset('goodPic/defaultPic.png');
            else
                $good->pic = URL::asset('goodPic/' . $tmpPic->name);

            $good->date = MiladyToShamsi('', explode('-', explode(' ', $good->created_at)[0]));
            $good->start_show = convertStringToDate($good->start_show);
            $good->start_time = convertStringToTime($good->start_time);

            $good->start_date_buy = convertStringToDate($good->start_date_buy);
            $good->start_time_buy = convertStringToTime($good->start_time_buy);

            $t = PayPingTransaction::whereGoodId($good->id)->select('user_id')->get();

            if($good->price == 0)
                $good->price = "رایگان";
            else
                $good->price = number_format($good->price);

            $good->hide = (!$good->hide) ? "آشکار" : "مخفی";

            if($t == null || count($t) == 0)
                $good->buyer = "هنوز خریداری نشده است.";
            else {
                $u = User::whereId($t[0]->user_id);
                $good->buyer = $u->first_name . ' ' . $u->last_name;
            }

        }

        return view('operator.goods', ['goods' => $goods, 'grades' => Grade::all()]);
    }

    public function addBatchGood() {

        if(isset($_FILES["excel"]) && !empty($_FILES["excel"]["name"])) {

            $file = Input::file('excel');
            $Image = time() . '_' . $file->getClientOriginalName();
            $destenationpath = public_path() . '/tmp';
            $file->move($destenationpath, $Image);

            $path = __DIR__ . '/../../../public/tmp/' . $Image;
            $excelReader = PHPExcel_IOFactory::createReaderForFile($path);
            $excelObj = $excelReader->load($path);
            $workSheet = $excelObj->getSheet(0);
            $lastRow = $workSheet->getHighestRow();
            $cols = $workSheet->getHighestColumn();

            unlink($path);

            if ($cols < 'L') {
                unlink($path);
                dd("تعداد ستون های فایل شما معتبر نمی باشد");
            }
            else {
                $goods = [];

                for ($row = 2; $row <= $lastRow; $row++) {

                    if($workSheet->getCell('A' . $row)->getValue() == "")
                        break;

                    $goods[$row - 2][0] = $workSheet->getCell('A' . $row)->getValue();
                    $goods[$row - 2][1] = $workSheet->getCell('B' . $row)->getValue();
                    $goods[$row - 2][2] = $workSheet->getCell('C' . $row)->getValue();
                    $goods[$row - 2][3] = $workSheet->getCell('D' . $row)->getValue();
                    $goods[$row - 2][4] = $workSheet->getCell('E' . $row)->getValue();
                    $goods[$row - 2][5] = $workSheet->getCell('F' . $row)->getValue();
                    $goods[$row - 2][6] = $workSheet->getCell('G' . $row)->getValue();
                    $goods[$row - 2][7] = $workSheet->getCell('H' . $row)->getValue();
                    $goods[$row - 2][8] = $workSheet->getCell('I' . $row)->getValue();
                    $goods[$row - 2][9] = $workSheet->getCell('J' . $row)->getValue();
                    $goods[$row - 2][10] = $workSheet->getCell('K' . $row)->getValue();
                    $goods[$row - 2][11] = $workSheet->getCell('L' . $row)->getValue();
                }

                $err = $this->doAddGoods($goods);
                if(empty($err))
                    return Redirect::route('goods');
                else {
                    echo "بجز ردیف های زیر سایر محصولات اضافه شدند." . "<br/>";
                    dd($err);
                }
            }

        }

        return Redirect::route('home');
    }

    public function doAddGoods($goods) {

        $errs = [];
        $counter = 0;
        $i = 0;

        foreach($goods as $good) {

            $i++;

            if(count($good) != 12) {
                $errs[$counter++] = $i;
                continue;
            }

            if(!preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/", $good[8]) ||
                !preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/", $good[10])
            ) {
                $errs[$counter++] = $i;
                continue;
            }

            if(!preg_match("/^([01][0-9]|2[0-3]):([0-5][0-9])$/", $good[7]) ||
                !preg_match("/^([01][0-9]|2[0-3]):([0-5][0-9])$/", $good[9])
            ) {
                $errs[$counter++] = $i;
                continue;
            }

            $username = $good[0];
            $user = User::whereUsername($username)->orWhere('nid', '=', $username)->first();

            if($user == null) {
                $errs[$counter++] = $i;
                continue;
            }

            $g = new Good();
            $g->name = $good[1];
            $g->owner = $good[2];

            if(!empty($good[3]))
                $g->description = $good[3];
            if(!empty($good[4]))
                $g->tag = $good[4];

            $g->code = $good[5];
            $g->price = $good[6];
            $g->user_id = $user->id;

            $g->start_time = convertTimeToString($good[7]);
            $g->start_show = convertDateToString($good[8]);

            $g->start_time_buy = convertTimeToString($good[9]);
            $g->start_date_buy = convertDateToString($good[10]);

            try {
                $g->save();

                if (!empty($good[11])) {
                    $goodPic = new GoodPic();
                    $goodPic->good_id = $g->id;
                    $goodPic->name = $good[11];
                    $goodPic->save();
                }
            }
            catch (\Exception $x) {
                $errs[$counter++] = $i;
                continue;
            }

        }

        return $errs;
    }

    public function addGood() {

        if(isset($_POST["name"])
            && isset($_POST["price"]) && isset($_POST["start_show"])
            && isset($_POST["code"]) && isset($_POST["owner"])
            && isset($_POST["start_time"]) && isset($_POST["username"])
            && isset($_POST["start_time_buy"]) && isset($_POST["start_date_buy"])
        ) {

            $username = makeValidInput($_POST["username"]);
            $user = User::whereUsername($username)->orWhere('nid', '=', $username)->first();

            if($user == null)
                return Redirect::route('home');

            $good = new Good();
            $good->name = makeValidInput($_POST["name"]);
            $good->owner = makeValidInput($_POST["owner"]);

            if(isset($_POST["description"]))
                $good->description = $_POST["description"];
            if(isset($_POST["tag"]))
                $good->tag = makeValidInput($_POST["tag"]);

            $good->code = makeValidInput($_POST["code"]);
            $good->price = makeValidInput($_POST["price"]);
            $good->user_id = $user->id;

            $good->start_time = convertTimeToString(makeValidInput($_POST["start_time"]));
            $good->start_show = convertDateToString(makeValidInput($_POST["start_show"]));

            $good->start_time_buy = convertTimeToString(makeValidInput($_POST["start_time_buy"]));
            $good->start_date_buy = convertDateToString(makeValidInput($_POST["start_date_buy"]));

            try {

                if(isset($_FILES["adv"]) && !empty($_FILES["adv"]["name"])) {

                    $file = Input::file('adv');
                    $Image = time() . '_' . $file->getClientOriginalName();
                    $destenationpath = public_path() . '/goodAdvs';
                    $file->move($destenationpath, $Image);

                    $good->adv = $Image;
                }

                $good->save();

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

                        $newDest = __DIR__ . '/../../../public/goodPic/';

                        foreach ($vals as $val) {
                            $tmp = new GoodPic();
                            $tmp->good_id = $good->id;
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

        return Redirect::route('goods');
    }

    public function toggleHideGood() {

        if(isset($_POST["id"])) {
            DB::update("update good set hide = not hide where id = " . makeValidInput($_POST["id"]));
            return "ok";
        }

        return "nok";
    }

    public function deleteGood() {

        if(isset($_POST["id"])) {

            $g = Good::whereId(makeValidInput($_POST["id"]));

            if($g != null) {

                $pics = GoodPic::whereGoodId($g->id)->get();

                foreach ($pics as $pic) {
                    if (file_exists(__DIR__ . '/../../../public/goodPic/' . $pic->name))
                        unlink(__DIR__ . '/../../../public/goodPic/' . $pic->name);
                }

                if($g->adv != null && !empty($g->adv) &&
                    file_exists(__DIR__ . '/../../../public/goodAdvs/' . $g->adv))
                    unlink(__DIR__ . '/../../../public/goodAdvs/' . $g->adv);

                try {
                    $g->delete();
                    return "ok";
                }
                catch (\Exception $x) {
                    dd($x);
                }
            }
        }

        return "nok";
    }

    public function editGood($id) {

        $good = Good::whereId($id);

        if($good == null)
            return Redirect::route('admin');

        $good->start_show = convertStringToDate($good->start_show);
        $good->start_time = convertStringToTime($good->start_time);

        $good->start_date_buy = convertStringToDate($good->start_date_buy);
        $good->start_time_buy = convertStringToTime($good->start_time_buy);

        return view('operator.editGood', ['good' => $good]);

    }

    public function doEditGood($id) {

        if(isset($_POST["name"])
            && isset($_POST["price"]) && isset($_POST["start_show"])
            && isset($_POST["code"]) && isset($_POST["owner"])
            && isset($_POST["start_time"])
            && isset($_POST["start_time_buy"]) && isset($_POST["start_date_buy"])
        ) {


            $good = Good::whereId($id);

            if($good == null)
                return Redirect::route('hone');

            $good->name = makeValidInput($_POST["name"]);
            $good->owner = makeValidInput($_POST["owner"]);

            if(isset($_POST["description"]))
                $good->description = $_POST["description"];
            if(isset($_POST["tag"]))
                $good->tag = makeValidInput($_POST["tag"]);

            $good->code = makeValidInput($_POST["code"]);
            $good->price = makeValidInput($_POST["price"]);

            $good->start_time = convertTimeToString(makeValidInput($_POST["start_time"]));
            $good->start_show = convertDateToString(makeValidInput($_POST["start_show"]));

            $good->start_time_buy = convertTimeToString(makeValidInput($_POST["start_time_buy"]));
            $good->start_date_buy = convertDateToString(makeValidInput($_POST["start_date_buy"]));

            try {

                if(isset($_FILES["adv"]) && !empty($_FILES["adv"]["name"])) {

                    if($good->adv != null && !empty($good->adv) &&
                        file_exists(__DIR__ . '/../../../public/goodAdvs/' . $good->adv))
                        unlink(__DIR__ . '/../../../public/goodAdvs/' . $good->adv);

                    $file = Input::file('adv');
                    $Image = time() . '_' . $file->getClientOriginalName();
                    $destenationpath = public_path() . '/goodAdvs';
                    $file->move($destenationpath, $Image);

                    $good->adv = $Image;
                }

                $good->save();

                if(isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {

                    $pics = GoodPic::whereGoodId($id)->get();

                    foreach ($pics as $pic) {
                        if (file_exists(__DIR__ . '/../../../public/goodPic/' . $pic->name))
                            unlink(__DIR__ . '/../../../public/goodPic/' . $pic->name);
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

                        $newDest = __DIR__ . '/../../../public/goodPic/';

                        foreach ($vals as $val) {
                            $tmp = new GoodPic();
                            $tmp->good_id = $good->id;
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

        return Redirect::route('goods');

    }

}
