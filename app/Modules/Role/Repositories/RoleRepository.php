<?php namespace App\Modules\Role\Repositories;
/**
 * Class RoleRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Role\Interfaces\RoleInterface;
use App\Modules\Role\Models\RoleModel;
use App\Modules\Menu\Models\MenuModel;
use Validator;

class RoleRepositories extends BaseRepository implements RoleInterface
{
	protected $_temp_menu = [];
	protected $_temp_ordering = [];
	protected $_categories = 'web';
	
	private $_function = [
        'R' => 'Read',
        'C' => 'Create',
        'U' => 'Update',
        'D' => 'Delete',
        'I' => 'Import',
        'E' => 'Export',
        'A' => 'Approve',
        'S' => 'Disposition',
        'O' => 'Data Otority'
	];
	
	protected $_authorities = [
        'authority_read' => [],
        'authority_create' => [],
        'authority_update' => [],
        'authority_delete' => [],
        'authority_import' => [],
        'authority_export' => [],
        'authority_approve' => [],
        'authority_disposition' => []
    ];
	
	public function model()
	{
		return RoleModel::class;
	}
	
    public function data($request)
    {
        return $this->model->get();
	}
	
	public function show($id)
    {
        return $this->model->findOrFail($id);
	}
	
	public function showMenu($request)
    {
		
		if (isset($request->id) && !empty($request->id)) {
            $this->_authorities($request->id);
		}
		
		return $this->_menu(['categories' => $this->_categories]);
	}
	
	public function _menu($categories)
	{
		$models =  MenuModel::where($categories)
							->orderBy('order')->get()->toArray();
		if (!$models) {
			return;
		}
		
		return $this->_temp_menu = $this->_list($models);
		
	}
	
	public function _list(array $menus, $parentId = 0) 
	{
		$lists = [];
	
		foreach ($menus as $menu) 
		{
			$fields = [];
			$functions = [];
			
			// if ($menu['parent_id'] == $parentId) {
				
				$fields['id'] = $menu['id'];
				$fields['parent_id'] = $menu['parent_id'];
				$fields['name'] = $menu['name'];
				$fields['url'] = $menu['url'];
				$fields['component'] = $menu['component'];
				$fields['icon'] = $menu['icon'];
				$fields['order'] = $menu['order'];
				$fields['status'] = $menu['status'];
				
				$func = !empty($menu['function']) ? explode(',', $menu['function']) : [];
				
                foreach ($this->_function as $key => $v) {
                    if (in_array($key, $func)) {
                        $functions[$key] = $this->_get_role_field($menu['id'], $key);
                    }
				}
				
				$fields['function'] = $functions;
				
				// $children = $this->_list($menus, $menu['id']);
				
				// if ($children) {
				// 	$fields['children'] = $children;
				// }
				
				$lists[] = $fields;
			// }
		}
		
		return $lists;
	}
	
	protected function _get_role_field($menu_id, $function)
    {
		$actions = '';
		
        switch ($function):
            case 'R':
                $actions = in_array($menu_id, $this->_authorities['authority_read']) ? TRUE : FALSE;
                break;
            case 'C':
                $actions = in_array($menu_id, $this->_authorities['authority_create']) ? TRUE : FALSE;
                break;
            case 'U':
                $actions = in_array($menu_id, $this->_authorities['authority_update']) ? TRUE : FALSE;
                break;
            case 'D':
				$actions = in_array($menu_id, $this->_authorities['authority_delete']) ? TRUE : FALSE;
                break;
            case 'I':
                $actions = in_array($menu_id, $this->_authorities['authority_import']) ? TRUE : FALSE;
                break;
            case 'E':
				$actions = in_array($menu_id, $this->_authorities['authority_export']) ? TRUE : FALSE;
                break;
            case 'A':
				$actions = in_array($menu_id, $this->_authorities['authority_approve']) ? TRUE : FALSE;
                break;
            case 'S':
				$actions = in_array($menu_id, $this->_authorities['authority_disposition']) ? TRUE : FALSE;
                break;
        endswitch;

        return $actions;
	}
	
	private function _authorities($key = [])
    {
        $data = RoleModel::findOrFail($key);

        foreach ($data->menu as $dt) {
            if ($dt->pivot->authority_read == 1)
                $this->_authorities['authority_read'][] = $dt->pivot->menu_id;
            if ($dt->pivot->authority_create == 1)
                $this->_authorities['authority_create'][] = $dt->pivot->menu_id;
            if ($dt->pivot->authority_update == 1)
                $this->_authorities['authority_update'][] = $dt->pivot->menu_id;
            if ($dt->pivot->authority_delete == 1)
                $this->_authorities['authority_delete'][] = $dt->pivot->menu_id;
            if ($dt->pivot->authority_import == 1)
                $this->_authorities['authority_import'][] = $dt->pivot->menu_id;
            if ($dt->pivot->authority_export == 1)
                $this->_authorities['authority_export'][] = $dt->pivot->menu_id;
            if ($dt->pivot->authority_approve == 1)
				$this->_authorities['authority_approve'][] = $dt->pivot->menu_id;
			if ($dt->pivot->authority_disposition == 1)
                $this->_authorities['authority_disposition'][] = $dt->pivot->menu_id;

            $this->_authorities['authority_data'][(string)$dt->id] = $dt->pivot->authority_data;
        }
    }
	
	public function create($request)
    {
		$rules = [
			'name' => 'required|unique:roles,name',
			'categories' => 'required',
			'status' => 'required'
		];
		
		Validator::validate($request->all(), $rules);
		
		$model = $this->model->create($request->all());

		created_log($model);
		
		$model->menu()->attach(json_decode($request->authorities, true)[0]);
		
		return ['message' => config('constans.success.created')];
	}
	
	public function update($request, $id)
    {
		$input = $request->all();
		$rules = [
			'name' => 'required|unique:roles,name,' . $id,
			'categories' => 'required',
			'status' => 'required'
		];
		
		Validator::validate($input, $rules);
		
		$model = $this->model->findOrFail($id);
		$model->update($input);
		
		updated_log($model);
		
		$model->menu()->sync(json_decode($request->authorities, true)[0]);
		
		return ['message' => config('constans.success.updated')];
	}
	
	public function delete($id)
    {
		$model = $this->model->findOrFail($id);
		deleted_log($model);
		$model->delete();
		
		
		return ['message' => config('constans.success.deleted')];
    }
    
}
