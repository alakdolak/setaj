<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'CitizenAttach'
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\models\CitizenAttach whereProjectId($value)
 */

class CitizenAttach extends Model {
    public $table = 'citizen_attach';
    public $timestamps = false;
}
