<?php namespace App\Modules\External\Employee\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model 
{
	public $timestamps = false;
	protected $connection = 'bijb';
	protected $table = 'employee';
	
    protected $fillable   = [
		'nik', 'name'
	];
	
	public function user()
	{
		return $this->belongsTo('App\Modules\External\Users\Models\ExternalUserModel', 'id_employee');
	}
}