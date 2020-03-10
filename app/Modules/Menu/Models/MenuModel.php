<?php namespace App\Modules\Menu\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Menu\Transformers\MenuTransformer;

class MenuModel extends Model {
	
	use SoftDeletes;

	public $transformer = MenuTransformer::class;
	
    protected $table = 'menus';
    protected $fillable   = [
        'parent_id', 'name', 'url', 'component', 'modules', 'show', 'categories', 'icon' , 'order', 'function', 'status'
	];
	
	protected $dates = ['deleted_at'];
	
	public function scopeCategories($query, $category) 
	{
		return $query->where('categories', $category);
	}
	
	public function role() 
	{
		return $this->belongsToMany('App\Modules\Role\Models\RoleModel','menu_roles','menu_id','role_id')
					->withPivot('authority_read', 'authority_create', 'authority_update', 'authority_delete', 'authority_import', 'authority_export', 'authority_approve', 'authority_disposition', 'authority_data')
					->withTimestamps();
	}
}