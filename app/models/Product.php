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
 * @property string $name
 * @property string $description
 * @property integer $price
 * @property integer $project_id
 * @method static \Illuminate\Database\Query\Builder|\App\models\Product whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Product whereProjectId($value)
 */

class Product extends Model {

    public $table = 'product';

    public static function whereId($value) {
        return Product::find($value);
    }
}
