<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Medal'
 *
 * @property integer $id
 * @property string $name
 * @property string $pic
 * @property string $8
 * @property string $9
 * @property string $10
 */

class Medal extends Model {

    public $table = 'medal';

    public static function whereId($value) {
        return Medal::find($value);
    }
}
