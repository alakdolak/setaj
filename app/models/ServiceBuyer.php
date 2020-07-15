<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ServiceBuyer'
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $star
 * @property integer $service_id
 * @property boolean $status
 * @method static \Illuminate\Database\Query\Builder|\App\models\ServiceBuyer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\ServiceBuyer whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\ServiceBuyer whereStatus($value)
 */

class ServiceBuyer extends Model {

    public $table = 'service_buyer';
    public $timestamps = false;

    public static function whereId($value) {
        return ServiceBuyer::find($value);
    }
}
