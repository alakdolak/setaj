<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ProjectBuyers'
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $project_id
 * @property string $file
 * @property string $adv
 * @property boolean $status
 * @property int $adv_status
 * @property int $file_status
 * @property boolean $complete_upload_file
 * @property boolean $complete_upload_adv
 * @property string $start_uploading
 * @property string $start_uploading_adv
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
