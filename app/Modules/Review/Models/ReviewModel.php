<?php namespace App\Modules\Review\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\Review\Models\ReviewDetailModel;
use App\Modules\Review\Transformers\ReviewTransformer;

class ReviewModel extends Model
{

	public $transformer = ReviewTransformer::class;
	
	protected $table = 'reviews';
	
    protected $fillable   = [
		'code', 'name', 'status'
	];
	
	public function details()
	{
		return $this->hasMany(ReviewDetailModel::class, 'review_id');
	}
	
}