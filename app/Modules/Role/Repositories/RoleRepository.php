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
	
	public function showMenu()
    {
		return $this->_menu(['categories' => $this->_categories]);
	}
	
	public function _menu($categories)
	{
		$models =  MenuModel::where($categories)
							->orderBy('order')->get()->toArray();
							
		return $this->_temp_menu = $this->_list($models);
		
	}
	
	public function _list(array $menus, $parentId = 0) 
	{
		$lists = [];
	
		foreach ($menus as $menu) 
		{
			$fields = [];
			$functions = [];
			
			if ($menu['parent_id'] == $parentId) {
				
				$fields['parent_id'] = $menu['parent_id'];
				$fields['name'] = $menu['name'];
				$fields['url'] = $menu['url'];
				$fields['icon'] = $menu['icon'];
				
				$func = !empty($menu['function']) ? explode(',', $menu['function']) : [];
				
                foreach ($this->_function as $key => $v) {
                    if (in_array($key, $func)) {
                        $functions[$key] = $this->_get_role_field($menu['id'], $key);
                    }
				}
				
				$fields['function'] = $functions;
				
				$children = $this->_list($menus, $menu['id']);
				
				if ($children) {
					$fields['children'] = $children;
				}
				
				$lists[$menu['id']] = $fields;
			}
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
	
	public function create($request)
    {
		$rules = [
			'username' => 'required|min:8|unique:users,username',
			'email' => 'required|unique:users,email',
			'password' => [
				'required', 
				'min:8', 
				'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@#$%^&*()<>?]).*$/'
			],
			'status' => 'required'
		];
		
		$message = [
			'password.regex' => ':attribute harus terdapat nomer, simbol, huruf besar dan kecil .'
		];
		
		Validator::validate($request->all(), $rules, $message);
		
		$model = $this->model->create($request->merge([
            'password' => app('hash')->make($request->password),
		])->all());

		created_log($model);
		
		return ['message' => config('constans.success.created')];
	}
	
	public function update($request, $id)
    {
		$input = $request->all();
		$rules = [
			// 'employee_id' => 'required',
			// 'role_id' => 'required',
			'username' => 'required|min:8|unique:users,username,' . $id,
			'email' => 'required|unique:users,email,' . $id,
			'status' => 'required',
		];
		
		$message = [];
		
		if (!empty($input['password'])) {
			$rules['password'] = [
				'required', 
				'min:8', 
				'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@#$%^&*()<>?]).*$/'
			];
			$message = [
				'password.regex' => ':attribute harus terdapat nomer, simbol, huruf besar dan kecil .'
			];
		} else {
			unset($input['password']);
		}
		
		Validator::validate($input, $rules, $message);
		
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
    
}
