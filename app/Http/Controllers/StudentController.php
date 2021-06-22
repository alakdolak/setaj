<?php

namespace App\Http\Controllers;

use App\models\ProjectBuyers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

}
