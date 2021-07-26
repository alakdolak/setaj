<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'PayPingTransaction'
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $good_id
 * @property integer $pay
 * @property integer $status
 * @property boolean $post
 * @property string $ref_id
 * @method static \Illuminate\Database\Query\Builder|\App\models\PayPingTransaction whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\PayPingTransaction whereGoodId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\PayPingTransaction whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\PayPingTransaction whereRefId($value)
 */

class PayPingTransaction extends Model {

    public $table = 'pay_ping_transactions';

    public static function whereId($value) {
        return PayPingTransaction::find($value);
    }
}
