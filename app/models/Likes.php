<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
/**
 * An Eloquent Model: 'Likes'
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $user_id
 * @property integer $mode
 * @method static \Illuminate\Database\Query\Builder|\App\models\Likes whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Likes whereMode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Likes whereUserId($value)
 */

class Likes extends Model {

    public $table = 'likes';
    public $timestamps = false;

    public static function whereId($value) {
        return Likes::find($value);
    }
}
