<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ProjectAttach'
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProjectAttach whereProjectId($value)
 */

class ProjectAttach extends Model {
    public $table = 'project_attach';
    public $timestamps = false;
}
