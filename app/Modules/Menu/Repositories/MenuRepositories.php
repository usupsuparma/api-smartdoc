<?php namespace App\Modules\Menu\Repositories;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Menu\Interfaces\MenuInterface;
use App\Modules\Menu\Models\MenuModel;
use Validator,Navigation;

class MenuRepositories extends BaseRepository implements MenuInterface
{
    protected $_temp_ordering = [];
	
	public function model()
	{
		return MenuModel::class;
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
			'name' => 'required',
			'url' => 'required|unique:menus,url',
			'component' => 'required',
			'modules' => 'required',
			'show' => 'required',
			'function' => 'required|array',
			'status' => 'required',
		];
		
		Validator::validate($request->all(), $rules);
		
		$input = $request->merge([
			'parent_id' => isset($request->parent_id) ? (int) $request->parent_id : NULL,
			'order' => $this->model->where('categories', 'web')->count() + 1,
			'function' => implode(',', $request->function),
		])->all();
		
		$model = $this->model->create($input);
		created_log($model);
		
		return ['message' => config('constans.success.created')];
	}
	
	public function update($request, $id)
    {
		$rules = [
			'name' => 'required',
			'url' => 'required|unique:menus,url,' . $id,
			'component' => 'required',
			'modules' => 'required',
			'show' => 'required',
			'function' => 'required|array',
			'status' => 'required',
		];
		
		Validator::validate($request->all(), $rules);
		
		$input = $request->merge([
			'parent_id' => isset($request->parent_id) ? (int) $request->parent_id : NULL,
			'function' => implode(',', $request->function),
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
				$lists[$menu['id']] = $menu;
				unset($menu);
			}
		}
		
		return $lists;
	}
	
	public function ordering($request)
    {
		$nestable = $request->nestable_menu;

        if (!empty($nestable)) {
            $this->parsing_ordering(json_decode($nestable));

            foreach ($this->_temp_ordering as $key => $value) {
                $this->model->find($key)->update($value);
            }
		}
		
		return ['message' => config('constans.success.ordering')];
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
	
	public function navigation()
	{
		return Navigation::menu();
	}
    
}
