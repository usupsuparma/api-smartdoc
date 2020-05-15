<?php namespace App\Modules\Signature\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\Signature\Transformers\SignatureTransformer;
use App\Modules\External\Employee\Models\EmployeeModel;
use Upload, Auth;

class SignatureModel extends Model
{

	public $transformer = SignatureTransformer::class;
	
	protected $table = 'digital_signatures';
	
    protected $fillable   = [
		'employee_id', 'path_to_file', 'path_public_key',
		'path_private_key', 'credential_key', 'status'
	];
	
	public function employees()
	{
		return $this->belongsTo(EmployeeModel::class, 'employee_id', 'id_employee');
	}
	
	public function scopeCheckAvailableSignature($query)
	{
		return $query->where('employee_id', Auth::user()->user_core->id_employee);
	}
	
	protected static function boot() 
    {
		parent::boot();

		static::deleting(function($signature) {
			/* Remove relation attachment */
			if (!empty($signature->path_to_file)) {
				Upload::delete($signature->path_to_file);
			}
		});
    }
}