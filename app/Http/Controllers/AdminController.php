<?php

namespace App\Http\Controllers;

use App\models\CommonQuestion;
use App\models\ConfigModel;
use App\models\FAQCategory;
use App\models\Grade;
use App\models\PointConfig;
use App\models\RedundantInfo1;
use App\models\SchoolStudent;
use App\models\Tag;
use App\models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;

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

    public function doAddUsers($users, $gradeId) {

        $errs = '';

        foreach ($users as $user) {

            if(count($user) != 5)
                continue;

            if(User::whereNid($user[4])->count() > 0 || !_custom_check_national_code($user[4]))
                continue;

            $gradeTmp = Grade::whereId($gradeId);
            if($gradeTmp == null)
                continue;

            $config = ConfigModel::first();

            $tmp = new User();
            $tmp->first_name = $user[0];
            $tmp->last_name = $user[1];
            $tmp->level = getValueInfo("studentLevel");
            $tmp->money = $config->initial_point;
            $tmp->stars = $config->initial_star;

            $tmp->username = $user[2];
            $tmp->password = Hash::make($user[3]);
            $tmp->status = true;
            $tmp->nid = $user[4];
            $tmp->grade_id = $gradeId;

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

                    if ($cols < 'F') {
                        unlink($path);
                        $err = "تعداد ستون های فایل شما معتبر نمی باشد";
                    }
                    else {

                        for ($row = 2; $row <= $lastRow; $row++) {

                            if($workSheet->getCell('B' . $row)->getValue() == "")
                                break;

                            $users[$row - 2][0] = $workSheet->getCell('B' . $row)->getValue();
                            $users[$row - 2][1] = $workSheet->getCell('C' . $row)->getValue();
                            $users[$row - 2][2] = $workSheet->getCell('D' . $row)->getValue();
                            $users[$row - 2][3] = $workSheet->getCell('E' . $row)->getValue();
                            $users[$row - 2][4] = $workSheet->getCell('F' . $row)->getValue();
                        }

                        unlink($path);

                        $err = $this->doAddUsers($users, $gradeId);
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
}
