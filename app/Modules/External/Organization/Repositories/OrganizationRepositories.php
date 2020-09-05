<?php namespace App\Modules\External\Organization\Repositories;
/**
 * Class OrganizationRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\External\Organization\Interfaces\OrganizationInterface;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\MappingStructure\Models\MappingStructureModel;
use App\Helpers\SmartdocHelper;
use Auth, Validator;

class OrganizationRepositories extends BaseRepository implements OrganizationInterface
{
	protected $childrens;
	protected $_temp_ordering = [];
	
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
		
		$model = $this->model->isActive();
		if (SmartdocHelper::bod_level()) {
			$model->whereNotIn('id',$list_department);
		}else {
			$model->whereIn('id',$list_department);
		}

		
		$search  = $this->_tree($model->get()->toArray(), $user_structure_id);

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
		
		$parsing = collect(flat_array($search))->unique('id')->sortBy('nama_struktur')->values();
		
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
	
	public function data($request)
    {
        return $this->model->get();
	}
	
	public function show($id)
    {
        return $this->model->findOrFail($id);
	}
	
	public function create($request)
    {
		$rules = [
			'nama_struktur' => 'required|unique:external_organizations,nama_struktur,NULL,id,deleted_at,NULL',
			'kode_struktur' => 'required|unique:external_organizations,kode_struktur,NULL,id,deleted_at,NULL',
			'status' => 'required',
		];
		
		Validator::validate($request->all(), $rules);
		
		$input = $request->merge([
			'parent_id' => isset($request->parent_id) ? (int) $request->parent_id : NULL,
			'order' => $this->model->count() + 1,
		])->all();
		
		$model = $this->model->create($input);
		created_log($model);
		
		return ['message' => config('constans.success.created')];
	}
	
	public function update($request, $id)
    {
		$rules = [
			'nama_struktur' => 'required|unique:external_organizations,nama_struktur,' . $id . ',id,deleted_at,NULL',
			'kode_struktur' => 'required|unique:external_organizations,kode_struktur,' . $id . ',id,deleted_at,NULL',
			'status' => 'required',
		];
		
		Validator::validate($request->all(), $rules);
		
		$input = $request->merge([
			'parent_id' => isset($request->parent_id) ? (int) $request->parent_id : NULL
		])->all();
		
		$model = $this->model->findOrFail($id);
		$model->update($input);
		
		updated_log($model);
		
		return ['message' => config('constans.success.updated')];
	}
	
	public function delete($id)
    {
		$model = $this->model->findOrFail($id);
		deleted_log($model);
		$model->delete();
		
		return ['message' => config('constans.success.deleted')];
	}
	
	public function ordering($request)
    {
		$nestable = $request->nestable_organization;

        if (!empty($nestable)) {
            $this->parsing_ordering(json_decode($nestable));

            foreach ($this->_temp_ordering as $key => $value) {
                $this->model->find($key)->update($value);
            }
		}
		
		return ['message' => config('Berhasil melakukan penyusunan divisi.')];
	}
	
	private function parsing_ordering($nestable, $parent = NULL) 
	{
        if (is_array($nestable)) {
            $order = 1;

            foreach ($nestable as $dt) {
                $this->_temp_ordering[$dt->id] = [
                    'order' => $order,
                    'parent_id' => !is_null($parent) ? (int) $parent : 0
                ];

                if (isset($dt->children)) {
                    $this->parsing_ordering($dt->children, $dt->id);
                }

                $order++;
            }
        }
	}
}
