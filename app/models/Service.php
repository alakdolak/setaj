<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Service'
 *
 * @property integer $id
 * @property integer $star
 * @property integer $capacity
 * @property boolean $hide
 * @property string $title
 * @property string $start_show
 * @property string $start_time
 * @property string $start_buy
 * @property string $buy_time
 * @property string $description
 * @property boolean $physical
 * @method static \Illuminate\Database\Query\Builder|\App\models\Service whereHide($value)
 */

class Service extends Model {

    public $table = 'service';

    public static function whereId($value) {
        return Service::find($value);
    }
}
