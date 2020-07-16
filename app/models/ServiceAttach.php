<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ServiceAttach'
 *
 * @property integer $id
 * @property integer $service_id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\models\ServicePic whereServiceId($value)
 */

class ServiceAttach extends Model {
    public $table = 'service_attach';
    public $timestamps = false;
}
