<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'GoodPic'
 *
 * @property integer $id
 * @property integer $good_id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\models\GoodPic whereGoodId($value)
 */

class GoodPic extends Model {
    public $table = 'good_pic';
    public $timestamps = false;
}
