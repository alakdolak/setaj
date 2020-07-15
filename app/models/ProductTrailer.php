<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ProductTrailer'
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProductTrailer whereProductId($value)
 */

class ProductTrailer extends Model {
    public $table = 'product_trailer';
    public $timestamps = false;
}
