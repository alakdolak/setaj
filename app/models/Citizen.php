<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Citizen'
 *
 * @property integer $id
 * @property string $title
 * @property boolean $hide
 * @property string $description
 * @property string $start_reg
 * @property string $start_show
 * @property string $start_time
 * @property string $end_reg
 * @property integer $point
 * @property integer $tag_id
 * @method static \Illuminate\Database\Query\Builder|\App\models\Citizen whereGradeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Citizen whereTagId($value)
 */

class Citizen extends Model {

    public $table = 'citizen';

    public static function whereId($value) {
        return Citizen::find($value);
    }
}
