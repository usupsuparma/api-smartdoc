<?php namespace App\Modules\Review\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\External\Organization\Models\OrganizationModel;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Review\Models\ReviewModel;
use App\Modules\Review\Transformers\ReviewDetailTransformer;

class ReviewDetailModel extends Model
{

	public $transformer = ReviewDetailTransformer::class;
	
	protected $table = 'review_details';
	
    protected $fillable   = [
		'review_id', 'structure_id', 'order'
	];
	
	public function reviews()
	{
		return $this->belongsTo(ReviewModel::class, 'review_id');
	}
	
	public function organizations()
	{
		return $this->belongsTo(OrganizationModel::class, 'structure_id');
	}
	
	public function scopeByReview($query, $review_id)
	{
		return $query->where('review_id', $review_id)->get();
	}
	
	public function scopeCheckOrder($query, $review_id)
	{
		return $query->where([
			'review_id' => $review_id
		]);
	}
	
}