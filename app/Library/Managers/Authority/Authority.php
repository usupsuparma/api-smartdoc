<?php namespace App\Library\Managers\Authority;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Menu\Models\MenuModel;
use Auth;

class Authority
{
	protected $authority;
	
	public function init($modules, $user) 
	{
		if (isset($user)) {
			$role = $user->role_id;
		}else{
			$role = Auth::user()->role_id;
		}
		
		$query = MenuModel::where('modules', $modules)->with(['role' => function($q) use ($role) {
				  $q->find($role);
		}]);
		
		if ($query->count() > 0) {

			$query = $query->first();
			
			// if (empty($query->role->toArray())) {
			// 	abort(403);
			// }
			
			// if(!$query->role[0]->pivot->authority_read){
			// 	abort(403);
			// }
			
			$this->authority = [
				'id' => $query->id,
				'name' => $query->name,
				'description' => $query->description,
				'url' => $query->url,
				'read' => $query->role[0]->pivot->authority_read,
				'create' => $query->role[0]->pivot->authority_create,
				'update' => $query->role[0]->pivot->authority_update,
				'delete' => $query->role[0]->pivot->authority_delete,
				'import' => $query->role[0]->pivot->authority_import,
				'export' => $query->role[0]->pivot->authority_export,
				'approve' => $query->role[0]->pivot->authority_approve,
				'disposition' => $query->role[0]->pivot->authority_disposition,
				'data' => $query->role[0]->pivot->authority_data
			];
			
		} else {
			// abort(403);
		}
	
		return $this;
	}
	
	public function check($method, $redirect = false)
  	{
		if (!empty($this->authority)) {
			
			$value = $this->authority[$method];
			
			if ($value == false) {
				abort(403);
			} else {
				return $this->authority[$method];
			}
		} else {
			abort(403);
		}
	}
	  
	public function acl_access($user, $module)
    {
        if(!empty($module)){

			Authority::init($module, $user);
			
            // $_auth = [
            //     'read',
            //     'create',
            //     'update',
            //     'delete',
            //     'import',
            //     'export',
            //     'approve',
            //     'disposition',
            //     'data'
            // ];

			// $accessStatus = 0;
			
            // foreach ($_auth as $value) {
            //     if ($this->authority[$value]) {
            //         $accessStatus++;
            //     }
            // }

            // if ($accessStatus == 0) {
            //     abort(403, 'Unauthorized action.');
            // }
        }
    }
}