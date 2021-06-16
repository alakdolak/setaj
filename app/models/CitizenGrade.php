<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'CitizenGrade'
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $grade_id
 * @method static \Illuminate\Database\Query\Builder|\App\models\CitizenGrade whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\CitizenGrade whereGradeId($value)
 */

class CitizenGrade extends Model {
    public $table = 'citizen_grade';
    public $timestamps = false;
}
