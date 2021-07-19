<?php

namespace App\Http\Controllers;

use App\models\Product;
use App\models\ProjectBuyers;
use App\models\ServiceBuyer;
use App\models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class StudentController extends Controller {

    public function addAdv(Request $request) {

        if(
            $request->hasFile("file") &&
            $request->has("dzchunkindex") &&
            $request->has("dztotalchunkcount") &&
            $request->has("id")
        ) {

            $idx = $request->get("dzchunkindex");
            $total = $request->get("dztotalchunkcount");

            if($idx >= $total)
                return response()->json(["status" => "nok"], 401);

            $b = ProjectBuyers::whereId($request->get("id"));

            if($b == null || $b->user_id != Auth::user()->id ||
                $b->adv_status == 1 || $b->complete_upload_adv)
                return response()->json(["status" => "nok"], 401);

            if($idx == 0) {

                if($b->status) {

                    $p = Product::whereUserId(Auth::user()->id)->whereProjectId($b->project_id)->first();
                    if ($p == null)
                        return response()->json(["status" => "nok"], 401);

                    $today = getToday();
                    $time = $today["time"];
                    $today = $today["date"];

                    if($p->start_show < $today ||
                        ($p->start_show == $today && $p->start_time < $time)
                    )
                        return response()->json(["status" => "nok"], 401);
                }

//                $filename = $request->file("file")->getClientOriginalName();
//                $filename = str_replace('.' . $request->file('file')->getClientOriginalExtension(), '', $filename);

                $path = $request->file('file')->storeAs("public/advs",
                    time() . "." .
                    $request->file("file")->getClientOriginalExtension()
                );

                $b->adv = str_replace("public/advs/", "", $path);
                $b->adv_status = 0;
                $b->start_uploading_adv = time();

                if($idx == $total - 1)
                    $b->complete_upload_adv = true;

                $b->save();
            }
            else {

                $path = __DIR__ . '/../../../storage/app/public/advs/' . $b->adv;
                if(!file_exists($path))
                    return "nok";

                file_put_contents($path, $request->file("file")->get(), FILE_APPEND);

                if($idx == $total - 1) {
                    $b->complete_upload_adv = true;
                    $b->save();
                }
            }

            return "ok";
        }

        return response()->json(["status" => "nok"], 401);
    }


    public function addFile(Request $request) {

        if(
            $request->hasFile("file") &&
            $request->has("dzchunkindex") &&
            $request->has("dztotalchunkcount") &&
            $request->has("id")
        ) {

            $idx = $request->get("dzchunkindex");
            $total = $request->get("dztotalchunkcount");

            if($idx >= $total)
                return response()->json(["status" => "nok"], 401);

            $b = ProjectBuyers::whereId($request->get("id"));

            if($b == null || $b->user_id != Auth::user()->id || $b->status ||
                $b->file_status == 1
            )
                return response()->json(["status" => "nok"], 401);

            if($idx == 0) {

//                $filename = $request->file("file")->getClientOriginalName();
//                $filename = str_replace('.' . $request->file('file')->getClientOriginalExtension(), '', $filename);

                $path = $request->file('file')->storeAs("public/contents",
                    time() . "." .
                    $request->file("file")->getClientOriginalExtension()
                );

                $b->file = str_replace("public/contents/", "", $path);
                $b->file_status = 0;
                $b->start_uploading = time();

                if($idx == $total - 1)
                    $b->complete_upload_file = true;

                $b->save();
            }
            else {

                $path = __DIR__ . '/../../../storage/app/public/contents/' . $b->file;
                if(!file_exists($path))
                    return response()->json(["status" => "nok"], 401);

                file_put_contents($path, $request->file("file")->get(), FILE_APPEND);

                if($idx == $total - 1) {
                    $b->complete_upload_file = true;
                    $b->save();
                }

            }

            return "ok";
        }

        return response()->json(["status" => "nok"], 401);
    }


    public function addServiceFile(Request $request) {

        if(
            $request->hasFile("file") &&
            $request->has("dzchunkindex") &&
            $request->has("dztotalchunkcount") &&
            $request->has("id")
        ) {

            $idx = $request->get("dzchunkindex");
            $total = $request->get("dztotalchunkcount");

            if($idx >= $total)
                return response()->json(["status" => "nok"], 401);

            $b = ServiceBuyer::whereId($request->get("id"));

            if($b == null || $b->user_id != Auth::user()->id || $b->status ||
                $b->file_status == 1 || $b->complete_upload_file
            )
                return response()->json(["status" => "nok"], 401);

            if($idx == 0) {

//                $filename = $request->file("file")->getClientOriginalName();
//                $filename = str_replace('.' . $request->file('file')->getClientOriginalExtension(), '', $filename);

                $path = $request->file('file')->storeAs("public/service_contents",
                    time() . "." .
                    $request->file("file")->getClientOriginalExtension()
                );

                $b->file = str_replace("public/service_contents/", "", $path);
                $b->file_status = 0;
                $b->start_uploading = time();

                if($idx == $total - 1)
                    $b->complete_upload_file = true;

                $b->save();
            }
            else {

                $path = __DIR__ . '/../../../storage/app/public/service_contents/' . $b->file;
                if(!file_exists($path))
                    return response()->json(["status" => "nok"], 401);

                file_put_contents($path, $request->file("file")->get(), FILE_APPEND);

                if($idx == $total - 1) {
                    $b->complete_upload_file = true;
                    $b->save();
                }
            }

            return "ok";
        }

        return response()->json(["status" => "nok"], 401);
    }


    public function getMyCitizenPoints() {

        $tags = Tag::whereType("CITIZEN")->orderBy("id", "asc")->get();
        $uId = Auth::user()->id;
        $points = [];
        $counter = 0;
        $localPoints = [];

        foreach ($tags as $tag) {
            $query = DB::select('select sum(cb.point) as sum_ from citizen c, citizen_buyers cb where ' .
                'c.id = cb.project_id and c.tag_id = ' . $tag->id . ' and cb.user_id = ' . $uId);
            $points[$counter] = ["point" => ($query[0]->sum_ == null) ? 0 : $query[0]->sum_,
                "id" => $tag->id];

            $localPoints[$counter] = $points[$counter]["point"];
            $counter++;
        }

        $medal = DB::select("select name, pic from medal where `8` <= " .$localPoints[0]
            . " and `9` <= " . $localPoints[1] . " and `10` <= " . $localPoints[2] . " order by id desc limit 0, 1");

        if($medal != null && count($medal) > 0) {
            $medal = $medal[0];
            $medal->pic = URL::asset("images/" . $medal->pic);
        }
        else {
            $medal = [
                "pic" => URL::asset("images/0.png"),
                "name" => "شما با کسب 20 امتیاز در هر سه حوزه شهروندی، اولین نشان را کسب خواهید کرد."
            ];
        }

        return json_encode(["status" => "ok", "points" => $points, 'medal' => $medal]);
    }
}
