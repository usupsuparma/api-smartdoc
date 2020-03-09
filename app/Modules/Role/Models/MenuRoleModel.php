<?php namespace App\Modules\Role\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;

class MenuRoleModel extends Model
{
	protected $table = 'menu_roles';
	
    protected $fillable   = [
        'menu_id',
        'role_id',
        'authority_read', 
		'authority_create', 
		'authority_update', 
		'authority_delete', 
		'authority_import', 
		'authority_export', 
		'authority_approve', 
		'authority_disposition', 
		'authority_data'
    ];
}
