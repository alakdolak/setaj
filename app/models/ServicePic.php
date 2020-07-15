<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ServicePic'
 *
 * @property integer $id
 * @property integer $service_id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\models\ServicePic whereServiceId($value)
 */

class ServicePic extends Model {
    public $table = 'service_pic';
    public $timestamps = false;
}
