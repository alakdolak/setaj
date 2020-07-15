<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ProjectPic'
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProjectPic whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProjectPic whereName($value)
 */

class ProjectPic extends Model {
    public $table = 'project_pic';
    public $timestamps = false;
}
