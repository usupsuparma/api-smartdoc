<?php namespace App\Modules\Role\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Role\Transformers\RoleTransformer;

class RoleModel extends Model 
{
	
	use SoftDeletes;

	public $transformer = RoleTransformer::class;
	
	protected $table = 'roles';
	
    protected $fillable   = [
		'name', 'categories', 'publisher', 'status'
	];
	
	protected $dates = ['deleted_at'];
	
	public function menu()
    {
        return $this->belongsToMany('App\Modules\Menu\Models\MenuModel','App\Modules\Role\Models\MenuRoleModel','role_id','menu_id')
        	->withTimestamps()->withPivot(
        		'authority_read', 
        		'authority_create', 
        		'authority_update', 
        		'authority_delete', 
        		'authority_import', 
        		'authority_export', 
        		'authority_approve', 
        		'authority_disposition', 
        		'authority_data'
        	);
	}
	
	public function scopeOptions($query, $default = NULL)
    {
        $list = [];

        foreach ($query->orderBy('name')->get() as $dt) {
            $list[] = [
				'id' => $dt->id,
				'name' => $dt->name,
			];
		}
		
		return $list;
	}
	
	public function scopeIsPublisher($query)
    {
        return $query->where('publisher', true);
	}
	
	protected static function boot()
	{
	   parent::boot();

	   static::deleting(function($model)
	   {
	     $model->menu()->detach();
	   });
	}
	
}
