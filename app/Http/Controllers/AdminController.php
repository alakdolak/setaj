<?php

namespace App\Http\Controllers;

use App\models\CommonQuestion;
use App\models\ConfigModel;
use App\models\FAQCategory;
use App\models\Grade;
use App\models\ProjectBuyers;
use App\models\Tag;
use App\models\Tutorial;
use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use PHPExcel_IOFactory;

class AdminController extends Controller {

    public function config() {
        return view('config', ['config' => ConfigModel::first()]);
    }

    public function doConfig() {

        if(isset($_POST["initial_point"]) && isset($_POST["initial_star"]) &&
            isset($_POST["change_rate"]) && isset($_POST["project_limit"]) &&
            isset($_POST["rev_change_rate"]) && isset($_POST["service_limit"])
        ) {
            $tmp = ConfigModel::first();
            $tmp->initial_point = makeValidInput($_POST["initial_point"]);
            $tmp->initial_star = makeValidInput($_POST["initial_star"]);
            $tmp->change_rate = makeValidInput($_POST["change_rate"]);
            $tmp->project_limit = makeValidInput($_POST["project_limit"]);
            $tmp->rev_change_rate = makeValidInput($_POST["rev_change_rate"]);
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
            $request->hasFile("description")) {

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

        foreach ($users as $user) {

            if(count($user) != 5)
                continue;

//            if(User::whereNid($user[1])->count() > 0 || !_custom_check_national_code($user[1]))
//                continue;

            $gradeTmp = Grade::whereId($gradeId);
            if($gradeTmp == null)
                continue;

            $config = ConfigModel::first();

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
                echo "ok";
                return;
            }
            catch (\Exception $x) {}
        }

        echo "nok";
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

                    if ($cols < 'D') {
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
}
