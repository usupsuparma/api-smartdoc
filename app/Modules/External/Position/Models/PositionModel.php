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
}