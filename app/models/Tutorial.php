<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Tutorial'
 *
 * @property integer $id
 * @property string $title
 * @property string $path
 * @property string $pic
 */

class Tutorial extends Model {

    public $table = 'tutorials';
    public $timestamps = false;

    public static function whereId($value) {
        return Tutorial::find($value);
    }
}
