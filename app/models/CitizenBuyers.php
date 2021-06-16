<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'CitizenBuyers'
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $project_id
 * @property boolean $point
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\App\models\CitizenBuyers whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\CitizenBuyers whereProjectId($value)
 */

class CitizenBuyers extends Model {

    public $table = 'citizen_buyers';

    public static function whereId($value) {
        return CitizenBuyers::find($value);
    }
}
