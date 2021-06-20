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
                return Redirect::route('profile');

            $path = $request->file->store("advs");
            $b->adv = str_replace("adv/", "", $path);
            $b->save();
        }

        return Redirect::route('profile');
    }


    public function addFile(Request $request) {

        if($request->hasFile("file") && $request->has("id")) {

            $b = ProjectBuyers::whereId($request->get("id"));
            if($b == null || $b->user_id != Auth::user()->id || $b->status)
                return Redirect::route('profile');

            $path = $request->file->store("contents");
            $b->file = str_replace("contents/", "", $path);
            $b->save();

        }

        return Redirect::route('profile');
    }

}
