<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Tag'
 *
 * @property integer $id
 * @property string $name
 */

class Tag extends Model {

    public $table = 'tag';
    public $timestamps = false;

    public static function whereId($value) {
        return Tag::find($value);
    }
}
