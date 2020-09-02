<?php namespace App\Modules\External\Position\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\External\Position\Transformers\PositionTransformer;

class PositionModel extends Model 
{
	use SoftDeletes;
	
	public $transformer = PositionTransformer::class;
	
	protected $table = 'external_positions';
	
    protected $fillable   = [
		'nama_jabatan', 'status'
	];
	
	protected $dates = ['deleted_at'];
	
	public function scopeOptions($query, $default = NULL)
    {
        $list = [];

        foreach ($query->orderBy('nama_jabatan')->get() as $dt) {
            $list[] = [
				'id' => $dt->id,
				'name' => $dt->nama_jabatan,
			];
		}
		
        return $list;
    }
}