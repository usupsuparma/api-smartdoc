<?php namespace App\Modules\External\Employee\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model 
{
	public $timestamps = false;
	protected $connection = 'bijb';
	protected $table = 'employee';
	
    protected $fillable   = [
		'nik', 'name'
	];
	
	public function user()
	{
		return $this->belongsTo('App\Modules\External\Users\Models\ExternalUserModel', 'id_employee');
	}
	
	public function scopeIsActive($query)
	{
		// return $query->where('status', 1);
	}
	
	public function scopeOptions($query, $default = NULL)
    {
        $list = [];

        foreach ($query->isActive()->orderBy('name')->get() as $dt) {
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
			
            $list[] = [
				'id' => $dt->id_employee,
				'name' => $dt->nik . ' - ' . $dt->name,
				'structure_name' => $cd_structure .' - '. $name_structure,
				'position_name' => $name_position,
			];
		}
		
        return $list;
    }
}