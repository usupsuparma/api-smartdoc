<?php namespace App\Modules\Master\Type\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Master\Type\Transformers\TypeTransformer;

class TypeModel extends Model 
{
	use SoftDeletes;

	public $transformer = TypeTransformer::class;
	
	protected $table = 'types';
	
    protected $fillable   = [
		'name', 'status'
	];
	
	protected $dates = ['deleted_at'];
	
}