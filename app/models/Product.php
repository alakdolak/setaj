<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Product'
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $star
 * @property boolean $hide
 * @property boolean $physical
 * @property boolean $extra
 * @property string $name
 * @property string $description
 * @property integer $price
 * @property integer $project_id
 * @property integer $grade_id
 * @property string $start_show
 * @property string $start_time
 * @property string $start_date_buy
 * @property string $start_time_buy
 * @method static \Illuminate\Database\Query\Builder|\App\models\Product whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Product whereProjectId($value)
 */

class Product extends Model {

    public $table = 'product';

    public static function whereId($value) {
        return Product::find($value);
    }
}
