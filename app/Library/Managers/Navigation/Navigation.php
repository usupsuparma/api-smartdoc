<?php namespace App\Library\Managers\Navigation;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Menu\Models\MenuModel;
use App\Modules\Role\Models\MenuRoleModel;
use Auth;

class Navigation
{
	protected $categories = 'web';
	
	public function menu() 
	{
		$results = [];
		
		$model = MenuModel::categories($this->categories)->whereHas('role', function($q) {
			$q->where([
				'role_id' => Auth::user()->role_id,
				'authority_read' => 1
			]);
		})->orderBy('parent_id')->orderBy('order')->get()->toArray();
		
		foreach($model as $data) {
			$role = MenuRoleModel::where(['menu_id' => $data['id'], 'role_id' => Auth::user()->role_id])->first();
			
			$authority = [
				'authority_read' => $role->authority_read === 1 ? true : false,
				'authority_create' => $role->authority_create === 1 ? true : false,
				'authority_update' => $role->authority_update === 1 ? true : false,
				'authority_delete' => $role->authority_delete === 1 ? true : false,
				'authority_import' => $role->authority_import === 1 ? true : false,
				'authority_export' => $role->authority_export === 1 ? true : false,
				'authority_approve' => $role->authority_approve === 1 ? true : false,
				'authority_disposition' => $role->authority_disposition === 1 ? true : false,
			];
			
			$data['function'] = $authority;
			
			unset(
				$data['status'],
				$data['created_at'],
				$data['updated_at'],
				$data['deleted_at']
			);
			
			$results[] = $data;
		}
		
		return $results;
	}
}