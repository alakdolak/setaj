<?php

namespace App\Http\Controllers;

use App\models\Citizen;
use App\models\ProjectBuyers;
use App\models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller {

    public function addAdv(Request $request) {

        if($request->hasFile("file") && $request->has("id")) {

            $b = ProjectBuyers::whereId($request->get("id"));
            if($b == null || $b->user_id != Auth::user()->id || $b->status)
                return "nok";

            $path = $request->file->store("public/advs");
            $b->adv = str_replace("public/advs/", "", $path);
            $b->adv_status = 0;
            $b->save();
            return "ok";
        }

        return "nok";
    }


    public function addFile(Request $request) {

        if($request->hasFile("file") && $request->has("id")) {

            $b = ProjectBuyers::whereId($request->get("id"));
            if($b == null || $b->user_id != Auth::user()->id || $b->status)
                return Redirect::route('profile');

            $path = $request->file->store("public/contents");
            $b->file = str_replace("public/contents/", "", $path);
            $b->file_status = 0;
            $b->save();

        }

        return Redirect::route('profile');
    }


    public function getMyCitizenPoints() {

        $tags = Tag::whereType("CITIZEN")->get();
        $uId = Auth::user()->id;
        $points = [];
        $counter = 0;

        foreach ($tags as $tag) {
            $query = DB::select('select sum(cb.point) as sum_ from citizen c, citizen_buyers cb where ' .
                'c.id = cb.project_id and c.tag_id = ' . $tag->id . ' and cb.user_id = ' . $uId);
            $points[$counter++] = ["point" => ($query[0]->sum_ == null) ? 0 : $query[0]->sum_,
                "id" => $tag->id];
        }

        return json_encode(["status" => "ok", "points" => $points]);
    }
}
