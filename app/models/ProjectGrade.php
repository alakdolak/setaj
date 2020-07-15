<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ProjectGrade'
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $grade_id
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProjectGrade whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProjectGrade whereGradeId($value)
 */

class ProjectGrade extends Model {
    public $table = 'project_grade';
    public $timestamps = false;
}
