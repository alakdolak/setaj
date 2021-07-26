<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Activation'
 *
 * @property integer $id
 * @property string $nid
 * @property string $phone
 * @property string $name
 * @property string $token
 * @property string $code
 * @property string $send_time
 * @property string $last_name
 * @method static \Illuminate\Database\Query\Builder|\App\models\Activation whereNid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Activation wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Activation whereCode($value)
 */

class Activation extends Model {

    public $table = 'activation';

    public static function whereId($value) {
        return Activation::find($value);
    }
}
