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
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\App\models\Service whereHide($value)
 */

class Service extends Model {

    public $table = 'service';

    public static function whereId($value) {
        return Service::find($value);
    }
}
