<?php namespace App\Modules\Master\Type\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Master\Type\Transformers\TypeTransformer;

class TypeModel extends Model 
{
	use SoftDeletes;

	public $transformer = TypeTransformer::class;
	
	protected $table = 'types';
	
    protected $fillable   = [
		'code', 'name', 'status'
	];
	
	protected $dates = ['deleted_at'];
	
	public function scopeIsActive($query)
	{
		return $query->where('status', 1);
	}
	
	public function scopeOptions($query, $default = NULL)
    {
        $list = [];

        foreach ($query->isActive()->orderBy('name')->get() as $dt) {
            $list[] = [
				'id' => $dt->id,
				'name' => $dt->code . ' - ' . $dt->name,
			];
		}
		
        return $list;
    }
	
}