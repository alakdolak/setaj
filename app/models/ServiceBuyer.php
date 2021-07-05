<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ServiceBuyer'
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $star
 * @property string $file
 * @property string $start_uploading
 * @property integer $service_id
 * @property integer $file_status
 * @property boolean $complete_upload_file
 * @property boolean $status
 * @method static \Illuminate\Database\Query\Builder|\App\models\ServiceBuyer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\ServiceBuyer whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\ServiceBuyer whereStatus($value)
 */

class ServiceBuyer extends Model {

    public $table = 'service_buyer';

    public static function whereId($value) {
        return ServiceBuyer::find($value);
    }
}
