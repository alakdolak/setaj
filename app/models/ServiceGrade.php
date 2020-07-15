<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ServiceGrade'
 *
 * @property integer $id
 * @property integer $service_id
 * @property integer $grade_id
 * @method static \Illuminate\Database\Query\Builder|\App\models\ServiceGrade whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\ServiceGrade whereGradeId($value)
 */

class ServiceGrade extends Model {
    public $table = 'service_grade';
    public $timestamps = false;
}
