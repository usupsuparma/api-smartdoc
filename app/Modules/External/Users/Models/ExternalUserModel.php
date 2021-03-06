<?php

namespace App\Modules\External\Users\Models;

/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\External\Users\Transformers\ExternalUserTransformer;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\External\Position\Models\PositionModel;
use App\Modules\User\Models\UserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalUserModel extends Model
{
	use SoftDeletes;

	public $transformer = ExternalUserTransformer::class;

	protected $primaryKey = 'user_id';

	protected $table = 'external_users';

	protected $fillable   = [
		'id_employee', 'email', 'kode_struktur', 'kode_jabatan', 'status', 'fullname', 'user_id'
	];

	public function employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'id_employee', 'nik')
			->select('id_employee', 'nik', 'name');
	}

	public function structure()
	{
		return $this->belongsTo(OrganizationModel::class, 'kode_struktur', 'id')
			->select('id', 'nama_struktur', 'kode_struktur', 'parent_id');
	}

	public function position()
	{
		return $this->belongsTo(PositionModel::class, 'kode_jabatan')
			->select('id', 'nama_jabatan');
	}

	public function scopeIsActive($query)
	{
	}

	public function scopeReadySyncUser($query)
	{
		return $query->where('status', 1);
	}

	public function scopeGetNikById($query, $id) {
		$user =  $query->select('id_employee')->where('user_id', $id)->get()->first();
		return $user->id_employee;
	}
}
