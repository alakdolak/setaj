<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ProductAttach'
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProductAttach whereProductId($value)
 */

class ProductAttach extends Model {
    public $table = 'product_attach';
    public $timestamps = false;
}
