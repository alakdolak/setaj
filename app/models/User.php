<?php


namespace App\models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * An Eloquent Model: 'User'
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property string $nid
 * @property boolean $status
 * @property boolean $super_active
 * @property integer $grade_id
 * @property integer $stars
 * @property integer $money
 * @property integer $level
 * @method static \Illuminate\Database\Query\Builder|\App\models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\User whereNid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\User whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\User whereGradeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\User whereStatus($value)
 */

class User extends Authenticatable{

	use Notifiable;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */


	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	protected $fillable = [
		'username', 'password'
	];

	protected $hidden = array('password', 'remember_token');

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	public function getAuthIdentifier() {
		return $this->getKey();
	}
	public function getAuthPassword() {
		return $this->password;
	}

	public static function whereId($value) {
		return User::find($value);
	}
}
