<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Good'
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $tag
 * @property boolean $hide
 * @property string $description
 * @property integer $price
 * @property string $start_show
 * @property string $adv
 * @property string $code
 * @property string $owner
 * @property string $start_time
 * @property string $start_date_buy
 * @property string $start_time_buy
 * @method static \Illuminate\Database\Query\Builder|\App\models\Good whereUserId($value)
 */

class Good extends Model {

    public $table = 'good';
    public $timestamps = false;

    public static function whereId($value) {
        return Good::find($value);
    }
}
