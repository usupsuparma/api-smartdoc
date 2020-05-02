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
		$org = OrganizationModel::whereIn('id', $this->parents)->pluck('id');
		
		/* Search User By Code Structure */
		$users = ExternalUserModel::isActive()
					->whereIn('kode_struktur', $org)
					->whereIn('kode_jabatan', unserialize(setting_by_code('ALLOW_ROLE_POSITION_USER')))
					->get();
		
		if (!empty($users)) {
			foreach ($users as $dt) {
				$cd_structure = '';
				$name_structure = '';
				$name_position = '';
				
				if (!empty($dt->structure)) {
					$cd_structure = $dt->structure->kode_struktur;
					$name_structure = $dt->structure->nama_struktur;
				}
				
				if (!empty($dt->position)) {
					$name_position = $dt->position->nama_jabatan;
				}
				
				$results[] = [
					'id' => $dt->employee->id_employee,
					'name' => $dt->employee->nik .' - '. $dt->employee->name,
					'structure_name' => $cd_structure .' - '. $name_structure,
					'position_name' => $name_position,
				];
			}
		}
		
		return ['data' => $results];
	}
	
	public function option_structure($id)
	{
		$results = [];

		$employee = $this->model->whereHas('user', function ($q) use ($id) {
			$q->where('kode_struktur', $id);
		})->get();
		
		if (!empty($employee)) {
			foreach ($employee as $dt) {
				$cd_structure = '';
				$name_structure = '';
				$name_position = '';
				
				if (!empty($dt->user->structure)) {
					$cd_structure = $dt->user->structure->kode_struktur;
					$name_structure = $dt->user->structure->nama_struktur;
				}
				
				if (!empty($dt->user->position)) {
					$name_position = $dt->user->position->nama_jabatan;
				}
				
				$results[] = [
					'id' => $dt->id_employee,
					'name' => $dt->nik .' - '. $dt->name,
					'structure_name' => $cd_structure .' - '. $name_structure,
					'position_name' => $name_position,
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
