<?php

namespace App\Http\Controllers;

use App\models\Good;
use App\models\PayPingTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PayPing\Payment;

class TransactionController extends Controller {

    private static $token = "3fc8cb29caf7ce6709f8bc7666de4b076a5a38845b92c316a4c37486987b0d88";

    public function buy($goodId) {

        if(isset($_POST["sendMethod"]) && isset($_POST["address"])) {

            $sendMethod = makeValidInput($_POST["sendMethod"]);
            if ($sendMethod != "come" && $sendMethod != "post")
                return "nok3";

            $address = makeValidInput($_POST["address"]);
            if(empty($address))
                return "nok3";

            $userId = Auth::user()->id;

            $good = Good::whereId($goodId);

            if($good == null)
                return "nok3";

            $today = getToday();
            $date = $today["date"];
            $time = (int)$today["time"];

            if (
                $good->start_date_buy > $date ||
                ($good->start_date_buy == $date && $good->start_time_buy > $time)
            )
                return "nok1";

            if(PayPingTransaction::whereGoodId($goodId)->count() > 0)
                return "nok2";

            $t = new PayPingTransaction();
            $t->user_id = $userId;
            $t->good_id = $goodId;

            if($sendMethod == "post")
                $t->address = $address;
            else
                $t->address = "";

            $t->post = ($sendMethod == "post");
            $t->pay = $good->price;
            $t->save();

            $args = [
                "amount" => $good->price,
                "payerIdentity" => $userId,
                "returnUrl" => route('verifyPayment'),
                "clientRefId" => $t->id
            ];

            $payment = new Payment(self::$token);

            try {
                $payment->pay($args);
                return $payment->getPayUrl();
            }
            catch (\Exception $e) {
                dd($e->getMessage());
            }
        }
        return "nok3";
    }

    public function verifyPayment() {

        if(isset($_GET["refid"]) && isset($_GET["clientrefid"])) {

            $t = PayPingTransaction::whereId(makeValidInput($_GET["clientrefid"]));
            if($t == null)
                return Redirect::route('failTransaction');

            $payment = new Payment(self::$token);

            try {
                if ($payment->verify($_GET['refid'], $t->pay)) {
                    $t->ref_id = makeValidInput($_GET["refid"]);
                    $t->status = 1;
                    $t->save();
                    return Redirect::route('successTransaction', ['id' => $t->id]);
                }
            } catch (\Exception $e) {
                dd($e->getMessage());
//                foreach (json_decode($e->getMessage(), true) as $msg) {
//                    echo $msg;
//                }
            }

            return Redirect::route('failTransaction');
        }

        return view('home');
    }

}
