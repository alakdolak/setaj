<?php

namespace App\Http\Controllers;

use App\models\Grade;
use App\models\ProjectBuyers;
use App\models\ServiceBuyer;
use App\models\Transaction;
use App\models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {

    public function usersReport($gradeId = -1) {

        if($gradeId == -1)
            return view('report.usersReport', ['grades' => Grade::all(),
                "path" => route("usersReport")]);

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

        return view('report.usersReportGrade', ['users' => $students, 'gradeId' => $gradeId]);
    }

    public function unDoneProjectsReport($gradeId = -1) {

        if($gradeId == -1)
            return view('report.usersReport', ['grades' => Grade::all(),
                "path" => route("unDoneProjectsReport")]);

        $projects = DB::select("select p.title, concat(u.first_name, ' ', u.last_name) as name from project_buyers pb, project p, users u where p.id = pb.project_id" .
            " and pb.user_id = u.id and pb.status = false and (select count(*) from project_grade where project_id = p.id and grade_id = " . $gradeId . ") > 0"
        );

        return view("report.unDoneProjectsReport", ["projects" => $projects]);
    }

    public function productsReport($gradeId = -1) {

        if($gradeId == -1)
            return view('report.usersReport', ['grades' => Grade::all(),
                "path" => route("productsReport")]);

        $products = DB::select("select concat(u2.first_name, ' ', u2.last_name) as seller, concat(u1.first_name, ' ', u1.last_name) as buyer, p.name, " .
            "t.created_at from users u1, users u2, transactions t, product p, project_buyers pb where " .
            "t.product_id = p.id and pb.project_id = p.project_id and u2.id = pb.user_id and " .
            "t.user_id = u1.id"
        );

        foreach ($products as $product) {
            $product->date = MiladyToShamsi('', explode('-', explode(' ', $product->created_at)[0]));
        }

        return view("report.productsReport", ["products" => $products]);
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

        return view("report.productProjectReport", ["users" => $users]);
    }

    public function userServices($uId) {

        $services = DB::select("select s.title, sb.status, sb.star from " .
            "service_buyer sb, service s where s.id = sb.service_id and " .
            "sb.user_id = " . $uId
        );

        return view("report.userServices", ["services" => $services]);
    }

    public function userProjects($uId) {

        $projects = DB::select("select p.title, pb.status from " .
            "project_buyers pb, project p where p.id = pb.project_id and " .
            "pb.user_id = " . $uId
        );

        return view("report.userProjects", ["projects" => $projects]);

    }


    public function userBuys($uId) {

        $products = DB::select("select p.name, concat(u.first_name, ' ', u.last_name) as seller, p.price from " .
            "project_buyers pb, transactions t, product p, users u where p.project_id = pb.project_id and " .
            " t.user_id = " . $uId . " and pb.user_id = u.id"
        );

        return view("report.userProducts", ["products" => $products]);

    }
}
