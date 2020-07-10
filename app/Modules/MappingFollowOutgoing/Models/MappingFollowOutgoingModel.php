<?php namespace App\Modules\MappingFollowOutgoing\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\MappingFollowOutgoing\Transformers\MappingFollowOutgoingTransformer;
use App\Modules\Master\Type\Models\TypeModel;

class MappingFollowOutgoingModel extends Model 
{
	use SoftDeletes;

	public $transformer = MappingFollowOutgoingTransformer::class;
	
	protected $table = 'mapping_follow_outgoing';
	
    protected $fillable   = [
		'type_id'
	];
	
	public function type()
	{
		return $this->belongsTo(TypeModel::class, 'type_id');
	}
	
	public function scopeFindByType($query, $type_id) {
		return $query->where('type_id', $type_id)->exists();
	}
	
	protected $dates = ['deleted_at'];
}