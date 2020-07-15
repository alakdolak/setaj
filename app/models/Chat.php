<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Chat'
 *
 * @property integer $id
 * @property integer $user_id
 * @method static \Illuminate\Database\Query\Builder|\App\models\Chat whereUserId($value)
 */

class Chat extends Model {

    public $table = 'chat';

    public static function whereId($value) {
        return Chat::find($value);
    }
}
