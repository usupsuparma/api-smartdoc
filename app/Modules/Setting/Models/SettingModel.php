<?php namespace App\Modules\Setting\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Setting\Transformers\SettingTransformer;

class SettingModel extends Model
{
	use SoftDeletes;

	public $transformer = SettingTransformer::class;
	
	protected $table = 'settings';
	
    protected $fillable   = [
		'name', 'code', 'value', 'description', 'status'
	];
	
	protected $dates = ['deleted_at'];

	public function scopeByCode($query, $code)
	{
		$m = $query->where('code', $code)->first();
		
		if (!empty($m)) {
			return $m->value;
		}
		
		return NULL;
	}
}