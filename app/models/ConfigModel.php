<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ConfigModel'
 *
 * @property integer $id
 * @property integer $initial_point
 * @property integer $initial_star
 * @property integer $change_rate
 * @property integer $project_limit
 * @property integer $service_limit
 * @property double $rev_change_rate
 */

class ConfigModel extends Model {

    public $table = 'config';
    public $timestamps = false;

    public static function whereId($value) {
        return ConfigModel::find($value);
    }
}
