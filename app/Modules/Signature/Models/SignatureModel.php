<?php namespace App\Modules\Signature\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\Signature\Transformers\SignatureTransformer;
use App\Modules\External\Employee\Models\EmployeeModel;
use Upload;

class SignatureModel extends Model
{

	public $transformer = SignatureTransformer::class;
	
	protected $table = 'digital_signatures';
	
    protected $fillable   = [
		'employee_id', 'path_to_file', 'status'
	];
	
	public function employees()
	{
		return $this->belongsTo(EmployeeModel::class, 'employee_id', 'id_employee');
	}
	
	protected static function boot() 
    {
		parent::boot();

		static::deleting(function($signature) {
			/* Remove relation attachment */
			Upload::delete($signature->path_to_file);
		});
    }
}