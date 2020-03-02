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
		
		$model = $this->model->create($input);
		created_log($model);
		
		return ['message' => config('constans.success.created')];
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
    
}
