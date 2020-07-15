<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
/**
 * An Eloquent Model: 'Bookmark'
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $user_id
 * @property integer $mode
 * @method static \Illuminate\Database\Query\Builder|\App\models\Bookmark whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Bookmark whereMode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Bookmark whereUserId($value)
 */

class Bookmark extends Model {

    public $table = 'bookmarks';
    public $timestamps = false;

    public static function whereId($value) {
        return Bookmark::find($value);
    }
}
