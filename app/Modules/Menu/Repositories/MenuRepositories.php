<?php namespace App\Modules\Menu\Repositories;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Menu\Interfaces\MenuInterface;
use App\Modules\Menu\Models\MenuModel;
use Validator;

class MenuRepositories extends BaseRepository implements MenuInterface
{
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
			'function' => 'required|array',
			'status' => 'required',
		];
		
		Validator::validate($request->all(), $rules);
		
		$input = $request->merge([
			'parent_id' => isset($request->parent_id) ? (int) $request->parent_id : NULL,
			'order' => $this->model->where('categories', 'web')->count() + 1,
			'function' => implode(',', $request->function),
		])->all();
		
		if ($this->model->create($input)) {
			return ['message' => config('constans.created')];
		}
	}
	
	public function update($request, $id)
    {
		$rules = [
			'name' => 'required',
			'url' => 'required|unique:menus,url,' . $id,
			'function' => 'required|array',
			'status' => 'required',
		];
		
		Validator::validate($request->all(), $rules);
		
		$input = $request->merge([
			'parent_id' => isset($request->parent_id) ? (int) $request->parent_id : NULL,
			'function' => implode(',', $request->function),
		])->all();
		
		if ($this->model->findOrFail($id)->update($input)) {
			return ['message' => config('constans.updated')];
		}
	}
	
	public function delete($id)
    {
		$this->model->findOrFail($id)->delete();
		
		return ['message' => config('constans.deleted')];
	}
	
	public function _tree(array $menus, $parentId = 0) 
	{
		$lists = array();
	
		foreach ($menus as $menu) {
	
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
    
}
