<?php namespace App\Modules\SpecialDivisionOutgoing\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SpecialDivisionOutgoing\Transformers\SpecialDivisionOutgoingTransformer;
use App\Modules\External\Organization\Models\OrganizationModel;

class SpecialDivisionOutgoingModel extends Model 
{
	use SoftDeletes;

	public $transformer = SpecialDivisionOutgoingTransformer::class;
	
	protected $table = 'special_division_outgoing';
	
    protected $fillable   = [
		'structure_id'
	];
	
	public function structure()
	{
		return $this->belongsTo(OrganizationModel::class, 'structure_id');
	}
	
	public function scopeFindByStructure($query, $type_id) {
		return $query->where('structure_id', $type_id)->exists();
	}
	
	protected $dates = ['deleted_at'];
}