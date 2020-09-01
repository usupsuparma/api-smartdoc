<?php namespace App\Modules\External\Organization\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\External\Organization\Transformers\OrganizationTransformer;
use Illuminate\Database\Eloquent\Model;
use App\Modules\MappingStructure\Models\MappingStructureDetailModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationModel extends Model 
{
	use SoftDeletes;
	
	public $transformer = OrganizationTransformer::class;
	
	protected $table = 'external_organizations';
	
    protected $fillable   = [
		'nama_struktur', 'parent_id', 'kode_struktur', 'order', 'status'
	];
	
	public function mapping()
	{
		return $this->belongsTo(MappingStructureDetailModel::class, 'structure_id');
	}
	
	public function scopeIsActive($query)
	{
		
	}
	
	public function scopeOptions($query, $default = NULL)
    {
        $list = [];

        foreach ($query->orderBy('nama_struktur')->get() as $dt) {
            $list[] = [
				'id' => $dt->id,
				'name' => $dt->kode_struktur . ' - ' . $dt->nama_struktur,
			];
		}
		
        return $list;
    }
}