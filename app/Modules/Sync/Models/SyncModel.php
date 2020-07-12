<?php namespace App\Modules\Sync\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\Sync\Transformers\SyncTransformer;
use App\Modules\User\Models\UserModel;

class SyncModel extends Model
{

	public $transformer = SyncTransformer::class;
	
	protected $table = 'syncs';
	
    protected $fillable   = [
		'user_id', 'description'
	];
	
	public function user()
	{
		return $this->belongsTo(UserModel::class, 'user_id');
	}
}