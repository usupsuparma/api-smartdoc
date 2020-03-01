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
	
    protected $table = 'smc_menus';
    protected $fillable   = [
        'parent_id', 'name', 'url', 'categories', 'icon' , 'order', 'function', 'status'
	];
	
	protected $dates = ['deleted_at'];
	
	public function scopeCategories($query, $category) 
	{
		return $query->where('categories', $category);
	}
}