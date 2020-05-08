<?php namespace App\Modules\External\Position\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;

class PositionModel extends Model 
{
	public $timestamps = false;
	protected $connection = 'bijb';
	protected $table = 'jabatan';
	
    protected $fillable   = [
		'nama_jabatan'
	];
	
	public function scopeOptions($query, $default = NULL)
    {
        $list = [];

        foreach ($query->orderBy('nama_jabatan')->get() as $dt) {
            $list[] = [
				'id' => $dt->id,
				'name' => $dt->nama_jabatan,
			];
		}
		
        return $list;
    }
}