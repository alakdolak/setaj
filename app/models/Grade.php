<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Grade'
 *
 * @property integer $id
 * @property string $name
 */

class Grade extends Model {

    public $table = 'grade';
    public $timestamps = false;

    public static function whereId($value) {
        return Grade::find($value);
    }
}
