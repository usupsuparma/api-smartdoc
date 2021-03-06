<?php namespace App\Modules\Master\ClassDisposition\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Master\ClassDisposition\Transformers\ClassDispositionTransformer;

class ClassDispositionModel extends Model 
{
	use SoftDeletes;

	public $transformer = ClassDispositionTransformer::class;
	
	protected $table = 'class_disposition';
	
    protected $fillable   = [
		'name', 'status'
	];
	
	protected $dates = ['deleted_at'];
	
	public function scopeIsActive($query)
	{
		return $query->where('status', 1);
	}
	
	public function scopeOptions($query)
    {
        $list = [];

        foreach ($query->isActive()->orderBy('name')->get() as $dt) {
            $list[] = [
				'id' => $dt->id,
				'name' => $dt->name,
			];
		}
		
        return $list;
    }
}