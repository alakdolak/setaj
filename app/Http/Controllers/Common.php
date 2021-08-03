<?php

use App\models\ConfigModel;
use App\models\Tag;
use Illuminate\Support\Facades\DB;

function translatePersian($str) {

    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];

    $num = range(0, 9);
    $convertedPersianNums = str_replace($persian, $num, $str);
    $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

    return $englishNumbersOnly;
}

function makeValidInput($input) {
    $input = addslashes($input);
    $input = trim($input);
    if(get_magic_quotes_gpc())
        $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function _custom_check_national_code($code) {

    if(!preg_match('/^[0-9]{10}$/',$code))
        return false;

    for($i=0;$i<10;$i++)
        if(preg_match('/^'.$i.'{10}$/',$code))
            return false;
    for($i=0,$sum=0;$i<9;$i++)
        $sum+=((10-$i)*intval(substr($code, $i,1)));
    $ret=$sum%11;
    $parity=intval(substr($code, 9,1));
    if(($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
        return true;
    return false;
}

function getCustomDate($timestamp) {

    include_once 'jdate.php';
    $x = strtotime($timestamp);
    return jstrftime('%d %B', $x);

}

function MiladyToShamsi($time, $date = ""){

    include_once 'jdate.php';

    if(empty($date)) {
        $date = $time->format('Y-m-d');
        $date = explode('-', $date);
    }
    return gregorian_to_jalali($date[0],$date[1],$date[2],'-');
}

function MiladyToShamsiTime($time){

    include_once 'jdate.php';
    $x = strtotime("+270 minutes", $time);

    return jstrftime('%H:%M:%S', $x);
}

function getValueInfo($key) {

    $values = [
        "studentLevel" => 1, 'operatorLevel' => 2,'adminLevel' => 3,
        "projectMode" => 1, "productMode" => 2, "serviceMode" => 3,
    ];

    return $values[$key];

}

function uploadCheck($target_file, $name, $section, $limitSize, $ext) {

    $err = "";
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $uploadOk = 1;
    $check = true;

    if($ext != "xlsx")
        $check = getimagesize($_FILES[$name]["tmp_name"]);

    if($check === false) {
        $err .= "فایل ارسالی در قسمت " . $section . " معتبر نمی باشد" .  "<br />";
        $uploadOk = 0;
    }

    if ($uploadOk == 1 && $_FILES[$name]["size"] > $limitSize)
        $err .= "حداکثر حجم مجاز برای آپلود تصویر $limitSize کیلو بایت می باشد" . "<br />";

    $imageFileType = strtolower($imageFileType);

    if($ext != -1 && $imageFileType != $ext)
        $err .= "شما تنها فایل های $ext. را می توانید در این قسمت آپلود نمایید" . "<br />";
    return $err;
}

function upload($target_file, $name, $section) {
    $err = "";
    try {
        move_uploaded_file($_FILES[$name]["tmp_name"], $target_file);
    }
    catch (Exception $x) {
        return "اشکالی در آپلود تصویر در قسمت " . $section . " به وجود آمده است" . "<br />";
    }
    return "";
//        $err .= ;
//    return $err;
}

function generateActivationCode() {
    return rand(10000, 99999);
}

function getProjectLimit($gradeId) {

    $config = ConfigModel::first();

    switch ($gradeId) {
        case 3:
        default:
            return $config->project_limit_7;
        case 4:
            return $config->project_limit_2;
        case 5:
            return $config->project_limit_3;
        case 6:
            return $config->project_limit_4;
        case 7:
            return $config->project_limit_5;
        case 8:
            return $config->project_limit_6;
        case 9:
            return $config->project_limit_1;
    }

}

function getExtraProjectLimit($user) {

    $config = ConfigModel::first();

    switch ($user->grade_id) {
        case 4:
            $minHealth = $config->min_health_2;
            $minThink = $config->min_think_2;
            $minBehavior = $config->min_behavior_2;
            $minMoney = $config->min_money_2;
            $minStar = $config->min_star_2;
            break;
        case 5:
            $minHealth = $config->min_health_3;
            $minThink = $config->min_think_3;
            $minBehavior = $config->min_behavior_3;
            $minMoney = $config->min_money_3;
            $minStar = $config->min_star_3;
            break;
        case 6:
            $minHealth = $config->min_health_4;
            $minThink = $config->min_think_4;
            $minBehavior = $config->min_behavior_4;
            $minMoney = $config->min_money_4;
            $minStar = $config->min_star_4;
            break;
        case 7:
            $minHealth = $config->min_health_5;
            $minThink = $config->min_think_5;
            $minBehavior = $config->min_behavior_5;
            $minMoney = $config->min_money_5;
            $minStar = $config->min_star_5;
            break;
        case 8:
            $minHealth = $config->min_health_6;
            $minThink = $config->min_think_6;
            $minBehavior = $config->min_behavior_6;
            $minMoney = $config->min_money_6;
            $minStar = $config->min_star_6;
            break;
        case 9:
        default:
            $minHealth = $config->min_health;
            $minThink = $config->min_think;
            $minBehavior = $config->min_behavior;
            $minMoney = $config->min_money;
            $minStar = $config->min_star;
            break;
    }

    if($minHealth > 0 ||
        $minThink > 0 ||
        $minBehavior > 0
    ) {

        $points = [];
        $counter = 0;

        $tags = Tag::whereType("CITIZEN")->orderBy("id", "asc")->get();

        foreach ($tags as $tag) {
            $query = DB::select('select sum(cb.point) as sum_ from citizen c, citizen_buyers cb where ' .
                'c.id = cb.project_id and c.tag_id = ' . $tag->id . ' and cb.user_id = ' . $user->id);
            $points[$tag->id] = ($query[0]->sum_ == null) ? 0 : $query[0]->sum_;
            $counter++;
        }

        if($points["8"] < $minHealth ||
            $points["9"] < $minThink ||
            $points["10"] < $minBehavior) {
            return -1;
        }
    }

    if($user->money < $minMoney || $user->stars < $minStar)
        return -1;

    return $config->extra_limit;
}

function getToday() {

    include_once 'jdate.php';

    $jalali_date = jdate("c");

    $date_time = explode('-', $jalali_date);

    $subStr = explode('/', $date_time[0]);

    $day = $subStr[0] . $subStr[1] . $subStr[2];

    $time = explode(':', $date_time[1]);

    $time = $time[0] . $time[1];

    return ["date" => $day, "time" => $time];
}

function siteTime() {

    if(\Illuminate\Support\Facades\Auth::check() &&
        \Illuminate\Support\Facades\Auth::user()->super_active)
        return true;

    include_once 'jdate.php';
    $w = jdate("w");

    if($w == 5 || $w == 6) {

        $time = getToday()["time"];

        if($time[0] == "0")
            $time = (int)substr($time, 1);
        else
            $time = (int)$time;

        if($time >= 900 && $time <= 2100)
            return true;

    }

    return false;
}

function getReminderToNextTime() {

    $w = jdate("w");

    $out = ["day" => 0, "time" => 0];
    $time = getToday()["time"];

    if($time[0] == "0")
        $time = (int)substr($time, 1);
    else
        $time = (int)$time;

    if($w < 5) {
        if($time < 900) {
            $out["day"] = 5 - $w;
            $out["time"] = floor((900 - $time) / 100);
        }
        else {
            $out["day"] = 5 - $w - 1;
            $out["time"] = 24 - floor(($time - 900) / 100);
        }
    }
    else if($w == 5) {

        $out["day"] = 0;

        if($time > 2100) {
            $out["time"] = 24 - floor(($time - 900) / 100);
        }
        else {
            $out["time"] = floor((900 -$time) / 100);
        }
    }
    else if($w == 6) {
        if($time > 2100) {
            $out["day"] = 3;
            $out["time"] = 24 - floor(($time - 900) / 100);
        }
        else {
            $out["day"] = 0;
            $out["time"] = floor((900 - $time) / 100);
        }
    }

    return $out;
}

function getFirstDayOfWeekDate() {

    $w = jdate("w");

    if($w == 0)
        return getToday()["today"];

    else if($w == 1)
        return getPast("-1 day");

    return getPast("-" . $w . ' days');
}

function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                    rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                else
                    unlink($dir. DIRECTORY_SEPARATOR .$object);
            }
        }
        rmdir($dir);
    }
}


function getPast($past) {

    include_once 'jdate.php';

    $jalali_date = jdate("c", $past);

    $date_time = explode('-', $jalali_date);

    $subStr = explode('/', $date_time[0]);

    return $subStr[0] . $subStr[1] . $subStr[2];
}

function convertStringToDate($date) {
    return $date[0] . $date[1] . $date[2] . $date[3] . '/' . $date[4] . $date[5] . '/' . $date[6] . $date[7];
}

function convertDateToString($date) {
    $subStrD = explode('/', $date);
    return $subStrD[0] . $subStrD[1] . $subStrD[2];
}

function convertDateToString2($date, $delimeter) {
    $subStrD = explode($delimeter, $date);

    if($subStrD[1] < 10)
        $subStrD[1] = "0" . $subStrD[1];

    if($subStrD[2] < 10)
        $subStrD[2] = "0" . $subStrD[2];

    return $subStrD[0] . $subStrD[1] . $subStrD[2];
}

function convertTimeToString($date) {

    $subStrD = explode(":", $date);
    if($subStrD[0][0] == "0")
        $subStrD[0] = $subStrD[0][1];

    return $subStrD[0] . $subStrD[1];
}

function convertStringToTime($time) {

    if(strlen($time) == 3)
        return "0" . $time[0] . ":" . $time[1] . $time[2];

    return $time[0] . $time[1] . ":" . $time[2] . $time[3];
}

function findDiffWithSiteStart() {

    for($i = 2; $i <= 63; $i++) {

        if("14000402" == getPast("- " . $i . ' days')) {
            return $i;
        }
    }

    return -1;
}

function sendSMS($destNum, $text, $templateId, $text2 = "", $text3 = "") {
//
//    $templateId = "karestoonVerify";
//    if($destNum[0] == "0" && $destNum[1] == "9") {
//
//        require __DIR__ . '/../../../vendor/autoload.php';
//
//        try {
//            $api = new \Kavenegar\KavenegarApi("703146316B34466B616364612B616C786B692F3155775432312F67344B434144424E63752B306431464B633D");
////        $sender = "10000008008080";
////        $result = $api->Send("30006703323323","09214915905","خدمات پیام کوتاه کاوه نگار");
//            $result = $api->VerifyLookup($destNum, $text, $text2, $text3, $templateId);
//
//            if ($result) {
//                foreach ($result as $r) {
//                    return $r->messageid;
//                }
//            }
//        } catch (\Kavenegar\Exceptions\ApiException $e) {
//            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
////            echo $e->errorMessage();
//            return -1;
//        } catch (\Kavenegar\Exceptions\HttpException $e) {
//            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
////            echo $e->errorMessage();
//            return -1;
//        }
//        return -1;
//    }

    return -1;
}
