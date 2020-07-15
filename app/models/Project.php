<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Project'
 *
 * @property integer $id
 * @property string $title
 * @property boolean $hide
 * @property string $description
 * @property string $start_reg
 * @property integer $capacity
 * @property string $end_reg
 * @property integer $price
 * @method static \Illuminate\Database\Query\Builder|\App\models\Project whereGradeId($value)
 */

class Project extends Model {

    public $table = 'project';

    public static function whereId($value) {
        return Project::find($value);
    }
}
