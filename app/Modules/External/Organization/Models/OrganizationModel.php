<?php namespace App\Modules\External\Organization\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;

class OrganizationModel extends Model 
{
	public $timestamps = false;
	protected $connection = 'bijb';
	protected $table = 'struktur';
	
    protected $fillable   = [
		'nama_struktur', 'parent_id', 'kode_struktur'
	];
}