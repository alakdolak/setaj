<?php

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

    include_once 'jdate.php';
    $w = jdate("w");

    if($w == 3 || $w == 5 || $w == 6 || $w == 1 || $w == 2) {

        $time = getToday()["time"];

        if($time[0] == "0")
            $time = (int)substr($time, 1);
        else
            $time = (int)$time;

        if($time >= 800 && $time <= 1900)
            return true;

    }

    return false;
}

function getReminderToNextTime() {

    $w = jdate("w");

    $out = ["day" => 0, "hour" => 0];
    $time = getToday()["time"];

    if($time[0] == "0")
        $time = (int)substr($time, 1);
    else
        $time = (int)$time;

    if($w < 3) {
        if($time < 800) {
            $out["day"] = 3 - $w;
            $out["time"] = floor((800 - $time) / 100);
        }
        else {
            $out["day"] = 3 - $w - 1;
            $out["time"] = 24 - floor(($time - 800) / 100);
        }
    }
    else if($w < 5) {
        if($time < 800) {
            $out["day"] = 5 - $w;
            $out["time"] = floor((800 - $time) / 100);
        }
        else {
            $out["day"] = 5 - $w - 1;
            $out["time"] = 24 - floor(($time - 800) / 100);
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

function convertStringToTime($time) {
    return $time[0] . $time[1] . ":" . $time[2] . $time[3];
}
