<?php namespace App\Modules\External\Organization\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\MappingStructure\Models\MappingStructureDetailModel;

class OrganizationModel extends Model 
{
	public $timestamps = false;
	protected $connection = 'bijb';
	protected $table = 'struktur';
	
    protected $fillable   = [
		'nama_struktur', 'parent_id', 'kode_struktur'
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