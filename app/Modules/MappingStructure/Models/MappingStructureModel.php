<?php namespace App\Modules\MappingStructure\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\MappingStructure\Models\MappingStructureDetailModel;
use App\Modules\MappingStructure\Transformers\MappingStructureTransformer;
use App\Modules\External\Position\Models\PositionModel;
use App\Modules\External\Organization\Models\OrganizationModel;

class MappingStructureModel extends Model
{

	public $transformer = MappingStructureTransformer::class;
	
	protected $table = 'mapping_structure';
	
    protected $fillable   = [
		'code', 'name', 'primary_top_level_id', 'secondary_top_level_id', 'status'
	];
	
	public function primary()
	{
		return $this->belongsTo(PositionModel::class, 'primary_top_level_id');
	}
	
	public function secondary()
	{
		return $this->belongsTo(PositionModel::class, 'secondary_top_level_id');
	}
	
	public function details()
	{
		return $this->belongsToMany(OrganizationModel::class,'mapping_structure_detail','mapping_structure_id','structure_id');
	}
	
	public function scopeGetByCode($query, $code)
	{
		return $query->where('code', $code);
	}
	
	public function scopeIsActive($query)
	{
		return $query->whereStatus(true);
	} 
	
}