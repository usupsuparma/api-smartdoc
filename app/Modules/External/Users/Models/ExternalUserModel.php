<?php namespace App\Modules\External\Users\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\External\Position\Models\PositionModel;

class ExternalUserModel extends Model 
{
	public $timestamps = false;
	protected $primaryKey = 'user_id';
	protected $connection = 'bijb';
	protected $table = 'users';
	
    protected $fillable   = [
		'id_employee', 'user_login', 'user_password', 'kode_struktur', 'kode_jabatan', 'is_active'
	];
	
	public function employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'id_employee', 'id_employee')
					->select('id_employee', 'nik', 'name');
	}
	
	public function structure()
	{
		return $this->belongsTo(OrganizationModel::class, 'kode_struktur', 'kode_struktur')
					->select('id', 'nama_struktur', 'kode_struktur');
	}
	
	public function position()
	{
		return $this->belongsTo(PositionModel::class, 'kode_jabatan')
					->select('id', 'nama_jabatan');
	}
}