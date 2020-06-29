<?php namespace App\Modules\User\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\User\Transformers\UserTransformer;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Passport\HasApiTokens;
use Laravel\Lumen\Auth\Authorizable;
use App\Modules\External\Users\Models\ExternalUserModel;
use App\Modules\Role\Models\RoleModel;

class UserModel extends Model implements AuthenticatableContract, AuthorizableContract
{
	
	use SoftDeletes, Authenticatable, Authorizable, HasApiTokens;

	public $transformer = UserTransformer::class;
	
	protected $table = 'users';
	
    protected $fillable   = [
		'user_core_id', 'employee_id', 'role_id', 'username' , 'email', 'password', 'remember_token', 'public_token',
		'private_token', 'device_id', 'last_login', 'log_date', 'count_login', 'is_banned', 'status',
	];
	
	protected $dates = ['deleted_at'];
	
	protected $hidden = [
        'password',
	];
	
	public function user_core()
	{
		return $this->belongsTo(ExternalUserModel::class, 'user_core_id', 'user_id');
	}
	
	public function role()
	{
		return $this->belongsTo(RoleModel::class, 'role_id')->select('id', 'name', 'categories');
	}
	
	public function scopeFindByEmail($query, $email)
	{
		return $query->where('email', $email);
	}
}