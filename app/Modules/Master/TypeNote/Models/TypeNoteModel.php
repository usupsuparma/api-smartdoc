<?php namespace App\Modules\Master\TypeNote\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Master\TypeNote\Transformers\TypeNoteTransformer;

class TypeNoteModel extends Model 
{
	use SoftDeletes;

	public $transformer = TypeNoteTransformer::class;
	
	protected $table = 'type_notes';
	
    protected $fillable   = [
		'code', 'name', 'status'
	];
	
	protected $dates = ['deleted_at'];
	
}