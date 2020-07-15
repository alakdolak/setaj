<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Msg'
 *
 * @property integer $id
 * @property integer $chat_id
 * @property string $text
 * @property boolean $is_me
 * @property boolean $seen
 * @method static \Illuminate\Database\Query\Builder|\App\models\Msg whereChatId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Msg whereIsMe($value)
 */

class Msg extends Model {

    public $table = 'msg';

    public static function whereId($value) {
        return Msg::find($value);
    }
}
