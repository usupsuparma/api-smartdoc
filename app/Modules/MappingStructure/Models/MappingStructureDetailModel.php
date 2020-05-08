<?php namespace App\Modules\MappingStructure\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\External\Organization\Models\OrganizationModel;
use Illuminate\Database\Eloquent\Model;
use App\Modules\MappingStructure\Models\MappingStructureModel;
use App\Modules\MappingStructure\Transformers\MappingStructureDetailTransformer;

class MappingStructureDetailModel extends Model
{

	public $transformer = MappingStructureDetailTransformer::class;
	
	protected $table = 'mapping_structure_detail';
	
    protected $fillable   = [
		'mapping_structure_id', 'structure_id'
	];
	
	public function map_structure()
	{
		return $this->belongsTo(MappingStructureModel::class, 'mapping_structure_id');
	}
	
	public function structure()
	{
		return $this->belongsTo(OrganizationModel::class, 'structure_id');
	}
	
}