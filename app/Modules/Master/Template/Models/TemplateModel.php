<?php namespace App\Modules\Master\Template\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Master\Template\Transformers\TemplateTransformer;
use App\Modules\Master\Type\Models\TypeModel;

class TemplateModel extends Model 
{
	use SoftDeletes;

	public $transformer = TemplateTransformer::class;
	
	protected $table = 'templates';
	
    protected $fillable   = [
		'name', 'type_id', 'template', 'status'
	];
	
	protected $dates = ['deleted_at'];
	
	public function type()
	{
		return $this->belongsTo(TypeModel::class, 'type_id')
					->select('id', 'code', 'name');
	}
	
}