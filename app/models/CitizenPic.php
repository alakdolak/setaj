<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'CitizenPic'
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\models\CitizenPic whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\CitizenPic whereName($value)
 */

class CitizenPic extends Model {
    public $table = 'citizen_pic';
    public $timestamps = false;
}
