<?php namespace App\Modules\External\Employee\Repositories;
/**
 * Class EmployeeRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\External\Employee\Interfaces\EmployeeInterface;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\External\Users\Models\ExternalUserModel;
use Validator;
use Auth;

class EmployeeRepositories extends BaseRepository implements EmployeeInterface
{
	protected $parents;
	
	public function model()
	{
		return EmployeeModel::class;
	}
	
	public function options()
	{
		return ['data' => $this->model->options()];
	}
	
	public function option_hierarchy()
	{
		$results = [];
		
		$parent_id = Auth::user()->user_core->structure->parent_id;
		$this->parents[] = Auth::user()->user_core->structure->id;
		
		/* Search Hierarchy Structure Bottom to Top */
		$this->get_parent(OrganizationModel::find($parent_id), $parent_id);
		
		/* Search Structure By Hierarchy Code */
		$org = OrganizationModel::whereIn('id', $this->parents)->pluck('kode_struktur');
		
		/* Search User By Code Structure */
		$users = ExternalUserModel::isActive()
					->whereIn('kode_struktur', $org)
					->whereIn('kode_jabatan', unserialize(setting_by_code('ALLOW_ROLE_POSITION_USER')))
					->get();
		
		if (!empty($users)) {
			foreach ($users as $user) {
				$results[] = [
					'id' => $user->employee->id_employee,
					'name' => $user->employee->nik .' - '. $user->employee->name
				];
			}
		}
		
		return ['data' => $results];
	}
	
	private function get_parent($org)
	{
		if ($org) {
			$this->parents[] = $org->id;
			
			if ($org->parent_id != null || $org->parent_id != 0) {
				$this->get_parent(OrganizationModel::find($org->parent_id));
			}
		}
	}
}
