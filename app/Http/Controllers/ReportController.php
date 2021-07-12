<?php

namespace App\Http\Controllers;

use App\models\ConfigModel;
use App\models\Grade;
use App\models\ProjectBuyers;
use App\models\Service;
use App\models\ServiceBuyer;
use App\models\Transaction;
use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use PHPExcel;
use PHPExcel_Writer_Excel2007;

class ReportController extends Controller {

    public function usersReport($gradeId = -1) {

        if($gradeId == -1)
            return view('report.usersReport', ['grades' => Grade::all(),
                "path" => route("usersReport")]);

        $per = ConfigModel::first()->change_rate;

        $students = User::whereLevel(getValueInfo('studentLevel'))->whereGradeId($gradeId)->get();

        foreach ($students as $student) {

            $tmp = DB::select("select sum(p.price) as total from transactions t, product p where " .
                "p.id = t.product_id and t.user_id = " . $student->id);

            if($tmp == null || count($tmp) == 0 || $tmp[0]->total == null)
                $sum = 0;
            else {
                $sum = $tmp[0]->total;
            }

            $student->buys = Transaction::whereUserId($student->id)->count();
            $student->sum = $sum;

            $student->total = floor(($student->money - 2000) / $per) + $student->stars;
        }

        $projects = DB::select("select p.id, p.title from project p where (select count(*) from project_grade where grade_id = " . $gradeId . " and project_id = p.id) > 0");
        $services = DB::select("select s.id, s.title from service s where (select count(*) from service_grade where grade_id = " . $gradeId . " and service_id = s.id) > 0");
        $citizens = DB::select("select c.id, c.title from citizen c where (select count(*) from citizen_grade where grade_id = " . $gradeId . " and project_id = c.id) > 0");

        return view('report.usersReportGrade', ['users' => $students, 'gradeId' => $gradeId,
            'projects' => $projects, 'services' => $services, 'citizens' => $citizens]);
    }

    public function usersReportExcel($gradeId) {

        $students = User::whereLevel(getValueInfo('studentLevel'))->whereGradeId($gradeId)->get();

        foreach ($students as $student) {

            $tmp = DB::select("select sum(p.price) as total from transactions t, product p where " .
                "p.id = t.product_id and t.user_id = " . $student->id);

            if($tmp == null || count($tmp) == 0 || $tmp[0]->total == null)
                $sum = 0;
            else {
                $sum = $tmp[0]->total;
            }

            $student->buys = Transaction::whereUserId($student->id)->count();
            $student->sum = $sum;
        }


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Karestoon");
        $objPHPExcel->getProperties()->setLastModifiedBy("Karestoon");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'تعداد ستاره های کل');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'تعداد سکه ها');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'تعداد ستاره ها');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'ارزش کل خریدها');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'تعداد خرید');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'وضعیت دسترسی فراتر');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'وضعیت');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'کد ملی');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'نام');

        $per = ConfigModel::first()->change_rate;

        $i = 0;

        foreach ($students as $user) {

            $total = floor(($user->money - 2000) / $per) + $user->stars;

            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 2), $total);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 2), $user->money);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 2), $user->stars);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2), $user->sum);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2), $user->buys);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2), $user->super_active);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2), $user->status);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2), $user->nid);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), $user->first_name . ' ' . $user->last_name);

            $i++;
        }

        $fileName = __DIR__ . "/../../../public/tmp/karestoon.xlsx";

        $objPHPExcel->getActiveSheet()->setTitle('گزارش گیری آزمون ها');

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);


        if (file_exists($fileName)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            readfile($fileName);
            unlink($fileName);
        }

        return view('report.usersReportGrade', ['users' => $students, 'gradeId' => $gradeId]);
    }



    public function operators() {

        $students = User::whereLevel(getValueInfo('operatorLevel'))->get();
        return view('report.operatorReport', ['users' => $students]);
    }

    public function physicalReport($gradeId = -1) {

        if($gradeId == -1)
            return view('report.usersReport', ['grades' => Grade::all(),
                "path" => route("physicalReport")]);

        return view('report.physicalReport', ['gradeId' => $gradeId]);
    }

    public function physicalReportAPI(Request $request) {

        $request->validate(
            ["preFrom" => "required|integer|min:1"],
            ["preTo" => "required|integer|min:1"],
            ["gradeId" => "required|integer|min:1"]
        );

        $preFrom = makeValidInput($request["preFrom"]);
        $preTo = makeValidInput($request["preTo"]);
        $gradeId = makeValidInput($request["gradeId"]);

        $projects = DB::select("select count(*) as count, u.id, concat(u.first_name, ' ', u.last_name) as name " .
            "from project_buyers pb, project p, users u where p.physical = true and p.id = pb.project_id" .
            " and pb.user_id = u.id and pb.created_at >= date_sub(CURDATE(), interval " . $preFrom . " day) and " .
            "pb.created_at <= date_sub(CURDATE(), interval " . $preTo . " day) and " .
            "u.grade_id = " . $gradeId . " and (select count(*) from project_grade where project_id = p.id and grade_id = " . $gradeId . ") > 0 group by(u.id)"
        );

        $users = [];
        foreach ($projects as $project) {
            $users[$project->id] = [
                "name" => $project->name,
                "physical" => $project->count,
                "unphysical" => 0
            ];
        }

        $projects = DB::select("select count(*) as count, u.id, concat(u.first_name, ' ', u.last_name) as name " .
            "from project_buyers pb, project p, users u where p.physical = false and p.id = pb.project_id" .
            " and pb.user_id = u.id and pb.created_at >= date_sub(pb.created_at, interval " . $preFrom . " day) and " .
            "pb.created_at <= date_sub(pb.created_at, interval " . $preTo . " day) and " .
            "u.grade_id = " . $gradeId . " and (select count(*) from project_grade where project_id = p.id and grade_id = " . $gradeId . ") > 0 group by(u.id)"
        );

        foreach ($projects as $project) {

            if(array_key_exists($project->id, $users))
                $users[$project->id]["unphysical"] = $project->count;
            else {
                $users[$project->id] = [
                    "name" => $project->name,
                    "physical" => 0,
                    "unphysical" => $project->count
                ];
            }
        }

        $output = [];
        $counter = 0;
        foreach($users as $user)
            $output[$counter++] = $user;

        return json_encode(["status" => "ok", "result" => $output]);
    }

    public function unDoneProjectsReport($gradeId = -1, $err = -1) {

        if($gradeId == -1)
            return view('report.usersReport', ['grades' => Grade::all(),
                "path" => route("unDoneProjectsReport")]);

        $preThreeHours = time() - 10800;

        $unCompleted = DB::select("select file, id from project_buyers where file is not null and file_status <> 1 and ".
            "complete_upload_file = 0 and start_uploading is not null and start_uploading < " . $preThreeHours);

        foreach ($unCompleted as $itr) {

            if(file_exists(__DIR__ . '/../../../storage/app/public/contents/' . $itr->file))
                unlink(__DIR__ . '/../../../storage/app/public/contents/' . $itr->file);

            DB::update("update project_buyers set file = null, start_uploading = null, file_status = 0 where id = " . $itr->id);
        }

        $unCompleted = DB::select("select adv, id from project_buyers where adv is not null and adv_status <> 1 and ".
            "complete_upload_adv = 0 and start_uploading_adv is not null and start_uploading_adv < " . $preThreeHours);

        foreach ($unCompleted as $itr) {

            if(file_exists(__DIR__ . '/../../../storage/app/public/advs/' . $itr->file))
                unlink(__DIR__ . '/../../../storage/app/public/advs/' . $itr->file);

            DB::update("update project_buyers set adv = null, start_uploading_adv = null, adv_status = 0 where id = " . $itr->id);
        }

        $projects = DB::select("select p.physical, pb.complete_upload_adv, pb.complete_upload_file,".
            " p.id as projectId, p.title, concat(u.first_name, ' ', u.last_name) as name, u.id as user_id, " .
            "pb.id, pb.created_at, pb.adv, pb.file, pb.adv_status, pb.file_status " .
            "from project_buyers pb, project p, users u where p.id = pb.project_id" .
            " and pb.user_id = u.id and pb.status = false and u.grade_id = " . $gradeId . " and (select count(*) from project_grade where project_id = p.id and grade_id = " . $gradeId . ") > 0 order by pb.created_at desc"
        );

        $allTitles = [];

        foreach ($projects as $project) {
            $project->Bdate = getCustomDate($project->created_at);
            $project->date = MiladyToShamsi('', explode('-', explode(' ', $project->created_at)[0]));;
            $project->time = explode(' ', $project->created_at)[1];
            $allowAdd = true;

            foreach ($allTitles as $title) {
                if($project->title == $title) {
                    $allowAdd = false;
                    break;
                }
            }

            if($project->adv != null && $project->complete_upload_adv &&
                file_exists(__DIR__ . '/../../../public/storage/advs/' . $project->adv))
                $project->adv = URL::asset("storage/advs/" . $project->adv);
            else
                $project->adv = null;

            if($project->file != null && $project->complete_upload_file &&
                file_exists(__DIR__ . '/../../../public/storage/contents/' . $project->file))
                $project->file = URL::asset("storage/contents/" . $project->file);
            else
                $project->file = null;

            if($allowAdd)
                $allTitles[count($allTitles)] = $project->title;
        }

        return view("report.unDoneProjectsReport", ["projects" => $projects,
            'gradeId' => $gradeId, 'allTitles' => $allTitles, 'err' => $err]);
    }

    public function unDoneProjectsReportExcel($gradeId) {

        $projects = DB::select("select p.title, concat(u.first_name, ' ', u.last_name) as name, pb.id, pb.created_at from project_buyers pb, project p, users u where p.id = pb.project_id" .
            " and pb.user_id = u.id and pb.status = false and u.grade_id = " . $gradeId . " and (select count(*) from project_grade where project_id = p.id and grade_id = " . $gradeId . ") > 0 order by pb.created_at desc"
        );

        $allTitles = [];

        foreach ($projects as $project) {
            $project->Bdate = getCustomDate($project->created_at);
            $project->date = MiladyToShamsi('', explode('-', explode(' ', $project->created_at)[0]));;
            $project->time = explode(' ', $project->created_at)[1];

            $allowAdd = true;

            foreach ($allTitles as $title) {
                if($project->title == $title) {
                    $allowAdd = false;
                    break;
                }
            }

            if($allowAdd)
                $allTitles[count($allTitles)] = $project->title;
        }


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Karestoon");
        $objPHPExcel->getProperties()->setLastModifiedBy("Karestoon");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'تاریخ پذیرش پروژه');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'نام پروژه');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'نام کاربر');

        $i = 0;

        foreach ($projects as $project) {

            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2), $project->Bdate . '     ساعت     ' . $project->time);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2), $project->title);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), $project->name);

            $i++;

        }

        $fileName = __DIR__ . "/../../../public/tmp/karestoon.xlsx";

        $objPHPExcel->getActiveSheet()->setTitle('گزارش گیری آزمون ها');

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);


        if (file_exists($fileName)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            readfile($fileName);
            unlink($fileName);
        }

        return view("report.unDoneProjectsReport", ["projects" => $projects,
            'gradeId' => $gradeId, 'allTitles' => $allTitles]);
    }



    public function productsReport($gradeId = -1) {

        if($gradeId == -1)
            return view('report.usersReport', ['grades' => Grade::all(),
                "path" => route("productsReport")]);

        $products = DB::select("select t.id as tId, concat(u2.first_name, ' ', u2.last_name) as seller, " .
            "concat(u1.first_name, ' ', u1.last_name) as buyer, p.name, p.physical, " .
            "t.created_at from users u1, users u2, transactions t, product p, project_buyers pb where " .
            "t.product_id = p.id and pb.project_id = p.project_id and u2.id = pb.user_id and p.user_id = u2.id and " .
            "t.user_id = u1.id and u1.grade_id = " . $gradeId . " order by t.id desc"
        );

        $distinctProducts = [];

        foreach ($products as $product) {
            $product->date = MiladyToShamsi('', explode('-', explode(' ', $product->created_at)[0]));
            $product->time = explode(' ', $product->created_at)[1];
            if(!in_array($product->name, $distinctProducts))
                $distinctProducts[count($distinctProducts)] = $product->name;
        }

        return view("report.productsReport", ["products" => $products,
            'gradeId' => $gradeId, 'distinctProducts' => $distinctProducts]);
    }

    public function reminderProducts($gradeId = -1) {

        if($gradeId == -1)
            return view('report.usersReport', ['grades' => Grade::all(),
                "path" => route("reminderProducts")]);

        $products = DB::select("select p.id, concat(u2.first_name, ' ', u2.last_name) as seller, p.name, " .
            "p.star, p.price from users u2, product p, project_buyers pb where " .
            "pb.project_id = p.project_id and u2.id = pb.user_id and p.user_id = u2.id and " .
            "u2.grade_id = " . $gradeId . ' and (select count(*) from transactions where product_id = p.id) = 0'
        );

        return view("report.reminderProductsReport", ["products" => $products, 'gradeId' => $gradeId]);
    }

    public function advReport($gradeId = -1) {

        if($gradeId == -1)
            return view('report.usersReport', ['grades' => Grade::all(),
                "path" => route("advReport")]);

        $projects = DB::select('select pb.created_at, pb.id, p.title, concat(u.first_name, " ", u.last_name) as name, ' .
            'pb.adv_status, pb.adv from project_buyers pb, project p, users u where p.id = pb.project_id and ' .
            'pb.user_id = u.id and u.grade_id = ' . $gradeId . ' and pb.adv is not null'
        );

        $allTitles = [];
        foreach ($projects as $project) {

            $allowAdd = true;
            foreach ($allTitles as $title) {
                if($project->title == $title) {
                    $allowAdd = false;
                    break;
                }
            }

            if($allowAdd)
                $allTitles[count($allTitles)] = $project->title;

            if(file_exists(__DIR__ . '/../../../public/storage/advs/' . $project->adv))
                $project->adv = URL::asset("storage/advs/" . $project->adv);
            else
                $project->adv = null;

            $project->Bdate = getCustomDate($project->created_at);
            $project->date = MiladyToShamsi('', explode('-', explode(' ', $project->created_at)[0]));
            $project->time = explode(' ', $project->created_at)[1];

        }

        return view('report.advReport', ['projects' => $projects,
            'allTitles' => $allTitles]);
    }

    public function productsReportExcel($gradeId) {

        $products = DB::select("select t.id as tId, concat(u2.first_name, ' ', u2.last_name) as seller, " .
            "concat(u1.first_name, ' ', u1.last_name) as buyer, p.name, p.physical, " .
            "t.created_at from users u1, users u2, transactions t, product p, project_buyers pb where " .
            "t.product_id = p.id and pb.project_id = p.project_id and u2.id = pb.user_id and p.user_id = u2.id and " .
            "t.user_id = u1.id and u1.grade_id = " . $gradeId . " order by t.id desc"
        );

        $distinctProducts = [];

        foreach ($products as $product) {
            $product->date = MiladyToShamsi('', explode('-', explode(' ', $product->created_at)[0]));
            $product->time = explode(' ', $product->created_at)[1];

            if(!in_array($product->name, $distinctProducts))
                $distinctProducts[count($distinctProducts)] = $product->name;
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Karestoon");
        $objPHPExcel->getProperties()->setLastModifiedBy("Karestoon");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'تاریخ انجام معامله');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'عینی/غیرعینی');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'محصول');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'خریدار');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'فروشنده');

        $i = 0;

        foreach ($products as $product) {

            $bDate = $product->date . '  -  ' . $product->time;

            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2), $bDate);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2), ($product->physical) ? "عینی" : "غیرعینی");
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2), $product->name);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2), $product->buyer);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), $product->seller);

            $i++;
        }

        $fileName = __DIR__ . "/../../../public/tmp/karestoon.xlsx";

        $objPHPExcel->getActiveSheet()->setTitle('گزارش گیری آزمون ها');

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);


        if (file_exists($fileName)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            readfile($fileName);
            unlink($fileName);
        }

        return view("report.productsReport", [
            "products" => $products,'distinctProducts' => $distinctProducts,
            'gradeId' => $gradeId
        ]);
    }


    public function productProjectReport($gradeId = -1) {

        if($gradeId == -1)
            return view('report.usersReport', ['grades' => Grade::all(),
                "path" => route("productProjectReport")]);

        $users = User::whereGradeId($gradeId)->get();
        foreach ($users as $user) {

            $user->completeProjects = ProjectBuyers::whereUserId($user->id)->whereStatus(true)->count();
            $user->unCompleteProjects = ProjectBuyers::whereUserId($user->id)->whereStatus(false)->count();
            $user->completeServices = ServiceBuyer::whereUserId($user->id)->whereStatus(true)->count();
            $user->unCompleteServices = ServiceBuyer::whereUserId($user->id)->whereStatus(false)->count();
            $user->buys = Transaction::whereUserId($user->id)->count();
        }

        return view("report.productProjectReport", ["users" => $users, 'gradeId' => $gradeId]);
    }

    public function productProjectReportExcel($gradeId) {

        $users = User::whereGradeId($gradeId)->get();
        foreach ($users as $user) {

            $user->completeProjects = ProjectBuyers::whereUserId($user->id)->whereStatus(true)->count();
            $user->unCompleteProjects = ProjectBuyers::whereUserId($user->id)->whereStatus(false)->count();
            $user->completeServices = ServiceBuyer::whereUserId($user->id)->whereStatus(true)->count();
            $user->unCompleteServices = ServiceBuyer::whereUserId($user->id)->whereStatus(false)->count();
            $user->buys = Transaction::whereUserId($user->id)->count();
        }


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Karestoon");
        $objPHPExcel->getProperties()->setLastModifiedBy("Karestoon");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'تعداد خدمات ناتمام');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'تعداد خدمات انجام شده');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'تعداد محصولات خریداری شده');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'تعداد پروژه های ناتمام');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'تعداد پروژه های انجام شده');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'نام کاربر');

        $i = 0;

        foreach ($users as $user) {
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2), $user->unCompleteServices);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2), $user->completeServices);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2), $user->buys);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2), $user->unCompleteProjects);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2), $user->completeProjects);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), $user->first_name . ' ' . $user->last_name);
            $i++;
        }

        $fileName = __DIR__ . "/../../../public/tmp/karestoon.xlsx";

        $objPHPExcel->getActiveSheet()->setTitle('گزارش گیری آزمون ها');

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);


        if (file_exists($fileName)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            readfile($fileName);
            unlink($fileName);
        }

        return view("report.productProjectReport", ["users" => $users]);
    }


    public function userServices($uId) {

        $services = DB::select("select s.id, s.star as mainStars, s.title, sb.status, sb.star, sb.created_at from " .
            "service_buyer sb, service s where s.id = sb.service_id and " .
            "sb.user_id = " . $uId
        );

        foreach ($services as $service) {

            $service->date = MiladyToShamsi('', explode('-', explode(' ', $service->created_at)[0]));
            $service->time = explode(' ', $service->created_at)[1];

        }

        return view("report.userServices", ["services" => $services, 'uId' => $uId]);
    }

    public function userProjects($uId) {

        $projects = DB::select("select p.title, pb.status, pb.created_at from " .
            "project_buyers pb, project p where p.id = pb.project_id and " .
            "pb.user_id = " . $uId
        );

        foreach ($projects as $project) {

            $project->date = MiladyToShamsi('', explode('-', explode(' ', $project->created_at)[0]));
            $project->time = explode(' ', $project->created_at)[1];

        }

        return view("report.userProjects", ["projects" => $projects]);

    }

    public function serviceBuyers($id) {

        $preThreeHours = time() - 10800;

        $unCompleted = DB::select("select file, id from service_buyer where file is not null and file_status <> 1 and ".
        "complete_upload_file = 0 and start_uploading is not null and start_uploading < " . $preThreeHours);

        foreach ($unCompleted as $itr) {

            if(file_exists(__DIR__ . '/../../../storage/app/public/service_contents/' . $itr->file))
                unlink(__DIR__ . '/../../../storage/app/public/service_contents/' . $itr->file);

            DB::update("update service_buyer set file = null, start_uploading = null, file_status = 0 where id = " . $itr->id);
        }

        $service = Service::whereId($id);
        if($service == null)
            return Redirect::route("admin");

        $t = ServiceBuyer::whereServiceId($id)->get();

        $grades = Grade::all();

        if($t == null)
            $buyers = null;
        else {

            $tmp = [];

            foreach ($t as $itr) {
                $u = User::whereId($itr->user_id);
                foreach ($grades as $grade) {

                    if($grade->id != $u->grade_id)
                        continue;

                    $tmp[count($tmp)] =
                        ["name" => $u->first_name . ' ' . $u->last_name,
                        "id" => $u->id,
                        "sbId" => $itr->id,
                        'gradeName' => $grade->name,
                        'grade' => $u->grade_id,
                        "status" => $itr->status,
                        "file_status" => $itr->file_status,
                        "file" => ($itr->file != null && $itr->complete_upload_file && file_exists(__DIR__ . '/../../../storage/app/public/service_contents/' . $itr->file)) ? URL::asset('storage/service_contents/' . $itr->file) : null,
                        "date" => MiladyToShamsi('', explode('-', explode(' ', $itr->created_at)[0])),
                        "time" => explode(' ', $itr->created_at)[1],
                        "star" => $itr->star];
                }
            }

            $buyers = $tmp;
        }

        return view('report.serviceBuyers', ['buyers' => $buyers, 'grades' => $grades,
            "star" => $service->star, 'id' => $id, 'physical' => $service->physical]);

    }

    public function serviceBuyersExcel($id) {

        $service = Service::whereId($id);
        if($service == null)
            return Redirect::route("admin");

        $t = ServiceBuyer::whereServiceId($id)->get();

        $grades = Grade::all();

        if($t == null)
            $buyers = null;
        else {

            $tmp = [];

            foreach ($t as $itr) {
                $u = User::whereId($itr->user_id);
                foreach ($grades as $grade) {

                    if($grade->id != $u->grade_id)
                        continue;

                    $tmp[count($tmp)] =
                        ["name" => $u->first_name . ' ' . $u->last_name,
                            "id" => $u->id,
                            'gradeName' => $grade->name,
                            'grade' => $u->grade_id,
                            "status" => $itr->status,
                            "date" => MiladyToShamsi('', explode('-', explode(' ', $itr->created_at)[0])),
                            "time" => explode(' ', $itr->created_at)[1],
                            "star" => $itr->star];
                }
            }

            $buyers = $tmp;
        }


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Karestoon");
        $objPHPExcel->getProperties()->setLastModifiedBy("Karestoon");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'تعداد ستاره های داده شده');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'وضعیت انجام');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'تاریخ');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'پایه تحصیلی');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'نام کاربر');

        $i = 0;

        foreach ($buyers as $user) {
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2), ($user["status"]) ? $user["star"] : 0);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2), ($user["status"]) ? "انجام شده" : "انجام نشده");
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2), $user["date"] . ' - ' . $user["time"]);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2), $user["gradeName"]);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), $user["name"]);
            $i++;
        }

        $fileName = __DIR__ . "/../../../public/tmp/karestoon.xlsx";

        $objPHPExcel->getActiveSheet()->setTitle('گزارش گیری آزمون ها');

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);


        if (file_exists($fileName)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            readfile($fileName);
            unlink($fileName);
        }
        exit();
    }

    public function userBuys($uId) {

        $products = DB::select("select p.name, concat(u.first_name, ' ', u.last_name) as seller, p.price, t.created_at from " .
            "transactions t, product p, users u where p.user_id = u.id and " .
            " t.user_id = " . $uId . " and t.product_id = p.id"
        );

        foreach ($products as $product) {

            $product->date = MiladyToShamsi('', explode('-', explode(' ', $product->created_at)[0]));
            $product->time = explode(' ', $product->created_at)[1];

        }

        return view("report.userProducts", ["products" => $products]);

    }

    public function serviceReport() {

        $services = Service::all();
        return view('report.serviceReport', ['services' => $services]);

    }
}
