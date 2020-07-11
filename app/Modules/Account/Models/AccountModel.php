<?php namespace App\Modules\Account\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\External\Users\Models\ExternalUserModel;
use App\Modules\Role\Models\RoleModel;
use App\Modules\Account\Transformers\AccountTransformer;

class AccountModel extends Model 
{
	public $transformer = AccountTransformer::class;
	
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
		return $this->belongsTo(ExternalUserModel::class, 'user_core_id');
	}
	
	public function role()
	{
		return $this->belongsTo(RoleModel::class, 'role_id')->select('id', 'name', 'categories');
	}
}