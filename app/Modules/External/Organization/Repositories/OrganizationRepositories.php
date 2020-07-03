<?php namespace App\Modules\External\Organization\Repositories;
/**
 * Class OrganizationRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\External\Organization\Interfaces\OrganizationInterface;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\MappingStructure\Models\MappingStructureModel;
use Auth;

class OrganizationRepositories extends BaseRepository implements OrganizationInterface
{
	protected $childrens;
	
	const DIR_CODES = 'MS002';
	const DEPT_CODES = 'MS004';
	
	public function model()
	{
		return OrganizationModel::class;
	}
	
	public function options()
	{
		return ['data' => $this->model->options()];
	}
	
	public function option_disposition()
	{
		/* Search List Department */
		$department = MappingStructureModel::with('details')->where('code', self::DEPT_CODES)->firstOrFail();
		$list_department = $department->details->pluck('id');
		
		$user_structure_id = Auth::user()->user_core->structure->id;
		$user_structure_code = Auth::user()->user_core->structure->kode_struktur;
		
		$model = $this->model->isActive()
					->whereNotIn('id',$list_department)
					->get();
		
		$search  = $this->_tree($model->toArray(), $user_structure_id);

		if (in_array($user_structure_code, array_merge(
			unserialize(setting_by_code('DIREKTUR_LEVEL_STRUCTURE')), 
			unserialize(setting_by_code('DIREKSI_LEVEL_STRUCTURE')))
		)) {
			/* Search List Director Level */
			$director = MappingStructureModel::with('details')->where('code', self::DIR_CODES)->firstOrFail();
			$list_director = $director->details;
			$filtered = $list_director->filter(function ($value, $key) use ($user_structure_code) {
				return $value->kode_struktur != $user_structure_code;
			});
			
			$collection = $filtered->values()[0];
			
			array_push($search, [
				'id' => $collection->id,
				'nama_struktur' => $collection->nama_struktur,
				'parent_id' => $collection->parent_id,
				'kode_struktur' => $collection->kode_struktur
			]);
		}
		
		$parsing = collect(flat_array($search))->sortBy('nama_struktur')->values();
		
		return ['data' => $parsing];
	}
	
	public function _tree(array $menus, $parentId = 0) 
	{
		$lists = array();
	
		foreach ($menus as $menu) 
		{
			if ($menu['parent_id'] == $parentId) {
				$children = $this->_tree($menus, $menu['id']);
				if ($children) {
					$menu['children'] = $children;
				}
				$lists[] = $menu;
				unset($menu);
			}
		}
		
		return $lists;
	}
}
