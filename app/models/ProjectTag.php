<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ProjectTag'
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $tag_id
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProjectTag whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProjectTag whereTagId($value)
 */

class ProjectTag extends Model {
    public $table = 'project_tag';
    public $timestamps = false;
}
