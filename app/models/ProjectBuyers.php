<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ProjectBuyers'
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $project_id
 * @property boolean $status
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProjectBuyers whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProjectBuyers whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\ProjectBuyers whereStatus($value)
 */

class ProjectBuyers extends Model {

    public $table = 'project_buyers';

    public static function whereId($value) {
        return ProjectBuyers::find($value);
    }
}
