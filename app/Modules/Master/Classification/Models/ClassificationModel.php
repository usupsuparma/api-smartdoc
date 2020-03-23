<?php namespace App\Modules\Master\Classification\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Master\Classification\Transformers\ClassificationTransformer;

class ClassificationModel extends Model 
{
	use SoftDeletes;

	public $transformer = ClassificationTransformer::class;
	
	protected $table = 'classification';
	
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